<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\GradeLevel;
use App\Models\School;
use App\Models\StudentParent;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with(['user', 'school', 'grade', 'parent'])
            ->when($request->search, fn($q) => $q->where(function ($sub) use ($request) {
                $sub->where('name', 'like', "%{$request->search}%")
                    ->orWhere('nis', 'like', "%{$request->search}%");
            }))
            ->when($request->grade_id, fn ($q) => $q->where('grade_id', $request->grade_id))
            ->when($request->gender, fn ($q) => $q->where('gender', $request->gender))
            ->when($request->status, fn ($q) => $q->where('student_status', $request->status))
            ->orderBy('name')
            ->paginate(15);

        return view('admin.masters.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'nullable|email|unique:users,email',
            'nis'             => 'nullable|string|unique:students,nis',
            'nisn'            => 'nullable|string|unique:students,nisn',
            'school_id'       => 'required|exists:schools,id',
            'grade_id'        => 'required|exists:grade_levels,id',
            'parent_id'       => 'nullable|exists:parents,id',
            'gender'          => 'nullable|in:L,P',
            'place_of_birth'  => 'nullable|string|max:100',
            'date_of_birth'   => 'nullable|date',
            'admission_date'  => 'nullable|date',
            'graduation_date' => 'nullable|date',
            'religion'        => 'nullable|string|max:50',
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);

        $username = strtolower(Str::slug($request->name, '_'));
        $original = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $original . '_' . $counter++;
        }

        $user = User::create([
            'uuid'     => Str::uuid(),
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $username,
            'password' => Hash::make('password'),
            'role_id'  => Role::where('name', 'siswa')->value('id'),
        ]);

        Student::create([
            'uuid'            => Str::uuid(),
            'user_id'         => $user->id,
            'school_id'       => $request->school_id,
            'grade_id'        => $request->grade_id,
            'parent_id'       => $request->parent_id,
            'nis'             => $request->nis,
            'nisn'            => $request->nisn,
            'name'            => $request->name,
            'gender'          => $request->gender,
            'place_of_birth'  => $request->place_of_birth,
            'date_of_birth'   => $request->date_of_birth,
            'admission_date'  => $request->admission_date,
            'graduation_date' => $request->graduation_date,
            'religion'        => $request->religion,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'photo'           => null,
            'notes'           => $request->notes,
            'student_status'  => 'aktif',
            'is_active'       => true,
        ]);

        return redirect()->route('master.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $grades = GradeLevel::all();
        $schools = School::all();
        $parents = StudentParent::all();
        

        return view('admin.masters.students.edit', compact('student', 'grades', 'schools', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'nullable|email|unique:users,email,' . $student->user_id,
            'nis'             => 'nullable|string|unique:students,nis,' . $student->id,
            'nisn'            => 'nullable|string|unique:students,nisn,' . $student->id,
            'school_id'       => 'required|exists:schools,id',
            'grade_id'        => 'required|exists:grade_levels,id',
            'parent_id'       => 'nullable|exists:parents,id',
            'gender'          => 'nullable|in:L,P',
            'place_of_birth'  => 'nullable|string|max:100',
            'date_of_birth'   => 'nullable|date',
            'admission_date'  => 'nullable|date',
            'graduation_date' => 'nullable|date',
            'religion'        => 'nullable|string|max:50',
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);

        $student->update([
            'name'            => $request->name,
            'nis'             => $request->nis,
            'nisn'            => $request->nisn,
            'gender'          => $request->gender,
            'place_of_birth'  => $request->place_of_birth,
            'date_of_birth'   => $request->date_of_birth,
            'admission_date'  => $request->admission_date,
            'graduation_date' => $request->graduation_date,
            'religion'        => $request->religion,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'notes'           => $request->notes,
            'school_id'       => $request->school_id,
            'grade_id'        => $request->grade_id,
            'parent_id'       => $request->parent_id,
        ]);

        $student->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('master.students.index')->with('success', 'Data siswa diperbarui.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->user()->delete();
        $student->delete();

        return redirect()->route('master.students.index')->with('success', 'Siswa dihapus.');
    }

    public function show($id)
    {
        $student = Student::with(['user', 'school', 'grade', 'parent'])->findOrFail($id);

        return view('admin.masters.students.show', compact('student'));
    }
}
