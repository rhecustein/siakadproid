<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\HomeroomAssignment;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class HomeroomAssignmentController extends Controller
{
    public function index()
    {
        $assignments = HomeroomAssignment::with(['teacher', 'classroom', 'academicYear'])
            ->orderByDesc('academic_year_id')
            ->get();

        return view('admin.masters.homeroom.index', compact('assignments'));
    }

    public function create()
    {
        $teachers = Teacher::where('is_active', true)->get();
        $classrooms = Classroom::with('academicYear')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('admin.masters.homeroom.create', compact('teachers', 'classrooms', 'academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Cek apakah sudah ada wali untuk kelas + tahun ajaran tersebut
        $exists = HomeroomAssignment::where('classroom_id', $request->classroom_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['classroom_id' => 'This classroom already has a homeroom teacher in that academic year.'])->withInput();
        }

        HomeroomAssignment::create([
            'teacher_id' => $request->teacher_id,
            'classroom_id' => $request->classroom_id,
            'academic_year_id' => $request->academic_year_id,
            'assigned_at' => now(),
            'is_active' => true,
            'note' => $request->note,
        ]);

        return redirect()->route('master.homeroom.index')->with('success', 'Homeroom teacher assigned.');
    }

    public function edit(HomeroomAssignment $homeroom)
    {
        $teachers = Teacher::where('is_active', true)->get();
        $classrooms = Classroom::with('academicYear')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('admin.masters.homeroom.edit', compact('homeroom', 'teachers', 'classrooms', 'academicYears'));
    }

    public function update(Request $request, HomeroomAssignment $homeroom)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Cek jika perubahan classroom + academic_year menyebabkan duplikasi
        $exists = HomeroomAssignment::where('classroom_id', $request->classroom_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('id', '!=', $homeroom->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['classroom_id' => 'This classroom already has a homeroom teacher in that academic year.'])->withInput();
        }

        $homeroom->update([
            'teacher_id' => $request->teacher_id,
            'classroom_id' => $request->classroom_id,
            'academic_year_id' => $request->academic_year_id,
            'note' => $request->note,
        ]);

        return redirect()->route('master.homeroom.index')->with('success', 'Homeroom assignment updated.');
    }

    public function destroy(HomeroomAssignment $homeroom)
    {
        $homeroom->delete();
        return redirect()->route('master.homeroom.index')->with('success', 'Homeroom assignment removed.');
    }
}
