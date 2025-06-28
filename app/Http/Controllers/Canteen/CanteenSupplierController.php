<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenSupplier;
use Illuminate\Http\Request;

class CanteenSupplierController extends Controller
{
    // Tampilkan semua supplier
    public function index()
    {
        $suppliers = CanteenSupplier::all();
        return view('canteen.suppliers.index', compact('suppliers'));
    }

    // Form tambah supplier
    public function create()
    {
        return view('canteen.suppliers.create');
    }

    // Simpan supplier baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_branch_partner' => 'boolean',
        ]);

        CanteenSupplier::create($validated);
        return redirect()->route('canteen-suppliers.index')->with('success', 'Mitra supplier berhasil ditambahkan.');
    }

    // Form edit supplier
    public function edit($id)
    {
        $supplier = CanteenSupplier::findOrFail($id);
        return view('canteen.suppliers.edit', compact('supplier'));
    }

    // Update supplier
    public function update(Request $request, $id)
    {
        $supplier = CanteenSupplier::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_branch_partner' => 'boolean',
        ]);

        $supplier->update($validated);
        return redirect()->route('canteen-suppliers.index')->with('success', 'Mitra supplier berhasil diperbarui.');
    }

    // Hapus supplier
    public function destroy($id)
    {
        $supplier = CanteenSupplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('canteen-suppliers.index')->with('success', 'Mitra supplier berhasil dihapus.');
    }
}
