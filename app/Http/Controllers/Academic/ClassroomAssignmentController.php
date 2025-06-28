<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassroomAssignment;
use App\Models\GradeLevel;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\ClassEnrollment;
use Illuminate\Http\Request;

class ClassroomAssignmentController extends Controller
{
    public function index()
    {
        $assignments = ClassroomAssignment::with([
            'gradeLevel',
            'homeroomTeacher',
            'classroom',
            'classEnrollment'
        ])->paginate(20);

        return view('academics.classroom_assignments.index', compact('assignments'));
    }

    public function create()
    {
        $gradeLevels = GradeLevel::all();
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $classEnrollments = ClassEnrollment::all();

        return view('academics.classroom_assignments.create', compact(
            'gradeLevels',
            'teachers',
            'classrooms',
            'classEnrollments'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_level_id' => 'required|exists:grade_levels,id',
            'class_enrollments_id' => 'required|exists:class_enrollments,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'name' => 'required|string|max:10',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        ClassroomAssignment::create($request->only([
            'grade_level_id',
            'class_enrollments_id',
            'classroom_id',
            'name',
            'homeroom_teacher_id',
        ]));

        return redirect()->route('academic.classroom-assignments.index')
            ->with('success', 'Kelas paralel berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $assignment = ClassroomAssignment::with([
            'gradeLevel',
            'homeroomTeacher',
            'classroom',
            'classEnrollment'
        ])->findOrFail($id);

        return view('academics.classroom_assignments.show', compact('assignment'));
    }

    public function edit(string $id)
    {
        $assignment = ClassroomAssignment::findOrFail($id);
        $gradeLevels = GradeLevel::all();
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $classEnrollments = ClassEnrollment::all();

        return view('academics.classroom_assignments.edit', compact(
            'assignment',
            'gradeLevels',
            'teachers',
            'classrooms',
            'classEnrollments'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'grade_level_id' => 'required|exists:grade_levels,id',
            'class_enrollments_id' => 'required|exists:class_enrollments,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'name' => 'required|string|max:10',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $assignment = ClassroomAssignment::findOrFail($id);

        $assignment->update($request->only([
            'grade_level_id',
            'class_enrollments_id',
            'classroom_id',
            'name',
            'homeroom_teacher_id',
        ]));

        return redirect()->route('academic.classroom-assignments.index')
            ->with('success', 'Kelas paralel berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $assignment = ClassroomAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('academic.classroom-assignments.index')
            ->with('success', 'Kelas paralel berhasil dihapus.');
    }
}
