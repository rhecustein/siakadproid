<?php

namespace App\Http\Controllers\Religion;

use App\Http\Controllers\Controller;
use App\Models\MemorizationSubmission;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemorizationSubmissionController extends Controller
{
    public function index()
    {
        $submissions = MemorizationSubmission::with(['student', 'teacher', 'semester', 'validator'])
            ->latest('recorded_at')->get();

        return view('tahfidz.submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('tahfidz.submissions.create', [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recorded_at'     => 'required|date',
            'student_id'      => 'required|exists:students,id',
            'teacher_id'      => 'nullable|exists:teachers,id',
            'surah'           => 'required|string',
            'ayat_start'      => 'nullable|string',
            'ayat_end'        => 'nullable|string',
            'type'            => 'required|in:ziyadah,murojaah,tilawah',
            'status'          => 'required|in:belum lancar,cukup,baik,sangat baik',
            'score'           => 'nullable|integer|min:0|max:100',
            'note'            => 'nullable|string',
            'semester_id'     => 'nullable|exists:semesters,id',
            'attachment'      => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('memorization_attachments');
        }

        $validated['validated_by'] = Auth::id();
        $validated['is_validated'] = $request->has('is_validated');

        MemorizationSubmission::create($validated);

        return redirect()->route('memorization-submissions.index')->with('success', 'Setoran hafalan berhasil disimpan.');
    }

    public function edit(MemorizationSubmission $memorizationSubmission)
    {
        return view('tahfidz.submissions.edit', [
            'submission' => $memorizationSubmission,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function update(Request $request, MemorizationSubmission $memorizationSubmission)
    {
        $validated = $request->validate([
            'recorded_at'     => 'required|date',
            'student_id'      => 'required|exists:students,id',
            'teacher_id'      => 'nullable|exists:teachers,id',
            'surah'           => 'required|string',
            'ayat_start'      => 'nullable|string',
            'ayat_end'        => 'nullable|string',
            'type'            => 'required|in:ziyadah,murojaah,tilawah',
            'status'          => 'required|in:belum lancar,cukup,baik,sangat baik',
            'score'           => 'nullable|integer|min:0|max:100',
            'note'            => 'nullable|string',
            'semester_id'     => 'nullable|exists:semesters,id',
            'attachment'      => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            if ($memorizationSubmission->attachment_path) {
                Storage::delete($memorizationSubmission->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('memorization_attachments');
        }

        $validated['validated_by'] = Auth::id();
        $validated['is_validated'] = $request->has('is_validated');

        $memorizationSubmission->update($validated);

        return redirect()->route('memorization-submissions.index')->with('success', 'Setoran hafalan berhasil diperbarui.');
    }

    public function destroy(MemorizationSubmission $memorizationSubmission)
    {
        if ($memorizationSubmission->attachment_path) {
            Storage::delete($memorizationSubmission->attachment_path);
        }

        $memorizationSubmission->delete();

        return redirect()->route('memorization-submissions.index')->with('success', 'Setoran hafalan dihapus.');
    }
}