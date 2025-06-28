<?php

namespace App\Http\Controllers\Religion;

use App\Http\Controllers\Controller;
use App\Models\QuranReading;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuranReadingController extends Controller
{
    public function index()
    {
        $readings = QuranReading::with(['student', 'teacher', 'semester'])->latest('recorded_at')->get();
        return view('tahfidz.readings.index', compact('readings'));
    }

    public function create()
    {
        return view('tahfidz.readings.create', [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recorded_at'    => 'required|date',
            'student_id'     => 'required|exists:students,id',
            'surah'          => 'required|string',
            'ayat_start'     => 'nullable|string',
            'ayat_end'       => 'nullable|string',
            'method'         => 'required|in:langsung,dengan guru,daring',
            'status'         => 'required|in:hadir,tidak hadir,izin,sakit',
            'note'           => 'nullable|string|max:500',
            'teacher_id'     => 'nullable|exists:teachers,id',
            'semester_id'    => 'nullable|exists:semesters,id',
            'attachment'     => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('quran_readings');
        }

        QuranReading::create($validated);

        return redirect()->route('readingsindex')->with('success', 'Data tahfidz berhasil disimpan.');
    }

    public function edit(QuranReading $quranReading)
    {
        return view('tahfidz.readings.edit', [
            'reading' => $quranReading,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function update(Request $request, QuranReading $quranReading)
    {
        $validated = $request->validate([
            'recorded_at'    => 'required|date',
            'student_id'     => 'required|exists:students,id',
            'surah'          => 'required|string',
            'ayat_start'     => 'nullable|string',
            'ayat_end'       => 'nullable|string',
            'method'         => 'required|in:langsung,dengan guru,daring',
            'status'         => 'required|in:hadir,tidak hadir,izin,sakit',
            'note'           => 'nullable|string|max:500',
            'teacher_id'     => 'nullable|exists:teachers,id',
            'semester_id'    => 'nullable|exists:semesters,id',
            'attachment'     => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            if ($quranReading->attachment_path) {
                Storage::delete($quranReading->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('quran_readings');
        }

        $quranReading->update($validated);

        return redirect()->route('readingsindex')->with('success', 'Data tahfidz berhasil diperbarui.');
    }

    public function destroy(QuranReading $quranReading)
    {
        if ($quranReading->attachment_path) {
            Storage::delete($quranReading->attachment_path);
        }

        $quranReading->delete();

        return redirect()->route('readingsindex')->with('success', 'Data tahfidz berhasil dihapus.');
    }
}