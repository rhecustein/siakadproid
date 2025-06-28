<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\SchoolYear;
use App\Models\GradeDetail;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeReportController extends Controller
{
    public function index(Request $request)
    {
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $activeSemester = Semester::where('is_active', true)->first();

        $classroomId = $request->input('classroom_id');
        $subjectId = $request->input('subject_id');
        $semesterId = $request->input('semester_id', $activeSemester?->id);

        $grades = collect();
        $students = collect();

        if ($classroomId && $subjectId && $semesterId) {
            $grades = GradeDetail::whereHas('gradeInput', function ($q) use ($semesterId, $classroomId, $subjectId) {
                $q->where('semester_id', $semesterId)
                  ->where('classroom_id', $classroomId)
                  ->where('subject_id', $subjectId);
            })
            ->with(['student', 'gradeInput.subject'])
            ->get()
            ->groupBy('student_id');

            $studentIds = $grades->keys();
            $students = Student::whereIn('id', $studentIds)->with('classroom')->get();
        }

        return view('academics.grade_reports.index', [
            'classrooms' => Classroom::all(),
            'subjects' => Subject::all(),
            'semesters' => $semesters,
            'schoolYears' => $schoolYears,
            'grades' => $grades,
            'students' => $students,
            'selected' => [
                'classroom_id' => $classroomId,
                'subject_id' => $subjectId,
                'semester_id' => $semesterId,
            ]
        ]);
    }
}
