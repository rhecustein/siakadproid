<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\HomeroomAssignment;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeroomAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = HomeroomAssignment::with(['teacher', 'classroom', 'academicYear'])
            ->when($request->academic_year_id, fn ($q) => $q->where('academic_year_id', $request->academic_year_id))
            ->when($request->classroom_id, fn ($q) => $q->where('classroom_id', $request->classroom_id))
            ->when($request->teacher_id, fn ($q) => $q->where('teacher_id', $request->teacher_id))
            ->orderByDesc('academic_year_id')
            ->orderBy('classroom_id')
            ->paginate(10); // Menggunakan paginate untuk pagination

        // Data untuk filter dropdown
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();
        $classrooms = Classroom::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('admin.masters.homeroom.index', compact('assignments', 'teachers', 'classrooms', 'academicYears'));
    }

    public function create()
    {
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();
        $classrooms = Classroom::with('level')->orderBy('name')->get(); // Load level juga jika dibutuhkan di view
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('admin.masters.homeroom.create', compact('teachers', 'classrooms', 'academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'note' => 'nullable|string|max:255',
        ]);

        // Cek apakah sudah ada wali kelas aktif untuk kelas + tahun ajaran tersebut
        $exists = HomeroomAssignment::where('classroom_id', $request->classroom_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('is_active', true) // Hanya cek yang aktif jika ada konsep penugasan non-aktif sebelumnya
            ->exists();

        if ($exists) {
            return back()->withErrors(['classroom_id' => 'Kelas ini sudah memiliki wali kelas aktif untuk tahun ajaran tersebut.'])->withInput();
        }

        // Opsional: Nonaktifkan penugasan sebelumnya untuk guru yang sama di tahun ajaran yang sama
        // Jika Anda hanya ingin satu penugasan aktif per guru per tahun ajaran
        // HomeroomAssignment::where('teacher_id', $request->teacher_id)
        //     ->where('academic_year_id', $request->academic_year_id)
        //     ->update(['is_active' => false]);


        HomeroomAssignment::create([
            'teacher_id' => $request->teacher_id,
            'classroom_id' => $request->classroom_id,
            'academic_year_id' => $request->academic_year_id,
            'assigned_at' => now(), // Atau ambil dari input jika ada
            'is_active' => true,
            'note' => $request->note,
        ]);

        return redirect()->route('academic.homeroom.index')->with('success', 'Penugasan wali kelas berhasil ditambahkan.');
    }

    public function edit(HomeroomAssignment $homeroom) // Menggunakan Route Model Binding
    {
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();
        $classrooms = Classroom::with('level')->orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('admin.masters.homeroom.edit', compact('homeroom', 'teachers', 'classrooms', 'academicYears'));
    }

    public function update(Request $request, HomeroomAssignment $homeroom) // Menggunakan Route Model Binding
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'note' => 'nullable|string|max:255',
            'is_active' => 'boolean', // Tambahkan ini jika Anda mengizinkan perubahan status aktif dari form edit
        ]);

        // Cek jika perubahan classroom + academic_year menyebabkan duplikasi (kecuali untuk entri itu sendiri)
        $exists = HomeroomAssignment::where('classroom_id', $request->classroom_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('is_active', true) // Hanya cek yang aktif
            ->where('id', '!=', $homeroom->id) // Abaikan entri yang sedang diedit
            ->exists();

        if ($exists) {
            return back()->withErrors(['classroom_id' => 'Kelas ini sudah memiliki wali kelas aktif untuk tahun ajaran tersebut.'])->withInput();
        }

        $homeroom->update([
            'teacher_id' => $request->teacher_id,
            'classroom_id' => $request->classroom_id,
            'academic_year_id' => $request->academic_year_id,
            'note' => $request->note,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $homeroom->is_active, // Update is_active jika ada di request
        ]);

        return redirect()->route('academic.homeroom.index')->with('success', 'Penugasan wali kelas berhasil diperbarui.');
    }

    public function destroy(HomeroomAssignment $homeroom) // Menggunakan Route Model Binding
    {
        $homeroom->delete();
        return redirect()->route('academic.homeroom.index')->with('success', 'Penugasan wali kelas berhasil dihapus.');
    }
}