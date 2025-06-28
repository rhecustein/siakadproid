<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\StudentParent; // Pastikan ini benar
use App\Models\User;
use App\Models\Role; // Import Role model
use App\Models\Wallet; // Import Wallet model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unik kondisional

class ParentManagementController extends Controller
{
    public function index(Request $request)
    {
        // Eager load 'user', 'wallet', dan 'children' (hanya yang aktif untuk count)
        $parents = StudentParent::with([
            'user',
            'wallet',
            'children' => function($query) {
                $query->where('is_active', true);
            }
        ])
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->gender, fn ($q) => $q->where('gender', $request->gender))
        ->when($request->relationship, fn ($q) => $q->where('relationship', $request->relationship))
        ->when($request->status, fn ($q) => $q->where('is_active', $request->status === 'active'))
        ->orderBy('name')
        ->paginate(15);

        // --- Perhitungan data untuk count cards (PENTING: ini harus dihitung dari model, bukan dari $parents yang sudah terpaginasi) ---
        $totalParents = StudentParent::count();
        $activeParents = StudentParent::where('is_active', true)->count();
        $maleParents = StudentParent::where('gender', 'L')->count();
        $femaleParents = StudentParent::where('gender', 'P')->count();
        // --- Akhir perhitungan ---

        // Melewatkan semua variabel yang diperlukan ke view
        return view('admin.masters.parents.index', compact(
            'parents',
            'totalParents',
            'activeParents',
            'maleParents',
            'femaleParents'
        ));
    }

    public function create()
    {
        // Ambil user yang tidak memiliki relasi 'parent' (belum menjadi orang tua)
        // Pastikan Anda memiliki relasi 'parent' di model User:
        // public function parent() { return $this->hasOne(StudentParent::class, 'user_id'); }
        $availableUsers = User::doesntHave('parent')->get();

        return view('admin.masters.parents.create', compact('availableUsers'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|string|max:100',
            'phone'        => 'required|string|max:20|unique:student_parents,phone', // Pastikan tabel 'student_parents'
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'address'      => 'nullable|string',
            'user_id_option' => 'required|in:create_new,select_existing', // Opsi dari UI
        ];

        $userId = null;
        $userEmail = $request->email; // Default untuk user baru atau jika tidak ada email yang diberikan untuk user yang ada

        if ($request->user_id_option === 'create_new') {
            $rules['email'] = 'required|email|unique:users,email'; // Email wajib dan unik jika buat baru
            $request->validate($rules);

            // Buat akun user baru
            $user = User::create([
                'uuid'     => Str::uuid(),
                'name'     => $request->name,
                'email'    => $request->email,
                'username' => strtolower(Str::slug($request->name, '_')) . Str::random(4), // Username yang lebih unik
                'password' => Hash::make('password'), // default password yang aman
                'role_id'  => Role::where('name', 'orang_tua')->value('id'), // Pastikan role 'orang_tua' ada
                'is_active' => true,
            ]);
            $userId = $user->id;
            $userEmail = $user->email; // Pastikan email diambil dari user yang baru dibuat
        } elseif ($request->user_id_option === 'select_existing') {
            $rules['user_id'] = [
                'required',
                'exists:users,id',
                Rule::unique('student_parents')->where(fn ($query) => $query->where('user_id', $request->user_id))
            ]; // Pastikan user_id unik di tabel student_parents
            $request->validate($rules);

            // Gunakan akun user yang sudah ada
            $user = User::findOrFail($request->user_id);
            $userId = $user->id;
            $userEmail = $user->email; // Ambil email dari user yang dipilih

            // Opsional: Perbarui role user yang dipilih menjadi orang_tua jika belum
            if ($user->role_id !== Role::where('name', 'orang_tua')->value('id')) {
                $user->update(['role_id' => Role::where('name', 'orang_tua')->value('id')]);
            }
        } else {
            // Ini seharusnya tidak terjadi jika validasi user_id_option benar
            return back()->withErrors(['user_id_option' => 'Opsi akun pengguna tidak valid.'])->withInput();
        }


        // Buat data StudentParent
        $parent = StudentParent::create([
            'uuid'         => Str::uuid(),
            'user_id'      => $userId, // Gunakan user_id yang didapat dari langkah sebelumnya
            'name'         => $request->name,
            'gender'       => $request->gender,
            'relationship' => $request->relationship,
            'phone'        => $request->phone,
            'email'        => $userEmail, // Simpan email dari user yang terhubung
            'address'      => $request->address,
            'is_active'    => true,
        ]);

        // Buat wallet baru untuk user yang terhubung dengan orang tua
        // Pastikan setiap user punya wallet. Kalau user sudah ada, cek apakah sudah punya wallet.
        if (!$user->wallet) { // Asumsi relasi wallet() di model User
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
        }


        return redirect()->route('core.parents.index')->with('success', 'Orang tua berhasil ditambahkan.');
    }

    public function show(StudentParent $parent)
    {
        // Pastikan eager loading yang cukup untuk tampilan detail
        $parent->load(['user', 'wallet', 'children']); // Load children juga jika diperlukan di show page
        return view('admin.masters.parents.show', compact('parent'));
    }

    public function edit(StudentParent $parent)
    {
        $parent->load('user'); // Pastikan user di-load untuk form edit email
        // Di halaman edit, kita tidak menyediakan opsi untuk mengubah user_id,
        // hanya mengedit data StudentParent dan user terkait.
        return view('admin.masters.parents.edit', compact('parent'));
    }

    public function update(Request $request, StudentParent $parent)
    {
        $rules = [
            'name'         => 'required|string|max:100',
            // Validasi email unik kecuali untuk user_id yang sedang diedit
            'email'        => ['nullable', 'email', Rule::unique('users')->ignore($parent->user_id)],
            'phone'        => ['required', 'string', 'max:20', Rule::unique('student_parents')->ignore($parent->id)], // Pastikan tabel student_parents
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'address'      => 'nullable|string',
            // 'is_active'   => 'boolean', // Jika is_active bisa diubah dari form edit
        ];
        $request->validate($rules);


        $parent->update([
            'name'         => $request->name,
            'gender'       => $request->gender,
            'relationship' => $request->relationship,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'address'      => $request->address,
            // 'is_active'    => $request->has('is_active') ? $request->boolean('is_active') : $parent->is_active,
        ]);

        // Update data user terkait
        if ($parent->user) {
            $parent->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('core.parents.index')->with('success', 'Data orang tua diperbarui.');
    }

    public function destroy(StudentParent $parent)
    {
        try {
            // Hapus user terkait jika ada
            if ($parent->user) {
                // Perhatian: Jika user ini tidak hanya terkait dengan StudentParent,
                // mungkin Anda tidak ingin menghapus user-nya. Sesuaikan logika ini.
                // Jika wallet juga terkait user_id, onDelete('cascade') di migrasi
                // user-id ke wallet-id akan otomatis menghapus wallet.
                $parent->user->delete();
            }
            // Hapus data orang tua
            $parent->delete();
            return redirect()->route('core.parents.index')->with('success', 'Orang tua berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('core.parents.index')->with('error', 'Gagal menghapus data orang tua: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint untuk mencari pengguna yang tersedia (belum terhubung sebagai orang tua).
     * Digunakan oleh fitur search di halaman create.
     */
    public function searchAvailableUsers(Request $request)
    {
        $search = $request->query('q');

        $users = User::doesntHave('parent') // Hanya user yang belum jadi parent
                     ->where(function($query) use ($search) {
                         $query->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%");
                     })
                     ->get(['id', 'name', 'email']); // Hanya ambil kolom yang dibutuhkan

        return response()->json($users);
    }
}