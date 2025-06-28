<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreSemesterRequest; // Asumsikan Anda akan membuat form request ini
use App\Http\Requests\UpdateSemesterRequest; // Asumsikan Anda akan membuat form request ini

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Semester::with('schoolYear');

        // Menambahkan fungsionalitas pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('schoolYear', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        // Menambahkan fungsionalitas filter status
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('is_active', (bool)$status);
        }

        // Menggunakan paginasi untuk daftar semester
        $semesters = $query->orderByDesc('id')->paginate(10); // Menampilkan 10 item per halaman

        return view('admin.masters.semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $years = SchoolYear::all();
        return view('admin.masters.semesters.create', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Menggunakan Request standar karena Form Request belum dibuat oleh user
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'name' => 'required|string',
        ]);

        Semester::create([
            'uuid' => Str::uuid(), // generate UUID
            'school_year_id' => $request->school_year_id,
            'name' => $request->name,
            // auto-pilih type berdasarkan nama (ganjil/genap)
            'type' => strtolower($request->name) === 'genap' ? 'genap' : 'ganjil',
            'is_active' => false, // Default is_active ke false saat membuat
        ]);

        // Tetap menggunakan rute yang Anda berikan
        return redirect()->route('shared.semesters.index')->with('success', 'Semester ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        $years = SchoolYear::all();
        return view('admin.masters.semesters.edit', compact('semester', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester) // Menggunakan Request standar karena Form Request belum dibuat oleh user
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'name' => 'required|string',
            'is_active' => 'nullable|boolean', // Pastikan validasi untuk is_active sebagai boolean
        ]);

        // Mengambil nilai is_active, menggunakan boolean cast untuk checkbox
        $is_active = $request->boolean('is_active'); 

        // Jika semester ini diatur aktif, nonaktifkan semester lain di tahun ajaran yang sama
        if ($is_active) {
            Semester::where('school_year_id', $request->school_year_id)
                ->where('id', '!=', $semester->id)
                ->update(['is_active' => false]);
        }

        $semester->update([
            'school_year_id' => $request->school_year_id,
            'name' => $request->name,
            // Re-evaluasi type jika nama berubah
            'type' => strtolower($request->name) === 'genap' ? 'genap' : 'ganjil', 
            'is_active' => $is_active, // Menggunakan nilai boolean yang sudah dikonversi
        ]);

        // Tetap menggunakan rute yang Anda berikan
        return redirect()->route('shared.semesters.index')->with('success', 'Semester diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();
        // Tetap menggunakan rute yang Anda berikan
        return redirect()->route('shared.semesters.index')->with('success', 'Semester dihapus.');
    }
}