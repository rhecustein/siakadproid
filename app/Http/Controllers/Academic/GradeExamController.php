<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeExam;
use App\Models\ExamType;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Student;
use App\Models\AcademicYear;


class GradeExamController extends Controller
{
    public function index(Request $request)
    {
        $gradeExams = GradeExam::with(['student.classroom', 'subject', 'examType', 'academicYear'])
            ->when($request->classroom_id, fn($q) => $q->whereHas('student', fn($s) => $s->where('classroom_id', $request->classroom_id)))
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->when($request->exam_type_id, fn($q) => $q->where('exam_type_id', $request->exam_type_id))
            ->when($request->academic_year_id, fn($q) => $q->where('academic_year_id', $request->academic_year_id))
            ->orderBy('student_id')
            ->get();

        return view('academics.grade_exams.index', [
            'gradeExams' => $gradeExams,
            'classrooms' => Classroom::all(),
            'subjects' => Subject::all(),
            'examTypes' => ExamType::all(),
            'academicYears' => AcademicYear::all(),
        ]);
    }
    public function input(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required',
            'subject_id' => 'required',
            'exam_type_id' => 'required',
            'academic_year_id' => 'required',
        ]);

        $students = Student::where('classroom_id', $request->classroom_id)->get();

        return view('academics.grade_exams.input', [
            'students' => $students,
            'subject_id' => $request->subject_id,
            'exam_type_id' => $request->exam_type_id,
            'academic_year_id' => $request->academic_year_id,
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->grades as $student_id => $grade) {
            GradeExam::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'subject_id' => $request->subject_id,
                    'exam_type_id' => $request->exam_type_id,
                    'academic_year_id' => $request->academic_year_id,
                ],
                ['grade' => $grade]
            );
        }

        return redirect()->route('grade-exams.index')->with('success', 'Nilai berhasil disimpan.');
    }
}
