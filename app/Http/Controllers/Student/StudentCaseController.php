<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentCase;
use Illuminate\Http\Request;

class StudentCaseController extends Controller
{
    public function index()
    {
        $cases = StudentCase::with(['student', 'reporter'])->latest()->get();
        return view('student_cases.index', compact('cases'));
    }

    public function create()
    {
        return view('student_cases.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reported_at' => 'required|date',
            'case_type' => 'required|string',
            'description' => 'required|string',
            'status' => 'nullable|string',
            'reported_by' => 'nullable|exists:users,id',
        ]);

        StudentCase::create($request->all());

        return redirect()->route('student-cases.index')->with('success', 'Case reported.');
    }

    public function show(StudentCase $studentCase)
    {
        return view('student_cases.show', compact('studentCase'));
    }

    public function edit(StudentCase $studentCase)
    {
        return view('student_cases.edit', compact('studentCase'));
    }

    public function update(Request $request, StudentCase $studentCase)
    {
        $request->validate([
            'reported_at' => 'required|date',
            'case_type' => 'required|string',
            'description' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $studentCase->update($request->all());

        return redirect()->route('student-cases.index')->with('success', 'Case updated.');
    }

    public function destroy(StudentCase $studentCase)
    {
        $studentCase->delete();

        return redirect()->route('student-cases.index')->with('success', 'Case deleted.');
    }
}