<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    // Menampilkan daftar izin
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $permissions = $query->paginate(10)->appends($request->query());

        // Untuk count cards (jika diperlukan di tampilan)
        $totalPermissions = Permission::count();
        $uniqueCategories = Permission::distinct('category')->pluck('category');

        return view('admin.access.permissions.index', compact('permissions', 'totalPermissions', 'uniqueCategories'));
    }

    // Menampilkan form tambah izin baru
    public function create()
    {
        return view('admin.access.permissions.create');
    }

    // Menyimpan izin baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'nullable|string|max:255', // Default 'web'
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web';

        Permission::create($validatedData);

        return redirect()->route('core.permissions.index')->with('success', 'Izin berhasil ditambahkan.');
    }

    // Menampilkan form edit izin
    public function edit(Permission $permission)
    {
        return view('admin.access.permissions.edit', compact('permission'));
    }

    // Memperbarui izin
    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
            'guard_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web';

        $permission->update($validatedData);

        return redirect()->route('core.permissions.index')->with('success', 'Izin berhasil diperbarui.');
    }

    // Menghapus izin
    public function destroy(Permission $permission)
    {
        try {
            // Hapus semua hubungan peran-izin dan pengguna-izin yang terkait dengan izin ini
            $permission->roles()->detach(); // Menghapus izin ini dari semua peran
            $permission->users()->detach(); // Menghapus izin ini dari semua pengguna (jika menggunakan method users() yang morphedByMany)

            $permission->delete();
            return redirect()->route('core.permissions.index')->with('success', 'Izin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('core.permissions.index')->with('error', 'Gagal menghapus izin: ' . $e->getMessage());
        }
    }
}
