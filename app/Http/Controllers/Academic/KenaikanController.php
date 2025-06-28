<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Semester;
use App\Models\SchoolYear;

class KenaikanController extends Controller
{
    public function index(Request $request)
    {
        $schoolYears = SchoolYear::all();
        $semesters = Semester::all();
        $classrooms = Classroom::all();

        $students = Student::with(['classroom', 'enrollments'])
            ->when($request->school_year_id, fn($q) => $q->whereHas('enrollments', fn($e) =>
                $e->where('school_year_id', $request->school_year_id)))
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->get();

        return view('academics.promotions.index', compact('students', 'schoolYears', 'semesters', 'classrooms'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'next_classroom_id' => 'required|exists:classrooms,id',
        ]);

        foreach ($request->student_ids as $id) {
            $student = Student::find($id);
            if ($student) {
                $student->classroom_id = $request->next_classroom_id;
                $student->save();
            }
        }

        return redirect()->route('academic.promotions.index')
            ->with('success', 'Siswa berhasil dinaikkan ke kelas berikutnya.');
    }
}
