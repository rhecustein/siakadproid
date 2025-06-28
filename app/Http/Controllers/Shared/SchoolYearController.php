<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function index()
    {
        $years = SchoolYear::orderByDesc('id')->get();
        return view('academics.academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('academics.academic_years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:school_years,name',
        ]);

        SchoolYear::create([
            'name' => $request->name,
            'is_active' => false,
        ]);

        return redirect()->route('academic.school-years.index')->with('success', 'Tahun ajaran ditambahkan.');
    }

    public function edit(SchoolYear $schoolYear)
    {
        return view('academics.academic_years.edit', compact('schoolYear'));
    }

    public function update(Request $request, SchoolYear $schoolYear)
    {
        $request->validate([
            'name' => 'required|string|unique:school_years,name,' . $schoolYear->id,
            'is_active' => 'nullable|boolean',
        ]);

        // Jika aktif, nonaktifkan semua lainnya
        if ($request->is_active) {
            SchoolYear::where('id', '!=', $schoolYear->id)->update(['is_active' => false]);
        }

        $schoolYear->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('academic.school-years.index')->with('success', 'Tahun ajaran diperbarui.');
    }

    public function destroy(SchoolYear $schoolYear)
    {
        $schoolYear->delete();
        return redirect()->route('academic.school-years.index')->with('success', 'Tahun ajaran dihapus.');
    }
}
