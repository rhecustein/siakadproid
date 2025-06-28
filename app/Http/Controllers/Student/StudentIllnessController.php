<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentIllness;
use Illuminate\Http\Request;

class StudentIllnessController extends Controller
{
    public function index()
    {
        $illnesses = StudentIllness::with('student')->latest()->get();
        return view('student_illnesses.index', compact('illnesses'));
    }

    public function create()
    {
        return view('student_illnesses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reported_at' => 'required|date',
            'illness_type' => 'required|string',
            'severity' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        StudentIllness::create($request->all());

        return redirect()->route('student-illnesses.index')->with('success', 'Illness record saved.');
    }

    public function show(StudentIllness $studentIllness)
    {
        return view('student_illnesses.show', compact('studentIllness'));
    }

    public function edit(StudentIllness $studentIllness)
    {
        return view('student_illnesses.edit', compact('studentIllness'));
    }

    public function update(Request $request, StudentIllness $studentIllness)
    {
        $request->validate([
            'reported_at' => 'required|date',
            'illness_type' => 'required|string',
            'severity' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $studentIllness->update($request->all());

        return redirect()->route('student-illnesses.index')->with('success', 'Illness record updated.');
    }

    public function destroy(StudentIllness $studentIllness)
    {
        $studentIllness->delete();

        return redirect()->route('student-illnesses.index')->with('success', 'Illness record deleted.');
    }
}
