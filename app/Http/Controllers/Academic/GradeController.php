<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student', 'subject', 'classroom']);

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $grades = $query->latest()->get();
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('academics.grades.index', compact('grades', 'classrooms', 'subjects'));
    }

    public function create()
    {
        $students = Student::all();
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('academics.grades.create', compact('students', 'classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'classroom_id'  => 'required|exists:classrooms,id',
            'subject_id'    => 'required|exists:subjects,id',
            'topic'         => 'nullable|string|max:255',
            'date'          => 'required|date',
            'nilai_tugas'   => 'nullable|numeric|min:0|max:100',
            'nilai_uts'     => 'nullable|numeric|min:0|max:100',
            'nilai_uas'     => 'nullable|numeric|min:0|max:100',
        ]);

        $rata_rata = collect([
            $request->nilai_tugas,
            $request->nilai_uts,
            $request->nilai_uas
        ])->filter()->avg();

        Grade::create([
            'uuid'          => Str::uuid(),
            'student_id'    => $validated['student_id'],
            'classroom_id'  => $validated['classroom_id'],
            'subject_id'    => $validated['subject_id'],
            'topic'         => $validated['topic'],
            'date'          => $validated['date'],
            'nilai_tugas'   => $validated['nilai_tugas'],
            'nilai_uts'     => $validated['nilai_uts'],
            'nilai_uas'     => $validated['nilai_uas'],
            'rata_rata'     => $rata_rata,
            'status_lulus'  => $rata_rata >= 60,
        ]);

        return redirect()->route('academic.grades.daily.index')->with('success', 'Nilai harian berhasil ditambahkan.');
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('academics.grades.edit', compact('grade', 'students', 'classrooms', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'classroom_id'  => 'required|exists:classrooms,id',
            'subject_id'    => 'required|exists:subjects,id',
            'topic'         => 'nullable|string|max:255',
            'date'          => 'required|date',
            'nilai_tugas'   => 'nullable|numeric|min:0|max:100',
            'nilai_uts'     => 'nullable|numeric|min:0|max:100',
            'nilai_uas'     => 'nullable|numeric|min:0|max:100',
        ]);

        $rata_rata = collect([
            $request->nilai_tugas,
            $request->nilai_uts,
            $request->nilai_uas
        ])->filter()->avg();

        $grade->update([
            'student_id'    => $validated['student_id'],
            'classroom_id'  => $validated['classroom_id'],
            'subject_id'    => $validated['subject_id'],
            'topic'         => $validated['topic'],
            'date'          => $validated['date'],
            'nilai_tugas'   => $validated['nilai_tugas'],
            'nilai_uts'     => $validated['nilai_uts'],
            'nilai_uas'     => $validated['nilai_uas'],
            'rata_rata'     => $rata_rata,
            'status_lulus'  => $rata_rata >= 60,
        ]);

        return redirect()->route('academic.grades.daily.index')->with('success', 'Nilai harian berhasil diperbarui.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('academic.grades.daily.index')->with('success', 'Nilai harian berhasil dihapus.');
    }
}
