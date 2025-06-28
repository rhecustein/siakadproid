<?php

namespace App\Http\Controllers\Religion;

use App\Http\Controllers\Controller;

use App\Models\TahfidzProgress;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahfidzProgressController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::all();
        $semesters = Semester::all();
        $selectedStudent = $request->student_id;

        $progressList = TahfidzProgress::with(['student', 'semester', 'validator'])
            ->when($selectedStudent, fn($q) => $q->where('student_id', $selectedStudent))
            ->latest('recorded_at')
            ->get();

        return view('tahfidz.progress.index', compact('students', 'semesters', 'progressList', 'selectedStudent'));
    }

    public function create()
    {
        return view('tahfidz.progress.create', [
            'students' => Student::all(),
            'semesters' => Semester::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['validated_by'] = Auth::id();
        $validated['is_final'] = $request->has('is_final');

        TahfidzProgress::create($validated);

        return redirect()->route('religion.tahfidz-progresses.index')->with('success', 'Data progres tahfidz berhasil disimpan.');
    }

    public function edit($id)
    {
        $tahfidzProgress = TahfidzProgress::findOrFail($id);
        $students = Student::all();
        $semesters = Semester::all();
    
        return view('tahfidz.progress.edit', compact('tahfidzProgress', 'students', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TahfidzProgress  $progress
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, TahfidzProgress $progress)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'recorded_at'   => 'required|date',
            'semester_id'   => 'nullable|exists:semesters,id',
            'juz'           => 'required|integer|min:1|max:30',
            'from_surah'    => 'nullable|string|max:100',
            'to_surah'      => 'nullable|string|max:100',
            'from_verse'    => 'nullable|string|max:100',
            'to_verse'      => 'nullable|string|max:100',
            'status'        => 'required|in:belum,proses,hafal',
            'remarks'       => 'nullable|string|max:1000',
        ]);

        $validated['is_final'] = $request->has('is_final');
        $validated['validated_by'] = auth()->id();

        $progress->update($validated);

        return redirect()
            ->route('religion.tahfidz-progresses.index')
            ->with('success', 'Data progres tahfidz berhasil diperbarui.');
    }


    public function destroy(TahfidzProgress $progress)
    {
        $progress->delete();
        return redirect()->route('religion.tahfidz-progresses.index')->with('success', 'Data progres tahfidz berhasil dihapus.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'student_id'    => 'required|exists:students,id',
            'recorded_at'   => 'required|date',
            'juz'           => 'required|integer|min:1|max:30',
            'from_surah'    => 'nullable|string|max:100',
            'to_surah'      => 'nullable|string|max:100',
            'from_verse'    => 'nullable|string|max:10',
            'to_verse'      => 'nullable|string|max:10',
            'remarks'       => 'nullable|string|max:500',
            'status'        => 'required|in:belum,proses,hafal',
            'semester_id'   => 'nullable|exists:semesters,id',
            'is_final'      => 'nullable|boolean',
        ]);
    }
}
