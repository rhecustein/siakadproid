<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\FingerprintLog;
use Illuminate\Http\Request;

class FingerprintLogController extends Controller
{
    public function logScan(Request $request)
    {
        FingerprintLog::create([
            'user_id' => $request->user_id,
            'timestamp' => now(),
            'device_id' => $request->device_id,
        ]);

        return response()->json(['message' => 'Fingerprint logged']);
    }

    public function logs(Request $request)
    {
        return FingerprintLog::with('user')
            ->whereBetween('created_at', [$request->start, $request->end])
            ->get();
    }
}
