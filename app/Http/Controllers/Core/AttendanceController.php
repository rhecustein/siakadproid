<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Tampilkan daftar absensi dengan filter dan pagination.
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'unit']);

        if ($request->filled('role_type')) {
            $query->where('role_type', $request->role_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->orderByDesc('date')->paginate(20);
        return view('attendances.index', compact('attendances'));
    }

    /**
     * Proses input absensi manual (store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_type' => 'required|string',
            'type' => 'required|in:masuk,pulang',
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'device' => 'nullable|string',
            'location' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'school_id' => 'nullable|exists:schools,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'notes' => 'nullable|string',
            'is_manual' => 'nullable|boolean',
        ]);

        Attendance::create([
            'uuid' => Str::uuid(),
            'user_id' => $request->user_id,
            'role_type' => $request->role_type,
            'type' => $request->type,
            'status' => $request->status,
            'date' => $request->date ?? now()->toDateString(),
            'time' => $request->time ?? now()->toTimeString(),
            'device' => $request->device,
            'location' => $request->location,
            'unit_id' => $request->unit_id,
            'school_id' => $request->school_id,
            'academic_year_id' => $request->academic_year_id,
            'notes' => $request->notes,
            'is_manual' => $request->boolean('is_manual'),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan.');
    }

    /**
     * Tampilkan absensi hari ini untuk role tertentu (API).
     */
    public function today(Request $request)
    {
        $request->validate([
            'role_type' => 'required|string',
        ]);

        return Attendance::with('user')
            ->where('date', today())
            ->where('role_type', $request->role_type)
            ->get();
    }

    /**
     * Riwayat absensi user tertentu (per user).
     */
    public function show($id)
    {
        $user = User::with('unit')->findOrFail($id);

        $attendances = Attendance::where('user_id', $id)
            ->orderByDesc('date')
            ->paginate(30);

        $attendanceStats = Attendance::where('user_id', $id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('core.attendances.show', compact('user', 'attendances', 'attendanceStats'));
    }

    /**
     * Halaman input absensi manual (form).
     */
    public function manual()
    {
        $users = User::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('attendances.manual', compact('users', 'units'));
    }
}
