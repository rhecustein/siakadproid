<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RolesController extends Controller
{
     // Menampilkan daftar peran
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $roles = $query->paginate(10)->appends($request->query());

        // Untuk count cards (jika diperlukan di tampilan)
        $totalRoles = Role::count();
        // $rolesWithSpecificPermission = Role::whereHas('permissions', fn($q) => $q->where('name', 'some_permission'))->count();

        return view('admin.access.roles.index', compact('roles', 'totalRoles'));
    }

    // Menampilkan form tambah peran baru
    public function create()
    {
        return view('admin.access.roles.create');
    }

    // Menyimpan peran baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'nullable|string|max:255', // Default 'web'
            'description' => 'nullable|string',
        ]);

        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web'; // Default guard

        Role::create($validatedData);

        return redirect()->route('core.roles.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    // Menampilkan form edit peran
    public function edit(Role $role)
    {
        return view('admin.access.roles.edit', compact('role'));
    }

    // Memperbarui peran
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'guard_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web';

        $role->update($validatedData);

        return redirect()->route('core.roles.index')->with('success', 'Peran berhasil diperbarui.');
    }

    // Menghapus peran
    public function destroy(Role $role)
    {
        try {
            // Hapus juga semua hubungan peran-izin dan pengguna-peran sebelum menghapus peran
            $role->permissions()->detach(); // Menghapus semua izin dari peran ini
            $role->users()->detach(); // Menghapus semua pengguna dari peran ini (jika menggunakan method users() yang morphedByMany)

            $role->delete();
            return redirect()->route('core.roles.index')->with('success', 'Peran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('core.roles.index')->with('error', 'Gagal menghapus peran: ' . $e->getMessage());
        }
    }
}
