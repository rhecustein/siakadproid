<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingHistory;
use Illuminate\Http\Request;

class CounselingHistoryController extends Controller
{
    public function index()
    {
        $histories = CounselingHistory::with(['student', 'counselor'])->latest()->get();
        return view('counseling_histories.index', compact('histories'));
    }

    public function create()
    {
        return view('counseling_histories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'counselor_id' => 'required|exists:users,id',
            'counseling_date' => 'required|date',
            'topic' => 'required|string',
            'summary' => 'nullable|string',
            'recommendation' => 'nullable|string',
        ]);

        CounselingHistory::create($request->all());

        return redirect()->route('counseling-histories.index')->with('success', 'History saved.');
    }

    public function show(CounselingHistory $counselingHistory)
    {
        return view('counseling_histories.show', compact('counselingHistory'));
    }

    public function edit(CounselingHistory $counselingHistory)
    {
        return view('counseling_histories.edit', compact('counselingHistory'));
    }

    public function update(Request $request, CounselingHistory $counselingHistory)
    {
        $request->validate([
            'counseling_date' => 'required|date',
            'topic' => 'required|string',
            'summary' => 'nullable|string',
            'recommendation' => 'nullable|string',
        ]);

        $counselingHistory->update($request->all());

        return redirect()->route('counseling-histories.index')->with('success', 'History updated.');
    }

    public function destroy(CounselingHistory $counselingHistory)
    {
        $counselingHistory->delete();

        return redirect()->route('counseling-histories.index')->with('success', 'History deleted.');
    }
}
