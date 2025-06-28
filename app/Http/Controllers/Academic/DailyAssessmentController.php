<?php

namespace App\Http\Controllers\Academic;
use App\Http\Controllers\Controller;

use App\Models\DailyAssessment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\AssessmentCriteria;
use App\Models\AssessmentScore;
use Illuminate\Http\Request;

class DailyAssessmentController extends Controller
{
    public function index()
    {
        $assessments = DailyAssessment::with(['student', 'subject', 'teacher', 'classroom'])->latest()->paginate(10);
        return view('academics.assessments.index', compact('assessments'));
    }

    public function create(Request $request)
    {
        $subjects = Subject::all();
        $classrooms = Classroom::all();
        $students = [];

        // Jika user sudah memilih kelas, ambil siswa
        if ($request->filled('classroom_id')) {
            $students = Student::where('classroom_id', $request->classroom_id)->get();
        }

        return view('academics.assessments.create', compact('subjects', 'classrooms', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'score' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $assessment = DailyAssessment::create($data);

        // Optional: Simpan nilai rubrik jika ada
        if ($request->has('criteria_scores')) {
            foreach ($request->criteria_scores as $criteria_id => $score) {
                AssessmentScore::create([
                    'daily_assessment_id' => $assessment->id,
                    'criteria_id' => $criteria_id,
                    'score' => $score,
                ]);
            }
        }

        return redirect()->route('assessments.index')->with('success', 'Penilaian harian berhasil disimpan.');
    }

    public function show(DailyAssessment $assessment)
    {
        $assessment->load('student', 'subject', 'teacher', 'classroom', 'scores.criteria');
        return view('academics.assessments.show', compact('assessment'));
    }
}