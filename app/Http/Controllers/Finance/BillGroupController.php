<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

use App\Models\BillGroup;
use App\Models\BillType;
use App\Models\AcademicYear;
use App\Models\BillGroupDetail;
use App\Models\Level;
use App\Models\School;
use Illuminate\Http\Request;

class BillGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Eager load semua relasi yang mungkin dibutuhkan di tabel
        $query = BillGroup::with(['school', 'level', 'academicYear', 'billType']);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan jenis tagihan (bill_type_id)
        if ($request->filled('bill_type_id')) { // Mengubah parameter dari 'type' menjadi 'bill_type_id'
            $query->where('bill_type_id', $request->bill_type_id);
        }

        // Filter berdasarkan sekolah
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        // Filter berdasarkan jenjang/level
        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('academic_year_id')) { // Mengubah parameter dari 'academic_year' menjadi 'academic_year_id'
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // Filter berdasarkan gender (jika ada)
        if ($request->filled('gender')) { // Asumsi ada filter gender
            $query->where('gender', $request->gender);
        }

        $billGroups = $query->latest()->paginate(15)->appends($request->query());

        // Menghitung data untuk count cards
        $totalBillGroups = BillGroup::count();
        $activeBillGroups = BillGroup::where('is_active', true)->count(); // Asumsi ada kolom is_active
        // Asumsi type 'spp' dan 'uang_gedung' ada di tabel bill_types yang dihubungkan
        $sppBillTypeId = BillType::where('name', 'like', '%spp%')->value('id');
        $gedungBillTypeId = BillType::where('name', 'like', '%uang gedung%')->value('id');

        $sppGroups = BillGroup::when($sppBillTypeId, fn($q) => $q->where('bill_type_id', $sppBillTypeId))->count();
        $gedungGroups = BillGroup::when($gedungBillTypeId, fn($q) => $q->where('bill_type_id', $gedungBillTypeId))->count();


        // Data untuk dropdown filter
        $schools = School::all();
        $levels = Level::all();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $billTypes = BillType::orderBy('name')->get(); // Semua tipe tagihan untuk dropdown filter

        return view('admin.finance.bill.groups.index', compact(
            'billGroups', 'schools', 'levels', 'academicYears', 'billTypes',
            'totalBillGroups', 'activeBillGroups', 'sppGroups', 'gedungGroups'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = Level::all();
        $schools = School::all();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $billTypes = BillType::all(); // Semua tipe tagihan untuk dropdown

        return view('admin.finance.bill.groups.create', compact('levels', 'schools', 'academicYears', 'billTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'                  => 'required|string|max:255',
            'bill_type_id'          => 'required|exists:bill_types,id', // Diubah dari 'type' string menjadi ID
            'level_id'              => 'nullable|exists:levels,id',
            'school_id'             => 'nullable|exists:schools,id',
            'academic_year_id'      => 'nullable|exists:academic_years,id', // Diubah dari 'academic_year' string menjadi ID
            'gender'                => 'nullable|in:male,female',
            'amount_per_tagihan'    => 'required|numeric|min:0', // required
            'tagihan_count'         => 'required|integer|min:1|max:120', // required
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'description'           => 'nullable|string',
            'is_active'             => 'boolean', // Asumsi ada kolom ini di DB
        ]);

        // Tangani nilai boolean dari checkbox (jika ada di form dan tidak terkirim jika tidak dicentang)
        $validatedData['is_active'] = $request->has('is_active');


        BillGroup::create($validatedData);

        return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillGroup $billGroup)
    {
        $levels = Level::all();
        $schools = School::all();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $billTypes = BillType::all();

        return view('admin.finance.bill.groups.edit', compact('billGroup', 'levels', 'schools', 'academicYears', 'billTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillGroup $billGroup)
    {
        $validatedData = $request->validate([
            'name'                  => 'required|string|max:255',
            'bill_type_id'          => 'required|exists:bill_types,id',
            'level_id'              => 'nullable|exists:levels,id',
            'school_id'             => 'nullable|exists:schools,id',
            'academic_year_id'      => 'nullable|exists:academic_years,id',
            'gender'                => 'nullable|in:male,female',
            'amount_per_tagihan'    => 'required|numeric|min:0',
            'tagihan_count'         => 'required|integer|min:1|max:120',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'description'           => 'nullable|string',
            'is_active'             => 'boolean',
        ]);

        // Tangani nilai boolean dari checkbox
        $validatedData['is_active'] = $request->has('is_active');

        $billGroup->update($validatedData);

        return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillGroup $billGroup)
    {
        try {
            $billGroup->delete();
            return redirect()->route('finance.bill-groups.index')->with('success', 'Grup tagihan dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('finance.bill-groups.index')->with('error', 'Gagal menghapus grup tagihan: ' . $e->getMessage());
        }
    }
}