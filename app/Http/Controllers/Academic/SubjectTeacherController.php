<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\SubjectTeacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectTeacherController extends Controller
{
    public function index()
    {
        $data = SubjectTeacher::with(['classroom', 'subject', 'teacher'])->get();
        return view('academics.subject_teachers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        SubjectTeacher::updateOrCreate(
            [
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
            ],
            [
                'teacher_id' => $request->teacher_id,
            ]
        );

        return redirect()->back()->with('success', 'Data pengampu berhasil disimpan.');
    }

    public function destroy($id)
    {
        SubjectTeacher::destroy($id);
        return redirect()->back()->with('success', 'Data pengampu berhasil dihapus.');
    }
}
