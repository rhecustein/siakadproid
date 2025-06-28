<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\GradeLevel;
use App\Models\ParentModel; // asumsi nama model 'Parent' disesuaikan

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'school', 'grade', 'parent']);

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
        }

        $students = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $schools = School::all();
        $users = User::all();
        $grades = GradeLevel::all();
        $parents = ParentModel::all();

        return view('students.create', compact('schools', 'users', 'grades', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'parent_id' => 'nullable|exists:parents,id',
            'nis' => 'nullable|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'religion' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
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

        return redirect()->route('core.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $schools = School::all();
        $users = User::all();
        $grades = GradeLevel::all();
        $parents = ParentModel::all();

        return view('students.edit', compact('student', 'schools', 'users', 'grades', 'parents'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'parent_id' => 'nullable|exists:parents,id',
            'nis' => "nullable|unique:students,nis,{$student->id}",
            'nisn' => "nullable|unique:students,nisn,{$student->id}",
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'religion' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
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

        return redirect()->route('core.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('core.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
