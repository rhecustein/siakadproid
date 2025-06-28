<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use App\Models\User;
use App\Models\Role;
use App\Models\Wallet; // Pastikan model Wallet diimport
use App\Models\Student; // Pastikan model Student diimport, jika Anda menggunakannya untuk relasi children
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        // Eager load 'user' dan 'wallet' serta 'children' (untuk count)
        $parents = StudentParent::with([
            'user',
            'wallet',
            'children' => function($query) { // Hanya load anak yang aktif jika dibutuhkan untuk tampilan
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
        return view('admin.masters.parents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'nullable|email|unique:users,email',
            'phone'        => 'required|string|max:20|unique:student_parents,phone',
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'address'      => 'nullable|string',
        ]);

        $baseUsername = strtolower(Str::slug($request->name, '_'));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }

        $user = User::create([
            'uuid'     => Str::uuid(),
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $username,
            'password' => Hash::make('password'),
            'role_id'  => Role::where('name', 'orang_tua')->value('id'),
            'is_active' => true,
        ]);

        $parent = StudentParent::create([
            'uuid'         => Str::uuid(),
            'user_id'      => $user->id,
            'name'         => $request->name,
            'gender'       => $request->gender,
            'relationship' => $request->relationship,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'address'      => $request->address,
            'is_active'    => true,
        ]);

        // Buat wallet baru untuk orang tua
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0, // Saldo awal 0
        ]);

        return redirect()->route('core.parents.index')->with('success', 'Orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $parent = StudentParent::with('user')->findOrFail($id);
        return view('admin.masters.parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = StudentParent::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'nullable|email|unique:users,email,' . $parent->user_id,
            'phone'        => 'required|string|max:20|unique:student_parents,phone,' . $parent->id,
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'address'      => 'nullable|string',
        ]);

        $parent->update([
            'name'         => $request->name,
            'gender'       => $request->gender,
            'relationship' => $request->relationship,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'address'      => $request->address,
        ]);

        if ($parent->user) {
            $parent->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('core.parents.index')->with('success', 'Data orang tua diperbarui.');
    }

    public function destroy($id)
    {
        $parent = StudentParent::findOrFail($id);
        try {
            if ($parent->user) {
                $parent->user->delete();
            }
            $parent->delete();
            return redirect()->route('core.parents.index')->with('success', 'Orang tua berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('core.parents.index')->with('error', 'Gagal menghapus data orang tua: ' . $e->getMessage());
        }
    }
}