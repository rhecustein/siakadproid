<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSelection;
use Illuminate\Http\Request;

class AdmissionSelectionController extends Controller
{
    public function index()
    {
        $selections = AdmissionSelection::with('admission')->latest()->get();
        return view('admission_selections.index', compact('selections'));
    }

    public function create()
    {
        return view('admission_selections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'selection_date' => 'required|date',
            'result' => 'nullable|in:passed,failed',
        ]);

        AdmissionSelection::create($request->all());

        return redirect()->route('admission-selections.index')->with('success', 'Selection saved.');
    }

    public function show(AdmissionSelection $admissionSelection)
    {
        return view('admission_selections.show', compact('admissionSelection'));
    }

    public function edit(AdmissionSelection $admissionSelection)
    {
        return view('admission_selections.edit', compact('admissionSelection'));
    }

    public function update(Request $request, AdmissionSelection $admissionSelection)
    {
        $request->validate([
            'selection_date' => 'required|date',
            'result' => 'nullable|in:passed,failed',
        ]);

        $admissionSelection->update($request->all());

        return redirect()->route('admission-selections.index')->with('success', 'Selection updated.');
    }

    public function destroy(AdmissionSelection $admissionSelection)
    {
        $admissionSelection->delete();

        return redirect()->route('admission-selections.index')->with('success', 'Selection deleted.');
    }
}
