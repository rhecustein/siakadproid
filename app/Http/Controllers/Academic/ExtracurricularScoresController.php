<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ExtracurricularScores;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ExtracurricularScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = ExtracurricularScores::with(['student', 'semester', 'extracurricular'])->latest()->get();
        return view('academics.grades.extracurricular.index', compact('scores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academics.grades.extracurricular.create', [
            'semesters' => Semester::all(),
            'students' => Student::all(),
            'extracurriculars' => Extracurricular::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester_id'         => 'required|exists:semesters,id',
            'student_id'          => 'required|exists:students,id',
            'extracurricular_id'  => 'required|exists:extracurriculars,id',
            'score'               => 'required|numeric|min:0|max:100',
            'description'         => 'nullable|string|max:255',
        ]);

        ExtracurricularScores::create($request->all());

        return redirect()->route('academic.grades.extracurricular.index')
            ->with('success', 'Nilai ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExtracurricularScores $extracurricularScores)
    {
        return view('academics.grades.extracurricular.edit', [
            'score' => $extracurricularScores,
            'semesters' => Semester::all(),
            'students' => Student::all(),
            'extracurriculars' => Extracurricular::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExtracurricularScores $extracurricularScores)
    {
        $request->validate([
            'semester_id'         => 'required|exists:semesters,id',
            'student_id'          => 'required|exists:students,id',
            'extracurricular_id'  => 'required|exists:extracurriculars,id',
            'score'               => 'required|numeric|min:0|max:100',
            'description'         => 'nullable|string|max:255',
        ]);

        $extracurricularScores->update($request->all());

        return redirect()->route('academic.grades.extracurricular.index')
            ->with('success', 'Nilai ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExtracurricularScores $extracurricularScores)
    {
        $extracurricularScores->delete();

        return redirect()->route('academic.grades.extracurricular.index')
            ->with('success', 'Nilai ekstrakurikuler berhasil dihapus.');
    }
}
