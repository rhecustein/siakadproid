<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\School;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::with(['user', 'school', 'homeroomAssignments.classroom'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->gender, fn ($q) => $q->where('gender', $request->gender))
            ->when($request->status, fn ($q) => $q->where('is_active', $request->status === 'active'))
            ->when($request->school_id, fn ($q) => $q->where('school_id', $request->school_id))
            ->orderBy('name')
            ->get();

        $schools = School::all();

        return view('admin.masters.teachers.index', compact('teachers', 'schools'));
    }


    public function create()
    {
        $schools = School::all();
        return view('admin.masters.teachers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'school_id' => 'required|exists:schools,id',
            'nip' => 'nullable|string|max:20|unique:teachers,nip',
            'gender' => 'nullable|in:L,P',
            'position' => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
        ]);

        // Buat akun user
        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'username' => strtolower(Str::slug($request->name)),
            'password' => Hash::make('password'), // default password
            'role_id' => Role::where('name', 'guru')->value('id'),
        ]);

        // Buat data guru
        Teacher::create([
            'uuid' => Str::uuid(),
            'user_id' => $user->id,
            'school_id' => $request->school_id,
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'type' => $request->type,
            'is_active' => true,
        ]);

        return redirect()->route('master.teachers.index')->with('success', 'Teacher successfully added.');
    }

    public function edit(Teacher $teacher)
    {
        $schools = School::all();
        return view('admin.masters.teachers.edit', compact('teacher', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'school_id' => 'required|exists:schools,id',
            'nip' => 'nullable|string|max:20|unique:teachers,nip,' . $teacher->id,
            'gender' => 'nullable|in:L,P',
            'position' => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
        ]);

        $teacher->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'school_id' => $request->school_id,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'type' => $request->type,
        ]);

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('master.teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        // Hapus user terkait
        $teacher->user()->delete();
        // Hapus data guru
        $teacher->delete();

        return redirect()->route('master.teachers.index')->with('success', 'Teacher deleted.');
    }
}
