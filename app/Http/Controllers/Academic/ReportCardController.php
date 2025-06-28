<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ReportCard;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $reportCards = ReportCard::with(['student', 'semester', 'classroom'])
            ->when($request->semester_id, fn($q) => $q->where('semester_id', $request->semester_id))
            ->when($request->classroom_id, fn($q) => $q->where('classroom_id', $request->classroom_id))
            ->latest()->get();

        $semesters = Semester::all();
        $classrooms = Classroom::all();

        return view('academics.report_cards.index', compact('reportCards', 'semesters', 'classrooms'));
    }

    public function create()
    {
        return view('academics.report_cards.create', [
            'semesters' => Semester::all(),
            'students' => Student::all(),
            'classrooms' => Classroom::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'finalized' => 'required|boolean',
            'note' => 'nullable|string|max:500',
        ]);

        ReportCard::create($request->all());

        return redirect()->route('academic.report_cards.index')
            ->with('success', 'Rapor siswa berhasil ditambahkan.');
    }

    public function edit(ReportCard $reportCard)
    {
        return view('academics.report_cards.edit', [
            'reportCard' => $reportCard,
            'semesters' => Semester::all(),
            'students' => Student::all(),
            'classrooms' => Classroom::all(),
        ]);
    }

    public function update(Request $request, ReportCard $reportCard)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'finalized' => 'required|boolean',
            'note' => 'nullable|string|max:500',
        ]);

        $reportCard->update($request->all());

        return redirect()->route('academic.report_cards.index')
            ->with('success', 'Rapor siswa berhasil diperbarui.');
    }

    public function destroy(ReportCard $reportCard)
    {
        $reportCard->delete();

        return redirect()->route('academic.report_cards.index')
            ->with('success', 'Rapor siswa berhasil dihapus.');
    }

    public function show(ReportCard $reportCard)
    {
        $student = $reportCard->student;
        $semester = $reportCard->semester;

        $grades = $student->grades()
            ->whereHas('gradeInput', fn($q) => $q->where('semester_id', $semester->id))
            ->with('gradeInput.subject')
            ->get();

        return view('academics.report_cards.show', compact('student', 'grades', 'semester', 'reportCard'));
    }

    public function print(ReportCard $reportCard)
    {
        $student = $reportCard->student;
        $semester = $reportCard->semester;

        $grades = $student->grades()
            ->whereHas('gradeInput', fn($q) => $q->where('semester_id', $semester->id))
            ->with('gradeInput.subject')
            ->get();

        return view('academics.report_cards.print', compact('student', 'grades', 'semester', 'reportCard'));
    }
}
