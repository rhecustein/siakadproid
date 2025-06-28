<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceRecapController extends Controller
{
    public function dailyRecap(Request $request)
    {
        return Attendance::whereDate('date', $request->date ?? today())
            ->with('user')
            ->get()
            ->groupBy('role_type');
    }

    public function monthlyRecap(Request $request)
    {
        return Attendance::select('user_id', 'role_type', 'status', DB::raw('count(*) as total'))
            ->whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->groupBy('user_id', 'role_type', 'status')
            ->with('user')
            ->get();
    }
}
