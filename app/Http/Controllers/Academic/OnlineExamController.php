<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\OnlineExam;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class OnlineExamController extends Controller
{
    public function index()
    {
        $exams = OnlineExam::with(['subject', 'classroom', 'teacher'])->latest()->get();
        return view('academics.online_exams.index', compact('exams'));
    }

    public function create()
    {
        return view('academics.online_exams.create', [
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        OnlineExam::create($validated);

        return redirect()->route('online-exams.index')
            ->with('success', 'Ujian online berhasil ditambahkan.');
    }

    public function show($id)
    {
        $exam = OnlineExam::with(['subject', 'classroom', 'teacher'])->findOrFail($id);
        return view('academics.online_exams.show', compact('exam'));
    }

    public function edit($id)
    {
        $exam = OnlineExam::findOrFail($id);

        return view('academics.online_exams.edit', [
            'exam' => $exam,
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $exam = OnlineExam::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        $exam->update($validated);

        return redirect()->route('online-exams.index')
            ->with('success', 'Data ujian online berhasil diperbarui.');
    }

    public function destroy($id)
    {
        OnlineExam::destroy($id);

        return redirect()->route('online-exams.index')
            ->with('success', 'Data ujian online berhasil dihapus.');
    }
}
