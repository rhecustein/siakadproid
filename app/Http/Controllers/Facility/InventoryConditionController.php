<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\InventoryCondition;
use Illuminate\Http\Request;

class InventoryConditionController extends Controller
{
    public function index()
    {
        $conditions = InventoryCondition::all();
        return view('admin.masters.inventories.conditions.index', compact('conditions'));
    }

    public function create()
    {
        return view('admin.masters.inventories.conditions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        InventoryCondition::create($request->all());
        return redirect()->route('inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil ditambahkan.');
    }

    public function edit(InventoryCondition $inventoryCondition)
    {
        $inventoryCondition = InventoryCondition::find($inventoryCondition->id);
        
        return view('admin.masters.inventories.conditions.edit', compact('inventoryCondition'));
    }

    public function update(Request $request, InventoryCondition $inventoryCondition)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $inventoryCondition->update($request->all());
        return redirect()->route('inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil diperbarui.');
    }

    public function destroy(InventoryCondition $inventoryCondition)
    {
        $inventoryCondition->delete();
        return redirect()->route('inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil dihapus.');
    }
}
