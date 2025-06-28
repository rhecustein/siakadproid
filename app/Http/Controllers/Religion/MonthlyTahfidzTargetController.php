<?php

namespace App\Http\Controllers\Religion;

use App\Http\Controllers\Controller;
use App\Models\MonthlyTahfidzTarget;
use App\Models\Student;
use Illuminate\Http\Request;

class MonthlyTahfidzTargetController extends Controller
{
    public function index()
    {
        $targets = MonthlyTahfidzTarget::with('student')->latest()->get();
        return view('tahfidz.monthly.index', compact('targets'));
    }

    public function create()
    {
        return view('tahfidz.monthly.create', [
            'students' => Student::all(),
        ]);
    }

    public function edit($id)
    {
        $target = MonthlyTahfidzTarget::findOrFail($id);
        $students = Student::orderBy('name')->get();

        return view('tahfidz.monthly.edit', [
            'target' => $target,
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|digits:4',
            'month' => 'required|integer|min:1|max:12',
            'target_juz' => 'required|integer|min:0',
            'achieved_juz' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        MonthlyTahfidzTarget::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'year' => $request->year,
                'month' => $request->month,
            ],
            $request->only(['target_juz', 'achieved_juz', 'note'])
        );

        return redirect()->route('religion.monthly-tahfidz-targets.index')->with('success', 'Data tahfidz bulanan berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $target = MonthlyTahfidzTarget::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'month' => 'required|integer|between:1,12',
            'target_juz' => 'required|integer|min:0',
            'achieved_juz' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        // Cek kombinasi unik: student + year + month (selain dirinya sendiri)
        $duplicate = MonthlyTahfidzTarget::where('student_id', $request->student_id)
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->where('id', '!=', $target->id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors([
                'student_id' => 'Data tahfidz bulan tersebut untuk siswa ini sudah ada.'
            ])->withInput();
        }

        $target->update($request->only([
            'student_id', 'year', 'month', 'target_juz', 'achieved_juz', 'note'
        ]));

        return redirect()
            ->route('religion.monthly-tahfidz-targets.index')
            ->with('success', 'Data tahfidz bulanan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $target = MonthlyTahfidzTarget::findOrFail($id);
        $target->delete();

        return redirect()
            ->route('religion.monthly-tahfidz-targets.index')
            ->with('success', 'Data tahfidz bulanan berhasil dihapus.');
    }
}
