<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\InventoryType;
use Illuminate\Http\Request;

class InventoryTypeController extends Controller
{
    public function index()
    {
        $types = InventoryType::all();
        return view('admin.masters.inventories.types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.masters.inventories.types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'is_electronic' => 'boolean',
            'economic_life' => 'nullable|integer|min:1',
        ]);

        InventoryType::create($request->all());
        return redirect()->route('inventory-types.index')->with('success', 'Tipe inventaris berhasil ditambahkan.');
    }

    public function edit(InventoryType $inventoryType)
    {
        return view('admin.masters.inventories.types.edit', compact('inventoryType'));
    }

    public function update(Request $request, InventoryType $inventoryType)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'is_electronic' => 'boolean',
            'economic_life' => 'nullable|integer|min:1',
        ]);

        $inventoryType->update($request->all());
        return redirect()->route('inventory-types.index')->with('success', 'Tipe inventaris berhasil diperbarui.');
    }

    public function destroy(InventoryType $inventoryType)
    {
        $inventoryType->delete();
        return redirect()->route('inventory-types.index')->with('success', 'Tipe inventaris berhasil dihapus.');
    }
}