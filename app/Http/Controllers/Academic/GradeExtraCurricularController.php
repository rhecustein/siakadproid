<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Extracurricular;
use App\Models\ExtracurricularScore;
use App\Models\Semester;

class GradeExtraCurricularController extends Controller
{
    public function index(Request $request)
    {
        $scores = ExtracurricularScore::with(['student', 'extracurricular', 'semester'])
            ->when($request->semester_id, fn($q) => $q->where('semester_id', $request->semester_id))
            ->when($request->extracurricular_id, fn($q) => $q->where('extracurricular_id', $request->extracurricular_id))
            ->get();

        return view('academics.extra_scores.index', [
            'scores' => $scores,
            'extracurriculars' => Extracurricular::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function create()
    {
        return view('academics.extra_scores.create', [
            'students' => Student::all(),
            'extracurriculars' => Extracurricular::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'student_id' => 'required|exists:students,id',
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'score' => 'nullable|numeric|min:0|max:100',
            'note' => 'nullable|string',
        ]);

        ExtracurricularScore::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'extracurricular_id' => $request->extracurricular_id,
                'semester_id' => $request->semester_id,
            ],
            [
                'score' => $request->score,
                'note' => $request->note,
            ]
        );

        return redirect()->route('extra-scores.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit($id)
    {
        $score = ExtracurricularScore::findOrFail($id);

        return view('academics.extra_scores.edit', [
            'score' => $score,
            'students' => Student::all(),
            'extracurriculars' => Extracurricular::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $score = ExtracurricularScore::findOrFail($id);

        $request->validate([
            'score' => 'nullable|numeric|min:0|max:100',
            'note' => 'nullable|string',
        ]);

        $score->update($request->only('score', 'note'));

        return redirect()->route('extra-scores.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $score = ExtracurricularScore::findOrFail($id);
        $score->delete();

        return redirect()->route('extra-scores.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
