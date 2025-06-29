<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
     // Menampilkan daftar peran dengan izin mereka untuk diedit
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->orderBy('name')->paginate(10);
        $permissions = Permission::orderBy('name')->get(); // Semua izin yang tersedia

        // Untuk filter
        $queryRoles = Role::query();
        if ($request->filled('search_role')) {
            $queryRoles->where('name', 'like', '%' . $request->search_role . '%');
        }
        $filteredRoles = $queryRoles->paginate(10)->appends($request->query());

        return view('admin.access.role-permissions.index', compact('roles', 'permissions', 'filteredRoles'));
    }

    // Menampilkan form untuk mengelola izin suatu peran
    public function edit(Role $role)
    {
        $allPermissions = Permission::orderBy('category')->orderBy('name')->get()->groupBy('category');
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Izin yang sudah dimiliki peran ini

        return view('admin.access.role-permissions.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    // Menyimpan perubahan penugasan izin untuk suatu peran
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Sinkronisasi izin untuk peran ini
        // Jika request 'permissions' null, itu berarti semua checkbox tidak dicentang, sehingga semua izin dihapus.
        $role->permissions()->sync($validatedData['permissions'] ?? []);

        return redirect()->route('core.role-permissions.index')->with('success', 'Izin peran berhasil diperbarui.');
    }
}
