<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenUser;
use App\Models\User;
use Illuminate\Http\Request;

class CanteenUserController extends Controller
{
    // Daftar user kantin
    public function index()
    {
        $canteenUsers = CanteenUser::with('user', 'canteen')->get();
        return view('canteen.users.index', compact('canteenUsers'));
    }

    // Form tambah user
    public function create()
    {
        $users = User::all();
        $canteens = Canteen::all();
        return view('canteen.users.create', compact('users', 'canteens'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'canteen_id' => 'required|exists:canteens,id',
            'role' => 'required|in:cashier,manager,admin',
        ]);

        CanteenUser::create($validated);
        return redirect()->route('canteen-users.index')->with('success', 'Pengguna kantin berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $canteenUser = CanteenUser::findOrFail($id);
        $users = User::all();
        $canteens = Canteen::all();
        return view('canteen.users.edit', compact('canteenUser', 'users', 'canteens'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $canteenUser = CanteenUser::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'canteen_id' => 'required|exists:canteens,id',
            'role' => 'required|in:cashier,manager,admin',
        ]);

        $canteenUser->update($validated);
        return redirect()->route('canteen-users.index')->with('success', 'Pengguna kantin berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $canteenUser = CanteenUser::findOrFail($id);
        $canteenUser->delete();
        return redirect()->route('canteen-users.index')->with('success', 'Pengguna kantin berhasil dihapus.');
    }
}
