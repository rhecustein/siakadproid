<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    // Tampilkan daftar semua kantin
    public function index()
    {
        $canteens = Canteen::all();
        return view('canteen.index', compact('canteens'));
    }

    // Tampilkan form tambah kantin
    public function create()
    {
        return view('canteen.create');
    }

    // Simpan kantin baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Canteen::create($validated);
        return redirect()->route('canteen.index')->with('success', 'Kantin berhasil ditambahkan.');
    }

    // Tampilkan form edit kantin
    public function edit($id)
    {
        $canteen = Canteen::findOrFail($id);
        return view('canteen.edit', compact('canteen'));
    }

    // Update data kantin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $canteen = Canteen::findOrFail($id);
        $canteen->update($validated);

        return redirect()->route('canteen.index')->with('success', 'Kantin berhasil diperbarui.');
    }

    // Hapus kantin (soft delete)
    public function destroy($id)
    {
        $canteen = Canteen::findOrFail($id);
        $canteen->delete();
        return redirect()->route('canteen.index')->with('success', 'Kantin berhasil dihapus.');
    }
}
