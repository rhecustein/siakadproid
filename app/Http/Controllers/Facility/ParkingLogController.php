<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\ParkingLog;
use Illuminate\Http\Request;

class ParkingLogController extends Controller
{
    public function index()
    {
        $logs = ParkingLog::with(['student', 'parent'])->latest()->get();
        return view('parking_logs.index', compact('logs'));
    }

    public function create()
    {
        return view('parking_logs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'parent_id' => 'nullable|exists:parents,id',
            'vehicle_number' => 'nullable|string',
            'rfid_tag' => 'nullable|string',
            'entry_time' => 'required|date',
            'exit_time' => 'nullable|date',
            'fee' => 'nullable|numeric|min:0',
        ]);

        ParkingLog::create($request->all());

        return redirect()->route('parking-logs.index')->with('success', 'Parking log saved.');
    }

    public function show(ParkingLog $parkingLog)
    {
        return view('parking_logs.show', compact('parkingLog'));
    }

    public function edit(ParkingLog $parkingLog)
    {
        return view('parking_logs.edit', compact('parkingLog'));
    }

    public function update(Request $request, ParkingLog $parkingLog)
    {
        $request->validate([
            'exit_time' => 'nullable|date',
            'fee' => 'nullable|numeric|min:0',
        ]);

        $parkingLog->update($request->all());

        return redirect()->route('parking-logs.index')->with('success', 'Parking log updated.');
    }

    public function destroy(ParkingLog $parkingLog)
    {
        $parkingLog->delete();

        return redirect()->route('parking-logs.index')->with('success', 'Parking log deleted.');
    }
}
