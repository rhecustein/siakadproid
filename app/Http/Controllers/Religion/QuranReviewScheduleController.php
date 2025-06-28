<?php

namespace App\Http\Controllers\Religion;;

use App\Http\Controllers\Controller;
use App\Models\QuranReviewSchedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use Illuminate\Http\Request;

class QuranReviewScheduleController extends Controller
{
    public function index()
    {
        $schedules = QuranReviewSchedule::with(['student', 'teacher', 'semester'])
            ->orderBy('day')->orderBy('time')->get();

        return view('tahfidz.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('tahfidz.schedules.create', [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'teacher_id'    => 'nullable|exists:teachers,id',
            'day'           => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,ahad',
            'time'          => 'required',
            'target_surah'  => 'required|string',
            'ayat_start'    => 'nullable|string',
            'ayat_end'      => 'nullable|string',
            'note'          => 'nullable|string',
            'status'        => 'required|in:aktif,selesai,batal',
            'semester_id'   => 'nullable|exists:semesters,id',
        ]);

        QuranReviewSchedule::create($validated);

        return redirect()->route('tahfidz.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(QuranReviewSchedule $quranReviewSchedule)
    {
        return view('tahfidz.schedules.edit', [
            'schedule' => $quranReviewSchedule,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function update(Request $request, QuranReviewSchedule $quranReviewSchedule)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'teacher_id'    => 'nullable|exists:teachers,id',
            'day'           => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,ahad',
            'time'          => 'required',
            'target_surah'  => 'required|string',
            'ayat_start'    => 'nullable|string',
            'ayat_end'      => 'nullable|string',
            'note'          => 'nullable|string',
            'status'        => 'required|in:aktif,selesai,batal',
            'semester_id'   => 'nullable|exists:semesters,id',
        ]);

        $quranReviewSchedule->update($validated);

        return redirect()->route('tahfidz.schedules.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(QuranReviewSchedule $quranReviewSchedule)
    {
        $quranReviewSchedule->delete();

        return redirect()->route('tahfidz.schedules.index')->with('success', 'Jadwal dihapus.');
    }
}
