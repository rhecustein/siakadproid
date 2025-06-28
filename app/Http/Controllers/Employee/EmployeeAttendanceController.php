<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
     public function checkIn(Request $request)
    {
        $attendance = EmployeeAttendance::firstOrCreate([
            'staff_id' => $request->staff_id,
            'date' => today(),
        ]);

        $attendance->update(['check_in' => now()]);

        return response()->json(['message' => 'Check-in recorded']);
    }

    public function checkOut(Request $request)
    {
        $attendance = EmployeeAttendance::where('staff_id', $request->staff_id)
            ->where('date', today())
            ->firstOrFail();

        $attendance->update(['check_out' => now()]);

        return response()->json(['message' => 'Check-out recorded']);
    }

    public function summary(Request $request)
    {
        return EmployeeAttendance::whereBetween('date', [$request->from, $request->to])
            ->with('staff')
            ->get();
    }
}
