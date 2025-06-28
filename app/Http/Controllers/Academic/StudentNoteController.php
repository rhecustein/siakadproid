<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\StudentNote;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentNoteController extends Controller
{
    public function index()
    {
        $notes = StudentNote::with(['student', 'teacher'])->latest()->paginate(20);
        return view('academics.student_notes.index', compact('notes'));
    }

    public function create()
    {
        $students = Student::all();
        $teachers = Teacher::all();
        return view('academics.student_notes.create', compact('students', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'type' => 'required|string|max:50',
            'note' => 'required|string',
            'date' => 'required|date',
        ]);

        StudentNote::create($request->all());

        return redirect()->route('academic.student-notes.index')->with('success', 'Catatan siswa berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $note = StudentNote::with(['student', 'teacher'])->findOrFail($id);
        return view('academics.student_notes.show', compact('note'));
    }

    public function edit(string $id)
    {
        $note = StudentNote::findOrFail($id);
        $students = Student::all();
        $teachers = Teacher::all();
        return view('academics.student_notes.edit', compact('note', 'students', 'teachers'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'type' => 'required|string|max:50',
            'note' => 'required|string',
            'date' => 'required|date',
        ]);

        $note = StudentNote::findOrFail($id);
        $note->update($request->all());

        return redirect()->route('academic.student-notes.index')->with('success', 'Catatan siswa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $note = StudentNote::findOrFail($id);
        $note->delete();

        return redirect()->route('academic.student-notes.index')->with('success', 'Catatan siswa berhasil dihapus.');
    }
}
