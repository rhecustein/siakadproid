<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSchedule;
use Illuminate\Http\Request;

class AdmissionScheduleController extends Controller
{
    // Show all schedules
    public function index()
    {
        $schedules = AdmissionSchedule::all();
        return view('admissions.admission_schedules.index', compact('schedules'));
    }

    // Show form to create a new schedule
    public function create()
    {
        return view('admissions.admission_schedules.create');
    }

    // Store new schedule
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        AdmissionSchedule::create($request->only('name', 'start_date', 'end_date'));

        return redirect()->route('admission-schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Show form to edit a schedule
    public function edit($id)
    {
        $schedule = AdmissionSchedule::findOrFail($id);
        return view('admissions.admission_schedules.edit', compact('schedule'));
    }

    // Update schedule
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $schedule = AdmissionSchedule::findOrFail($id);
        $schedule->update($request->only('name', 'start_date', 'end_date'));

        return redirect()->route('admission-schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // Delete schedule
    public function destroy($id)
    {
        AdmissionSchedule::destroy($id);
        return redirect()->route('admission-schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
