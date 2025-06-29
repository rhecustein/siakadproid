<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserRoleController extends Controller
{
    // Menampilkan daftar pengguna dengan peran mereka untuk diedit
    public function index(Request $request)
    {
        $queryUsers = User::with('roles')->orderBy('name');

        if ($request->filled('search')) {
            $queryUsers->where('name', 'like', '%' . $request->search . '%')
                       ->orWhere('email', 'like', '%' . $request->search . '%')
                       ->orWhere('username', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('role_id')) {
            $queryUsers->whereHas('roles', function($q) use ($request) {
                $q->where('id', $request->role_id);
            });
        }

        $users = $queryUsers->paginate(10)->appends($request->query());
        $roles = Role::all(); // Semua peran yang tersedia untuk filter

        return view('admin.access.user-roles.index', compact('users', 'roles'));
    }

    // Menampilkan form untuk mengelola peran suatu pengguna
    public function edit(User $user)
    {
        $allRoles = Role::orderBy('name')->get();
        $userRoles = $user->roles->pluck('id')->toArray(); // Peran yang sudah dimiliki pengguna ini

        return view('admin.access.user-roles.edit', compact('user', 'allRoles', 'userRoles'));
    }

    // Menyimpan perubahan penugasan peran untuk suatu pengguna
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Sinkronisasi peran untuk pengguna ini
        $user->roles()->sync($validatedData['roles'] ?? []);

        return redirect()->route('core.user-roles.index')->with('success', 'Peran pengguna berhasil diperbarui.');
    }
}
