<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderByDesc('year')->paginate(10);
        return view('admin.masters.academic_years.index', compact('years'));
    }

    public function create()
    {
        $academicYear = new AcademicYear();
        return view('admin.masters.academic_years.create', compact('academicYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|unique:academic_years,year',
        ]);

        AcademicYear::create([
            'year' => $request->year,
            'is_active' => false,
        ]);

        return redirect()->route('academic.academic-years.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('admin.masters.academic_years.edit', compact('academicYear'));
    }

    public function update(Request $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        $request->validate([
            'year' => 'required|string|unique:academic_years,year,' . $academicYear->id,
        ]);

        $academicYear->update([
            'year' => $request->year,
        ]);

        return redirect()->route('academic.academic-years.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();

        return redirect()->route('academic.academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function activate($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        AcademicYear::query()->update(['is_active' => false]);
        $academicYear->update(['is_active' => true]);

        return redirect()->route('academic.academic-years.index')->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}
