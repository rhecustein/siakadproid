<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Student; // Pastikan model Student sudah diimport
use App\Models\User;
use App\Models\School;
use App\Models\GradeLevel; // Pastikan GradeLevel sudah diimport
use App\Models\StudentParent; // Menggunakan StudentParent yang benar
use App\Models\ClassroomAssignment; // Import untuk eager loading currentClassroom
use App\Models\AcademicYear; // Import untuk mendapatkan tahun ajaran aktif
use Illuminate\Validation\Rule; // Import Rule untuk validasi unik kondisional

class StudentManagementController extends Controller
{
   public function index(Request $request)
    {
        $currentAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        $students = Student::with([
            'user',
            'school',
            'grade',
            'parent',
            'currentClassroomAssignment.classroom.level',
            'currentClassroomAssignment.academicYear'
        ])
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->grade_id, function ($q) use ($request, $currentAcademicYearId) {
            $q->whereHas('currentClassroomAssignment.classroom', function($queryClassroom) use ($request) {
                $queryClassroom->where('grade_id', $request->grade_id);
            });
            $q->whereHas('currentClassroomAssignment', function($queryAssignment) use ($currentAcademicYearId) {
                 $queryAssignment->where('academic_year_id', $currentAcademicYearId);
            });
        })
        ->when($request->gender, function ($q) use ($request) {
            $q->where('gender', $request->gender);
        })
        ->when($request->status, function ($q) use ($request) {
            $q->where('student_status', $request->status);
        })
        ->orderBy('name')
        ->paginate(15);

        $totalStudents = Student::count();
        $activeStudents = Student::where('student_status', 'aktif')->count();
        $maleStudents = Student::where('gender', 'L')->count();
        $femaleStudents = Student::where('gender', 'P')->count();

        $schools = School::all();
        $grades = GradeLevel::all();

        return view('students.index', compact('students', 'totalStudents', 'activeStudents', 'maleStudents', 'femaleStudents', 'grades', 'schools'));
    }

    public function create()
    {
        $schools = School::all();
        $availableUsers = User::doesntHave('student')->get(); // Variabel ini yang sudah ada
        $grades = GradeLevel::all();
        $parents = StudentParent::all();

        // --- Perbaikan di sini: gunakan $availableUsers, bukan $users ---
        return view('students.create', compact('schools', 'availableUsers', 'grades', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id',
            'school_id' => 'required|exists:schools,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'parent_id' => 'nullable|exists:student_parents,id',
            'nis' => 'nullable|string|max:20|unique:students,nis',
            'nisn' => 'nullable|string|max:20|unique:students,nisn',
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'religion' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'student_status' => 'required|string|max:50',
            'admission_date' => 'nullable|date',
            'graduation_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['uuid'] = Str::uuid();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        Student::create($validated);

        return redirect()->route('master.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $student->load([
            'user',
            'school',
            'grade',
            'parent',
            'currentClassroomAssignment.classroom.level',
            'currentClassroomAssignment.academicYear'
        ]);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $schools = School::all();
        $users = User::all(); // Ini adalah variabel $users yang Anda gunakan di view edit
        $grades = GradeLevel::all();
        $parents = StudentParent::all();

        $student->loadMissing(['user', 'parent']);

        return view('students.edit', compact('student', 'schools', 'users', 'grades', 'parents'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::unique('students')->ignore($student->id, 'id')],
            'school_id' => 'required|exists:schools,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'parent_id' => 'nullable|exists:student_parents,id',
            'nis' => ['nullable', 'string', 'max:20', Rule::unique('students')->ignore($student->id, 'id')],
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('students')->ignore($student->id, 'id')],
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'religion' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'student_status' => 'required|string|max:50',
            'admission_date' => 'nullable|date',
            'graduation_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $student->update($validated);

        return redirect()->route('master.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        try {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $student->delete();
            return redirect()->route('master.students.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('master.students.index')->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }

    public function searchStudents(Request $request)
    {
        $search = $request->query('q');

        $students = Student::where('name', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%")
                            ->get(['id', 'name', 'nis', 'nisn']);

        return response()->json($students);
    }
}