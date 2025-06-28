<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

use App\Models\BillGroup;
use App\Models\Level;
use App\Models\School;
use Illuminate\Http\Request;

class BillGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BillGroup::with(['school', 'level'])
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->school_id, fn($q) => $q->where('school_id', $request->school_id))
            ->when($request->level_id, fn($q) => $q->where('level_id', $request->level_id))
            ->when($request->academic_year, fn($q) => $q->where('academic_year', $request->academic_year));

        $billGroups = $query->latest()->paginate(15);
        $schools = \App\Models\School::all();
        $levels = \App\Models\Level::all();

        return view('admin.finance.bill.groups.index', compact('billGroups', 'schools', 'levels'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = Level::all();
        $schools = School::all();

        return view('admin.finance.bill.groups.create', compact('levels', 'schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'level_id' => 'nullable|exists:levels,id',
            'school_id' => 'nullable|exists:schools,id',
            'academic_year' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'amount_per_tagihan' => 'nullable|numeric|min:0',
            'tagihan_count' => 'nullable|integer|min:1|max:120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        BillGroup::create($validated);

        return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillGroup $billGroup)
    {
        $levels = Level::all();
        $schools = School::all();

        return view('admin.finance.bill.groups.edit', compact('billGroup', 'levels', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillGroup $billGroup)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'level_id' => 'nullable|exists:levels,id',
            'school_id' => 'nullable|exists:schools,id',
            'academic_year' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'amount_per_tagihan' => 'nullable|numeric|min:0',
            'tagihan_count' => 'nullable|integer|min:1|max:120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $billGroup->update($validated);

        return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillGroup $billGroup)
    {
        $billGroup->delete();

        return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan dihapus.');
    }
}
