<?php

namespace App\Http\Controllers\Healthcare;

use App\Http\Controllers\Controller;
use App\Models\MedicineStock;
use Illuminate\Http\Request;

class MedicineStockController extends Controller
{
    public function index()
    {
        $medicines = MedicineStock::latest()->get();
        return view('medicine_stocks.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicine_stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        MedicineStock::create($request->all());

        return redirect()->route('medicine-stocks.index')->with('success', 'Medicine added.');
    }

    public function show(MedicineStock $medicineStock)
    {
        return view('medicine_stocks.show', compact('medicineStock'));
    }

    public function edit(MedicineStock $medicineStock)
    {
        return view('medicine_stocks.edit', compact('medicineStock'));
    }

    public function update(Request $request, MedicineStock $medicineStock)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $medicineStock->update($request->all());

        return redirect()->route('medicine-stocks.index')->with('success', 'Medicine updated.');
    }

    public function destroy(MedicineStock $medicineStock)
    {
        $medicineStock->delete();

        return redirect()->route('medicine-stocks.index')->with('success', 'Medicine deleted.');
    }
}