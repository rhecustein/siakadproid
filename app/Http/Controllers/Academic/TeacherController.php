<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\School;
use App\Models\User;
use App\Models\Role;
use App\Models\AcademicYear; // Import AcademicYear jika digunakan di currentHomeroomAssignment
use App\Models\HomeroomAssignment; // Import HomeroomAssignment jika digunakan di currentHomeroomAssignment
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
     public function index(Request $request)
    {
        // Mendapatkan ID tahun ajaran aktif saat ini
        $currentAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        $teachers = Teacher::with([
            'user',
            'school',
            // Eager load relasi currentHomeroomAssignment beserta classroom dan academicYear-nya
            // Menggunakan fungsi anonim untuk menambahkan kondisi pada eager loading
            'currentHomeroomAssignment' => function($query) use ($currentAcademicYearId) {
                $query->where('is_active', true)
                      ->when($currentAcademicYearId, function ($q) use ($currentAcademicYearId) {
                          $q->where('academic_year_id', $currentAcademicYearId);
                      })
                      ->with('classroom', 'academicYear'); // Load classroom dan academicYear di sini
            }
        ])
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
        ->paginate(10); // Menggunakan paginate untuk pagination, misalnya 10 item per halaman

        $schools = School::all(); // Ambil semua sekolah untuk dropdown filter

        // Menghitung data relevan untuk count cards
        $totalTeachers = Teacher::count();
        $activeTeachers = Teacher::where('is_active', true)->count();
        
        // Menghitung jumlah wali kelas aktif
        // Ini akan menghitung jumlah penugasan wali kelas yang aktif di tahun ajaran aktif
        $activeHomeroomTeachers = HomeroomAssignment::where('is_active', true)
                                                    ->when($currentAcademicYearId, function ($q) use ($currentAcademicYearId) {
                                                        $q->where('academic_year_id', $currentAcademicYearId);
                                                    })
                                                    ->count();
        
        $totalSchools = School::count(); // Asumsi School model ada dan berfungsi

        return view('admin.masters.teachers.index', compact('teachers', 'schools', 'totalTeachers', 'activeTeachers', 'activeHomeroomTeachers', 'totalSchools'));
    }

    public function create()
    {
        $schools = School::all();

        // Ambil user yang tidak memiliki relasi 'teacher' (belum menjadi guru)
        // Pastikan Anda memiliki relasi 'teacher' di model User:
        // public function teacher() { return $this->hasOne(Teacher::class); }
        $availableUsers = User::doesntHave('teacher')->get();

        return view('admin.masters.teachers.create', compact('schools', 'availableUsers'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'school_id' => 'required|exists:schools,id',
            'nip' => 'nullable|string|max:20|unique:teachers,nip',
            'gender' => 'nullable|in:L,P',
            'position' => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'user_id_option' => 'required|in:create_new,select_existing',
        ];

        if ($request->user_id_option === 'create_new') {
            $rules['email'] = 'required|email|unique:users,email';
            // Tambahkan validasi password jika Anda ingin user baru punya password custom
            // $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($request->user_id_option === 'select_existing') {
            $rules['user_id'] = [
                'required',
                'exists:users,id',
                Rule::unique('teachers')->where(fn ($query) => $query->where('user_id', $request->user_id))
            ];
            // Jika memilih user yang sudah ada, email dan nama akan diambil dari user tersebut
            // Jadi tidak perlu validasi email dari input form untuk kasus ini.
        }

        $request->validate($rules);

        $userId = null;
        $userEmail = $request->email; // Default untuk user baru

        if ($request->user_id_option === 'create_new') {
            // Buat akun user baru
            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'username' => strtolower(Str::slug($request->name)) . rand(100, 999), // Tambahkan angka random untuk username unik
                'password' => Hash::make('password'), // default password yang aman
                'role_id' => Role::where('name', 'guru')->value('id'), // Pastikan role 'guru' ada
                'is_active' => true, // Default aktif saat dibuat
            ]);
            $userId = $user->id;
            $userEmail = $user->email; // Ambil email dari user yang baru dibuat
        } elseif ($request->user_id_option === 'select_existing') {
            // Gunakan akun user yang sudah ada
            $user = User::findOrFail($request->user_id);
            $userId = $user->id;
            $userEmail = $user->email; // Ambil email dari user yang dipilih

            // Perbarui role user yang dipilih menjadi guru jika belum
            if ($user->role_id !== Role::where('name', 'guru')->value('id')) {
                $user->update(['role_id' => Role::where('name', 'guru')->value('id')]);
            }
        }

        // Buat data guru
        Teacher::create([
            'uuid' => Str::uuid(),
            'user_id' => $userId, // Gunakan user_id yang didapat
            'school_id' => $request->school_id,
            'name' => $request->name,
            'email' => $userEmail, // Gunakan email dari user yang terhubung
            'nip' => $request->nip,
            'gender' => $request->gender,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'type' => $request->type,
            'is_active' => true, // is_active default true
        ]);

        return redirect()->route('academic.teachers.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        $schools = School::all();
        // Anda mungkin juga ingin melewatkan daftar 'type', 'employment_status' jika ini adalah pilihan tetap
        return view('admin.masters.teachers.edit', compact('teacher', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            // Validasi email unik kecuali untuk user_id guru yang sedang diedit
            // Email guru di tabel teacher dan email user terkait harus sinkron
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
            // 'is_active' tidak diubah di sini, bisa diatur lewat toggle terpisah jika ada
        ]);

        // Update data user terkait
        if ($teacher->user) {
            $teacher->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('academic.teachers.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        try {
            // Hapus user terkait jika ada
            if ($teacher->user) {
                $teacher->user->delete();
            }
            // Hapus data guru
            $teacher->delete();
            return redirect()->route('academic.teachers.index')->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('academic.teachers.index')->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }
}