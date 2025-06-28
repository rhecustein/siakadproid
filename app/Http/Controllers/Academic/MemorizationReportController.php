<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\MemorizationReport;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class MemorizationReportController extends Controller
{
    public function index()
    {
        $reports = MemorizationReport::with(['student', 'teacher'])->latest()->get();
        return view('academics.memorization_reports.index', compact('reports'));
    }

    public function create()
    {
        return view('academics.memorization_reports.create', [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'surah' => 'nullable|string',
            'ayat_start' => 'nullable|string',
            'ayat_end' => 'nullable|string',
            'juz' => 'nullable|integer|min:1|max:30',
            'note' => 'nullable|string',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        MemorizationReport::create($request->all());

        return redirect()->route('memorization-reports.index')->with('success', 'Data hafalan berhasil disimpan.');
    }
}
