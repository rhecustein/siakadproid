<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingSchedule;
use Illuminate\Http\Request;

class CounselingScheduleController extends Controller
{
    public function index()
    {
        $schedules = CounselingSchedule::with(['student', 'counselor'])->latest()->get();
        return view('counseling_schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('counseling_schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
            'topic' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        CounselingSchedule::create($request->all());

        return redirect()->route('counseling-schedules.index')->with('success', 'Counseling scheduled.');
    }

    public function show(CounselingSchedule $counselingSchedule)
    {
        return view('counseling_schedules.show', compact('counselingSchedule'));
    }

    public function edit(CounselingSchedule $counselingSchedule)
    {
        return view('counseling_schedules.edit', compact('counselingSchedule'));
    }

    public function update(Request $request, CounselingSchedule $counselingSchedule)
    {
        $request->validate([
            'scheduled_at' => 'required|date',
            'topic' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $counselingSchedule->update($request->all());

        return redirect()->route('counseling-schedules.index')->with('success', 'Schedule updated.');
    }

    public function destroy(CounselingSchedule $counselingSchedule)
    {
        $counselingSchedule->delete();

        return redirect()->route('counseling-schedules.index')->with('success', 'Schedule deleted.');
    }
}
