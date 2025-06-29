<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\InventoryType;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class InventoryTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryType::query();

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan is_electronic
        if ($request->filled('electronic')) { // Parameter 'electronic' dari form
            $query->where('is_electronic', $request->electronic === '1');
        }

        // Filter berdasarkan is_consumable (asumsi ada di DB dan form)
        if ($request->filled('consumable')) { // Parameter 'consumable' dari form
            $query->where('is_consumable', $request->consumable === '1');
        }

        $types = $query->paginate(10)->appends($request->query());

        // Menghitung data untuk count cards
        $totalTypes = InventoryType::count();
        $electronicTypes = InventoryType::where('is_electronic', true)->count();
        $consumableTypes = InventoryType::where('is_consumable', true)->count(); // Asumsi kolom ini ada
        $avgEconomicLife = InventoryType::avg('economic_life') ?? 0; // Hitung rata-rata umur ekonomis

        return view('admin.masters.inventories.types.index', compact('types', 'totalTypes', 'electronicTypes', 'consumableTypes', 'avgEconomicLife'));
    }

    public function create()
    {
        return view('admin.masters.inventories.types.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:100|unique:inventory_types,name',
            'is_electronic' => 'boolean',
            'is_consumable' => 'boolean', // Asumsi ini ada dari form
            'economic_life' => 'nullable|integer|min:1',
        ]);

        // Tangani nilai boolean dari checkbox (karena tidak terkirim jika tidak dicentang)
        $validatedData['is_electronic'] = $request->has('is_electronic');
        $validatedData['is_consumable'] = $request->has('is_consumable');

        InventoryType::create($validatedData); // Menggunakan $validatedData

        return redirect()->route('facility.inventory-types.index')->with('success', 'Tipe inventaris berhasil ditambahkan.');
    }

    public function edit(InventoryType $inventoryType) // Menggunakan Route Model Binding
    {
        return view('admin.masters.inventories.types.edit', compact('inventoryType'));
    }

    public function update(Request $request, InventoryType $inventoryType) // Menggunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:100', Rule::unique('inventory_types', 'name')->ignore($inventoryType->id)],
            'is_electronic' => 'boolean',
            'is_consumable' => 'boolean', // Asumsi ini ada dari form
            'economic_life' => 'nullable|integer|min:1',
        ]);

        // Tangani nilai boolean dari checkbox
        $validatedData['is_electronic'] = $request->has('is_electronic');
        $validatedData['is_consumable'] = $request->has('is_consumable');

        $inventoryType->update($validatedData); // Menggunakan $validatedData

        return redirect()->route('facility.inventory-types.index')->with('success', 'Tipe inventaris berhasil diperbarui.');
    }

    public function destroy(InventoryType $inventoryType) // Menggunakan Route Model Binding
    {
        $inventoryType->delete();
        return redirect()->route('facility.inventory-types.index')->with('success', 'Tipe inventaris berhasil dihapus.');
    }
}