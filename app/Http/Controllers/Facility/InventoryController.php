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
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%'); // Tambah filter deskripsi
            });
        }

        // Filter berdasarkan Tipe Inventaris
        if ($request->filled('type_id')) { // Sesuaikan nama parameter di URL/form
            $query->where('inventory_type_id', $request->type_id);
        }

        // Filter berdasarkan Kondisi Inventaris
        if ($request->filled('condition_id')) { // Sesuaikan nama parameter di URL/form
            $query->where('inventory_condition_id', $request->condition_id);
        }

        // Filter berdasarkan Ruangan
        if ($request->filled('room_id')) { // Sesuaikan nama parameter di URL/form
            $query->where('room_id', $request->room_id);
        }

        $inventories = $query->paginate(10)->appends($request->query());

        // Menghitung data untuk count cards
        $totalInventories = Inventory::count();
        $inventoriesInRooms = Inventory::whereNotNull('room_id')->count();
        // Asumsi ada InventoryCondition dengan nama 'Baik' atau ID tertentu untuk kondisi baik
        $goodConditionInventories = Inventory::whereHas('condition', function($q) {
            $q->where('name', 'like', '%baik%'); // Sesuaikan dengan nama kondisi 'baik' di DB
        })->count();
        $totalQuantity = Inventory::sum('quantity');

        // Ambil semua data master untuk filter dropdown
        $types = InventoryType::all();
        $conditions = InventoryCondition::all();
        $rooms = Room::all(); // Ambil semua ruangan untuk dropdown

        return view('admin.masters.inventories.index', compact('inventories', 'types', 'conditions', 'rooms', 'totalInventories', 'inventoriesInRooms', 'goodConditionInventories', 'totalQuantity'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:inventories,code',
            'room_id' => 'nullable|exists:rooms,id', // Diubah menjadi nullable sesuai kebutuhan di view
            'inventory_type_id' => 'required|exists:inventory_types,id',
            'inventory_condition_id' => 'nullable|exists:inventory_conditions,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string', // Tambahkan validasi jika ada di form
            'purchase_date' => 'nullable|date', // Tambahkan validasi jika ada di form
            'notes' => 'nullable|string', // Tambahkan validasi jika ada di form

            // Kolom boolean
            'is_electronic' => 'boolean',
            'is_consumable' => 'boolean', // Asumsi ada kolom ini di DB dan form
            'is_active' => 'boolean', // Asumsi ada kolom ini di DB dan form
        ]);

        // Tangani nilai boolean dari checkbox (karena tidak terkirim jika tidak dicentang)
        $validatedData['is_electronic'] = $request->has('is_electronic');
        $validatedData['is_consumable'] = $request->has('is_consumable');
        $validatedData['is_active'] = $request->has('is_active');

        // Jika Anda menggunakan UUID di model Inventory, pastikan model tersebut meng-handle-nya
        // atau tambahkan: $validatedData['uuid'] = Str::uuid();

        Inventory::create($validatedData);
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:50', Rule::unique('inventories', 'code')->ignore($inventory->id)],
            'room_id' => 'nullable|exists:rooms,id',
            'inventory_type_id' => 'required|exists:inventory_types,id',
            'inventory_condition_id' => 'nullable|exists:inventory_conditions,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',

            // Kolom boolean
            'is_electronic' => 'boolean',
            'is_consumable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Tangani nilai boolean dari checkbox
        $validatedData['is_electronic'] = $request->has('is_electronic');
        $validatedData['is_consumable'] = $request->has('is_consumable');
        $validatedData['is_active'] = $request->has('is_active');

        $inventory->update($validatedData);
        return redirect()->route('facility.inventories.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();
            return redirect()->route('facility.inventories.index')->with('success', 'Inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('facility.inventories.index')->with('error', 'Gagal menghapus inventaris: ' . $e->getMessage());
        }
    }
}