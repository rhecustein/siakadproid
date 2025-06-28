<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamScore;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;

class ExamScoreController extends Controller
{
    public function index(Request $request)
    {
        $scores = ExamScore::with(['student', 'subject', 'semester'])
            ->when($request->semester_id, fn($q) => $q->where('semester_id', $request->semester_id))
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->get();

        return view('academics.exam_scores.index', [
            'scores' => $scores,
            'subjects' => Subject::all(),
            'semesters' => Semester::all(),
            'types' => ['PAS', 'PAT', 'UTS', 'UAS'],
        ]);
    }

    public function create()
    {
        return view('academics.exam_scores.create', [
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'semesters' => Semester::all(),
            'types' => ['PAS', 'PAT', 'UTS', 'UAS'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:PAS,PAT,UTS,UAS',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        ExamScore::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'semester_id' => $request->semester_id,
                'type' => $request->type,
            ],
            ['score' => $request->score]
        );

        return redirect()->route('exam-scores.index')->with('success', 'Nilai ujian berhasil disimpan.');
    }

    public function edit($id)
    {
        $score = ExamScore::findOrFail($id);

        return view('academics.exam_scores.edit', [
            'score' => $score,
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'semesters' => Semester::all(),
            'types' => ['PAS', 'PAT', 'UTS', 'UAS'],
        ]);
    }

    public function update(Request $request, $id)
    {
        $score = ExamScore::findOrFail($id);

        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $score->update([
            'score' => $request->score,
        ]);

        return redirect()->route('exam-scores.index')->with('success', 'Nilai ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $score = ExamScore::findOrFail($id);
        $score->delete();

        return redirect()->route('exam-scores.index')->with('success', 'Nilai ujian berhasil dihapus.');
    }
}
