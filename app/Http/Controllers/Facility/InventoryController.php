<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryType;
use App\Models\InventoryCondition;
use App\Models\Room;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with(['room', 'type', 'condition']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('inventory_type_id', $request->type);
        }

        if ($request->filled('condition')) {
            $query->where('inventory_condition_id', $request->condition);
        }

        $inventories = $query->paginate(10)->appends($request->query());
        $types = InventoryType::all();
        $conditions = InventoryCondition::all();

        return view('admin.masters.inventories.index', compact('inventories', 'types', 'conditions'));
    }

    public function create()
    {
        $types = InventoryType::all();
        $conditions = InventoryCondition::all();
        $rooms = Room::all();

        return view('admin.masters.inventories.create', compact('types', 'conditions', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:inventories,code',
            'room_id' => 'required|exists:rooms,id',
            'inventory_type_id' => 'required|exists:inventory_types,id',
            'inventory_condition_id' => 'nullable|exists:inventory_conditions,id',
            'quantity' => 'required|integer|min:1',
            'is_electronic' => 'boolean',
            'acquired_at' => 'nullable|date',
            'economic_life' => 'nullable|integer|min:1',
        ]);

        Inventory::create($request->all());
        return redirect()->route('facility.inventories.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function edit(Inventory $inventory)
    {
        $types = InventoryType::all();
        $conditions = InventoryCondition::all();
        $rooms = Room::all();

        return view('admin.masters.inventories.edit', compact('inventory', 'types', 'conditions', 'rooms'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:inventories,code,' . $inventory->id,
            'room_id' => 'required|exists:rooms,id',
            'inventory_type_id' => 'required|exists:inventory_types,id',
            'inventory_condition_id' => 'nullable|exists:inventory_conditions,id',
            'quantity' => 'required|integer|min:1',
            'is_electronic' => 'boolean',
            'acquired_at' => 'nullable|date',
            'economic_life' => 'nullable|integer|min:1',
        ]);

        $inventory->update($request->all());
        return redirect()->route('facility.inventories.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('facility.inventories.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}
