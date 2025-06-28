<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    // Tampilkan semua pengguna
   public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        $users = $query->latest()->paginate(10);

        $counts = [
            'admin' => User::where('role_id', 1)->count(),
            'guru' => User::where('role_id', 2)->count(),
            'siswa' => User::where('role_id', 4)->count(),
        ];

        return view('admin.users.index', compact('users', 'counts'));
    }


    // Tampilkan form tambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'nullable|numeric',
            'password'     => 'required|min:6',
            'role_id'      => 'required|in:1,2,3,4',
        ]);

        User::create([
            'uuid'         => Str::uuid(),
            'tenant_id'    => null,
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => Hash::make($request->password),
            'role_id'      => $request->role_id,
            'detail_id'    => null,
            'avatar'       => null,
            'fingerprint'  => null,
            'village_id'   => null,
        ]);

        return redirect()->route('core.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }
 

    // Tampilkan form edit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Tampilkan detail pengguna
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    // Tampilkan form edit pengguna

    // Update pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|in:1,2,3,4',
            'phone_number' => 'nullable|numeric',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('core.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Hapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('core.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->save();

        return redirect()->back()->with('success', 'Pengguna berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->save();

        return redirect()->back()->with('success', 'Pengguna berhasil dinonaktifkan.');
    }
}
