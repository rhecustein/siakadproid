<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\GradeDetail;
use App\Models\Student;
use App\Models\GradeInput;
use Illuminate\Http\Request;

class GradeDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeDetails = GradeDetail::with(['student', 'gradeInput'])->latest()->get();
        return view('academics.grade_details.index', compact('gradeDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $gradeInputs = GradeInput::all();

        return view('academics.grade_details.create', compact('students', 'gradeInputs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade_input_id' => 'required|exists:grade_inputs,id',
            'student_id'     => 'required|exists:students,id',
            'score'          => 'required|numeric|min:0|max:100',
            'note'           => 'nullable|string|max:1000',
        ]);

        GradeDetail::create($validated);

        return redirect()->route('academic.grade-details.index')
                         ->with('success', 'Data nilai detail berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeDetail $gradeDetail)
    {
        return view('academics.grade_details.show', compact('gradeDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeDetail $gradeDetail)
    {
        $students = Student::all();
        $gradeInputs = GradeInput::all();

        return view('academics.grade_details.edit', compact('gradeDetail', 'students', 'gradeInputs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeDetail $gradeDetail)
    {
        $validated = $request->validate([
            'grade_input_id' => 'required|exists:grade_inputs,id',
            'student_id'     => 'required|exists:students,id',
            'score'          => 'required|numeric|min:0|max:100',
            'note'           => 'nullable|string|max:1000',
        ]);

        $gradeDetail->update($validated);

        return redirect()->route('academic.grade-details.index')
                         ->with('success', 'Data nilai detail berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(GradeDetail $gradeDetail)
    {
        $gradeDetail->delete();

        return redirect()->route('academic.grade-details.index')
                         ->with('success', 'Data nilai detail berhasil dihapus.');
    }
}
