<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\LaundryRecord;
use Illuminate\Http\Request;

class LaundryRecordController extends Controller
{
    public function index()
    {
        $laundries = LaundryRecord::with('student')->latest()->get();
        return view('laundry_records.index', compact('laundries'));
    }

    public function create()
    {
        return view('laundry_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'entry_date' => 'required|date',
            'pickup_date' => 'nullable|date|after_or_equal:entry_date',
            'total_items' => 'required|integer|min:1',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        LaundryRecord::create($request->all());

        return redirect()->route('laundry-records.index')->with('success', 'Laundry record added.');
    }

    public function show(LaundryRecord $laundryRecord)
    {
        return view('laundry_records.show', compact('laundryRecord'));
    }

    public function edit(LaundryRecord $laundryRecord)
    {
        return view('laundry_records.edit', compact('laundryRecord'));
    }

    public function update(Request $request, LaundryRecord $laundryRecord)
    {
        $request->validate([
            'pickup_date' => 'nullable|date|after_or_equal:entry_date',
            'total_items' => 'required|integer|min:1',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $laundryRecord->update($request->all());

        return redirect()->route('laundry-records.index')->with('success', 'Laundry record updated.');
    }

    public function destroy(LaundryRecord $laundryRecord)
    {
        $laundryRecord->delete();

        return redirect()->route('laundry-records.index')->with('success', 'Laundry record deleted.');
    }
}
