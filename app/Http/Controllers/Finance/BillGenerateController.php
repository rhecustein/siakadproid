<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\BillGroup;
use App\Models\BillType;
use App\Models\GradeLevel;
use App\Models\Level;
use App\Models\School;
use App\Models\Student;
use App\Services\BillService;
use Illuminate\Http\Request;

class BillGenerateController extends Controller
{
    /**
     * Menampilkan form untuk generate tagihan masal dan daftar siswa yang dapat difilter.
     * Metode ini berfungsi sebagai 'index' untuk generate masal.
     */
    public function index(Request $request) // Mengubah nama metode ini untuk kejelasan
    {
        // Data untuk dropdown filter
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $billTypes = BillType::all();
        $billGroups = BillGroup::all();
        $schools = School::all();
        $gradeLevels = GradeLevel::all();

        // Mengambil siswa yang difilter (untuk daftar siswa di panel kiri)
        $currentAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        $queryStudents = Student::query()
            ->with([
                'school',
                'grade', // grade_level
                'currentClassroomAssignment.classroom',
                'currentClassroomAssignment.academicYear'
            ]);

        // Menerapkan filter berdasarkan request
        if ($request->filled('academic_year_id')) {
            $queryStudents->whereHas('currentClassroomAssignment', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        } else {
             // Default ke tahun ajaran aktif jika tidak ada filter tahun ajaran yang dipilih
             $queryStudents->whereHas('currentClassroomAssignment', function($q) use ($currentAcademicYearId) {
                $q->where('academic_year_id', $currentAcademicYearId);
            });
        }
        if ($request->filled('school_id')) {
            $queryStudents->where('school_id', $request->school_id);
        }
        if ($request->filled('grade_level_id')) { // Menggunakan grade_level_id dari filter
            $queryStudents->whereHas('currentClassroomAssignment.classroom', function($q) use ($request) {
                $q->where('grade_id', $request->grade_level_id);
            });
        }
        if ($request->filled('student_status')) {
            $queryStudents->where('student_status', $request->student_status);
        }
        if ($request->filled('search')) { // Filter pencarian nama/NIS/NISN
             $queryStudents->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $students = $queryStudents->paginate(15)->appends($request->query());

        // Hitung ringkasan siswa untuk tampilan
        $totalStudentsFiltered = $students->total(); // Total siswa di hasil filter
        // Jumlah siswa yang tercentang tidak bisa langsung dari controller web request
        // Akan dihitung di frontend (JavaScript)
        $selectedStudentCount = 0; // Ini akan diisi oleh JS di frontend

        return view('admin.finance.bill.generate', compact(
            'academicYears', 'billTypes', 'billGroups', 'schools', 'gradeLevels',
            'students', 'totalStudentsFiltered', 'selectedStudentCount'
        ));
    }


    /**
     * Memproses permintaan untuk generate tagihan masal.
     * Ini menggantikan metode 'store' lama di BillGenerateController.
     */
    public function store(Request $request, BillService $billService)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1', // Harus ada setidaknya 1 siswa terpilih
            'student_ids.*' => 'exists:students,id', // Pastikan semua ID siswa valid
            'bill_type_id' => 'required|exists:bill_types,id',
            'bill_group_id' => 'required|exists:bill_groups,id',
            'academic_year_id' => 'required|exists:academic_years,id', // Tahun ajaran dari filter siswa
            'amount_per_item' => 'required|numeric|min:0',
            'number_of_items' => 'required|integer|min:1',
            'due_date_per_item' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            // Anda tidak perlu lagi validasi filter siswa di sini, karena sudah difilter di generateMass/index
        ]);

        try {
            // Panggil BillService untuk melakukan generate
            // BillService.php harus punya metode generateMassBills yang menerima parameter ini
            $count = $billService->generateMassBills(
                $request->student_ids,
                $request->bill_type_id,
                $request->bill_group_id,
                $request->academic_year_id,
                $request->amount_per_item,
                $request->number_of_items,
                $request->due_date_per_item,
                $request->description,
                $request->notes,
                Auth::id() // User yang melakukan generate
            );

            return redirect()->route('finance.bills.index')->with('success', "$count tagihan berhasil dibuat.");
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat tagihan masal: ' . $e->getMessage());
        }
    }
}