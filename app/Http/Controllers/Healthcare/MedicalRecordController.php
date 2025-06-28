<?php

namespace App\Http\Controllers\Healthcare;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['student', 'doctor'])->latest()->get();
        return view('medical_records.index', compact('records'));
    }

    public function create()
    {
        return view('medical_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'check_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'checked_by' => 'nullable|exists:users,id',
        ]);

        MedicalRecord::create($request->all());

        return redirect()->route('medical-records.index')->with('success', 'Medical record saved.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return view('medical_records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        return view('medical_records.edit', compact('medicalRecord'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'check_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $medicalRecord->update($request->all());

        return redirect()->route('medical-records.index')->with('success', 'Medical record updated.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')->with('success', 'Medical record deleted.');
    }
}
