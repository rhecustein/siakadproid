<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AbsenceRecord;
use App\Models\AbsenceType;
use Illuminate\Http\Request;

class AbsenceRecordController extends Controller
{
   public function index(Request $request)
{
    // Ambil semua jenis absensi untuk dropdown filter
    $types = AbsenceType::all();

    // Query utama absensi dengan relasi lengkap
    $records = AbsenceRecord::with(['student.kelas', 'type', 'recorder'])
        ->when($request->date, fn($q) => $q->where('date', $request->date))
        ->when($request->absence_type_id, fn($q) => $q->where('absence_type_id', $request->absence_type_id))
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->latest()
        ->get();

    // Inisialisasi jumlah default (0) untuk semua status
    $defaultCounts = [
        'hadir' => 0,
        'izin' => 0,
        'sakit' => 0,
        'alpa' => 0,
        'pulang' => 0,
        'ghoib' => 0,
    ];

    // Hitung aktual dari data yang tersedia
    $actualCounts = $records->groupBy('status')->map->count()->toArray();

    // Gabungkan dengan default agar aman dipakai di view
    $counts = array_merge($defaultCounts, $actualCounts);

    // Group by label jenis absensi untuk tampilan
    $groupedRecords = $records->groupBy(function ($item) {
        return $item->type->label ?? $item->type->name ?? 'Tanpa Label';
    });

    return view('admin.absences.index', compact('records', 'types', 'counts', 'groupedRecords'));
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'absence_type_id' => 'required|exists:absence_types,id',
            'date' => 'required|date',
            'time_segment' => 'nullable|string',
            'status' => 'required|in:hadir,izin,sakit,alpa,pulang,ghoib',
            'remarks' => 'nullable|string',
        ]);

        AbsenceRecord::create($validated);
        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function show(AbsenceRecord $absenceRecord)
    {
        return view('admin.academic.absences.show', [
            'record' => $absenceRecord->load(['student', 'type', 'recorder'])
        ]);
    }

    public function update(Request $request, AbsenceRecord $absenceRecord)
    {
        $validated = $request->validate([
            'student_id' => 'sometimes|exists:users,id',
            'absence_type_id' => 'sometimes|exists:absence_types,id',
            'date' => 'sometimes|date',
            'time_segment' => 'nullable|string',
            'status' => 'sometimes|in:hadir,izin,sakit,alpa,pulang,ghoib',
            'remarks' => 'nullable|string',
        ]);

        $absenceRecord->update($validated);
        return redirect()->back()->with('success', 'Data absensi diperbarui.');
    }

    public function destroy(AbsenceRecord $absenceRecord)
    {
        $absenceRecord->delete();
        return redirect()->back()->with('success', 'Data absensi dihapus.');
    }
}
