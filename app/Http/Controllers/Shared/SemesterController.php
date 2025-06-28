<?php
namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('schoolYear')->orderByDesc('id')->get();
        return view('admin.masters.semesters.index', compact('semesters'));
    }

    public function create()
    {
        $years = SchoolYear::all();
        return view('admin.masters.semesters.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'name' => 'required|string',
        ]);

        Semester::create([
            'uuid' => Str::uuid(), // generate UUID
            'school_year_id' => $request->school_year_id,
            'name' => $request->name,
            'type' => strtolower($request->name) === 'genap' ? 'genap' : 'ganjil', // auto-pilih type
            'is_active' => false,
        ]);

        return redirect()->route('academic.semesters.index')->with('success', 'Semester ditambahkan.');
    }

    public function edit(Semester $semester)
    {
        $years = SchoolYear::all();
        return view('admin.masters.semesters.edit', compact('semester', 'years'));
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'name' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->is_active) {
            Semester::where('school_year_id', $request->school_year_id)
                ->where('id', '!=', $semester->id)
                ->update(['is_active' => false]);
        }

        $semester->update([
            'school_year_id' => $request->school_year_id,
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('academic.semesters.index')->with('success', 'Semester diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('academic.semesters.index')->with('success', 'Semester dihapus.');
    }
}
