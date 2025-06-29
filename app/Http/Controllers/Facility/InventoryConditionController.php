<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\InventoryCondition;
use Illuminate\Http\Request;

class InventoryConditionController extends Controller
{
    public function index(Request $request) // Tambahkan Request $request untuk filter
    {
        $query = InventoryCondition::query();

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $conditions = $query->paginate(10)->appends($request->query());

        // Menghitung data untuk count cards
        $totalConditions = InventoryCondition::count();
        // Asumsi nama kondisi di database
        $goodConditions = InventoryCondition::where('name', 'like', '%baik%')->count();
        $damagedConditions = InventoryCondition::where('name', 'like', '%rusak%')->count();
        $inRepairConditions = InventoryCondition::where('name', 'like', '%perbaikan%')->count();


        return view('admin.masters.inventories.conditions.index', compact('conditions', 'totalConditions', 'goodConditions', 'damagedConditions', 'inRepairConditions'));
    }

    public function create()
    {
        return view('admin.masters.inventories.conditions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:100|unique:inventory_conditions,name',
            'description'   => 'nullable|string',
            // Tambahkan kolom lain jika ada di migrasi dan form, misal 'is_good'
            // 'is_good' => 'boolean',
        ]);

        // Tangani nilai boolean dari checkbox jika ada
        // $validatedData['is_good'] = $request->has('is_good');

        InventoryCondition::create($validatedData);

        return redirect()->route('facility.inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil ditambahkan.');
    }

    public function edit(InventoryCondition $inventoryCondition) // Route Model Binding sudah benar
    {
        // Baris ini tidak diperlukan karena $inventoryCondition sudah diinject oleh Route Model Binding
        // $inventoryCondition = InventoryCondition::find($inventoryCondition->id);

        return view('admin.masters.inventories.conditions.edit', compact('inventoryCondition'));
    }

    public function update(Request $request, InventoryCondition $inventoryCondition) // Route Model Binding sudah benar
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:100', Rule::unique('inventory_conditions', 'name')->ignore($inventoryCondition->id)],
            'description'   => 'nullable|string',
            // Tambahkan kolom lain jika ada di migrasi dan form, misal 'is_good'
            // 'is_good' => 'boolean',
        ]);

        // Tangani nilai boolean dari checkbox jika ada
        // $validatedData['is_good'] = $request->has('is_good');

        $inventoryCondition->update($validatedData);
        return redirect()->route('facility.inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil diperbarui.');
    }

    public function destroy(InventoryCondition $inventoryCondition) // Route Model Binding sudah benar
    {
        try {
            $inventoryCondition->delete();
            return redirect()->route('facility.inventory-conditions.index')->with('success', 'Kondisi inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('facility.inventory-conditions.index')->with('error', 'Gagal menghapus kondisi inventaris: ' . $e->getMessage());
        }
    }
}