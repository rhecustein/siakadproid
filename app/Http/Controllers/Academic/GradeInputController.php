<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\GradeInput;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Http\Request;

class GradeInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeInputs = GradeInput::with(['semester', 'teacher', 'subject', 'classroom'])
                          ->latest()
                          ->get();

        return view('academics.grade_inputs.index', compact('gradeInputs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semesters = Semester::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classrooms = Classroom::all();

        return view('academics.grade_inputs.create', compact('semesters', 'teachers', 'subjects', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester_id'   => 'required|exists:semesters,id',
            'teacher_id'    => 'required|exists:teachers,id',
            'subject_id'    => 'required|exists:subjects,id',
            'classroom_id'  => 'required|exists:classrooms,id',
            'date'          => 'required|date',
            'topic'         => 'nullable|string|max:255',
        ]);

        GradeInput::create($validated);

        return redirect()->route('academic.grade-inputs.index')
                         ->with('success', 'Grade input berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeInput $gradeInput)
    {
        return view('academics.grade_inputs.show', compact('gradeInput'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeInput $gradeInput)
    {
        $semesters = Semester::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classrooms = Classroom::all();

        return view('academics.grade_inputs.edit', compact('gradeInput', 'semesters', 'teachers', 'subjects', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeInput $gradeInput)
    {
        $validated = $request->validate([
            'semester_id'   => 'required|exists:semesters,id',
            'teacher_id'    => 'required|exists:teachers,id',
            'subject_id'    => 'required|exists:subjects,id',
            'classroom_id'  => 'required|exists:classrooms,id',
            'date'          => 'required|date',
            'topic'         => 'nullable|string|max:255',
        ]);

        $gradeInput->update($validated);

        return redirect()->route('academic.grade-inputs.index')
                         ->with('success', 'Grade input berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeInput $gradeInput)
    {
        $gradeInput->delete();

        return redirect()->route('academic.grade-inputs.index')
                         ->with('success', 'Grade input berhasil dihapus.');
    }
}
