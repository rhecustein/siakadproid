<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    // Menampilkan daftar peran
    public function index(Request $request)
    {
        $query = Role::query();

        // Menambahkan filter untuk display_name dan scope jika diperlukan di tampilan
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('display_name', 'like', '%' . $request->search . '%') // Filter display_name
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        // Filter berdasarkan guard_name (jika ada di UI)
        if ($request->filled('guard_name')) {
            $query->where('guard_name', $request->guard_name);
        }
        // Filter berdasarkan scope (jika ada di UI, contoh: 'sd', 'smp', 'sma')
        if ($request->filled('scope')) {
            $query->whereJsonContains('scope', $request->scope); // Memfilter array JSON
        }

        $roles = $query->paginate(10)->appends($request->query());

        // Untuk count cards (jika diperlukan di tampilan)
        $totalRoles = Role::count();
        $webRoles = Role::where('guard_name', 'web')->count(); // Contoh count
        $apiRoles = Role::where('guard_name', 'api')->count(); // Contoh count
        $activeRoles = Role::whereHas('users')->count(); // Contoh: peran yang sudah ditugaskan ke user

        return view('settings.roles.index', compact('roles', 'totalRoles', 'webRoles', 'apiRoles', 'activeRoles'));
    }

    // Menampilkan form tambah peran baru
    public function create()
    {
        return view('settings.roles.create');
    }

    // Menyimpan peran baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'nullable|string|max:255', // Tambahkan validasi
            'guard_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'scope' => 'nullable|array', // Validasi scope sebagai array
            'scope.*' => 'string|max:50', // Validasi item dalam array scope
        ]);

        $validatedData['uuid'] = Str::uuid(); // Generate UUID
        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web';
        // Konversi array scope menjadi JSON string jika kolom di DB adalah JSON
        $validatedData['scope'] = $validatedData['scope'] ? json_encode($validatedData['scope']) : null;


        Role::create($validatedData);

        return redirect()->route('core.roles.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    // Menampilkan form edit peran
    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }

    // Memperbarui peran
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'display_name' => 'nullable|string|max:255', // Tambahkan validasi
            'guard_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'scope' => 'nullable|array',
            'scope.*' => 'string|max:50',
        ]);

        $validatedData['guard_name'] = $validatedData['guard_name'] ?? 'web';
        $validatedData['scope'] = $validatedData['scope'] ? json_encode($validatedData['scope']) : null;

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