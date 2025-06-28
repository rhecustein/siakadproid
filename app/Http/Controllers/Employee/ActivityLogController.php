<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', compact('activityLog'));
    }

    // Opsional: disable create/update/delete for log
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(ActivityLog $activityLog) { abort(403); }
    public function update(Request $request, ActivityLog $activityLog) { abort(403); }
    public function destroy(ActivityLog $activityLog) { abort(403); }
}
