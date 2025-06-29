<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillGroup;
use App\Models\BillType;
use App\Models\BillItem;
use App\Models\Student;
use App\Models\School;
use App\Models\Level;
use App\Models\User;
use App\Models\GradeLevel;
use App\Models\AcademicYear;
use App\Services\BillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillController extends Controller
{
    public function index(Request $request)
    {
        // Eager load relasi yang diperlukan untuk tabel dan perhitungan
        $query = Bill::with(['student', 'billGroup', 'items']); // Load `items` juga untuk perhitungan

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('student', function ($sq) use ($request) {
                      $sq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter berdasarkan student_id
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter berdasarkan bill_group_id
        if ($request->filled('bill_group_id')) {
            $query->where('bill_group_id', $request->bill_group_id);
        }

        // Filter berdasarkan status tagihan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bills = $query->latest()->paginate(15)->appends($request->query());

        // Menghitung data untuk count cards
        $totalBillsAmount = Bill::sum('total_amount');
        $paidBillsAmount = Bill::where('status', 'paid')->sum('total_amount');
        $unpaidBillsAmount = Bill::whereIn('status', ['unpaid', 'partial'])->sum('total_amount');
        $totalStudentsWithBills = Bill::distinct('student_id')->count('student_id');

        // Data untuk filter dropdown
        $students = Student::orderBy('name')->get();
        $billGroups = BillGroup::orderBy('name')->get();
        $billTypes = BillType::orderBy('name')->get();

        return view('admin.finance.bill.index', compact('bills', 'students', 'billGroups', 'billTypes', 'totalBillsAmount', 'unpaidBillsAmount', 'paidBillsAmount', 'totalStudentsWithBills'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get(); // Diurutkan
        $billTypes = BillType::orderBy('name')->get(); // Diurutkan
        $billGroups = BillGroup::orderBy('name')->get(); // Diurutkan
        $users = User::orderBy('name')->get(); // Diurutkan untuk 'created_by'

        return view('admin.finance.bill.create', compact('students', 'billTypes', 'billGroups', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'bill_type_id'  => 'required|exists:bill_types,id',
            'title'         => 'required|string|max:255',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'nullable|in:unpaid,partial,paid',
            'start_date'    => 'nullable|date',
            'due_date'      => 'required|date|after_or_equal:start_date',
            'bill_group_id' => 'nullable|exists:bill_groups,id',
            'created_by'    => 'nullable|exists:users,id',
            'notes'         => 'nullable|string',
            // Validasi untuk item tagihan, jika dikirim dari form
            // Jika Anda tidak menggunakan input dinamis untuk item di create form,
            // maka validasi 'items' dan turunannya ini tidak diperlukan di sini
            'items'         => 'array',
            'items.*.name'  => 'required_with:items|string|max:255',
            'items.*.label' => 'nullable|string|max:255',
            'items.*.amount'=> 'required_with:items|numeric|min:0',
            'items.*.due_date' => 'nullable|date', // Tidak ada after_or_equal:items.*.start_date
            'items.*.status' => 'nullable|in:unpaid,partial,paid',
        ]);

        DB::beginTransaction();
        try {
            $status = $validatedData['status'] ?? 'unpaid';

            $bill = Bill::create([
                'student_id'    => $validatedData['student_id'],
                'bill_group_id' => $validatedData['bill_group_id'],
                'bill_type_id'  => $validatedData['bill_type_id'],
                'title'         => $validatedData['title'],
                'total_amount'  => $validatedData['total_amount'],
                'status'        => $status,
                'start_date'    => $validatedData['start_date'] ? Carbon::parse($validatedData['start_date']) : now(),
                'due_date'      => Carbon::parse($validatedData['due_date']),
                'created_by'    => $validatedData['created_by'] ?? Auth::id(),
                'notes'         => $validatedData['notes'],
            ]);

            // Jika ada item tagihan yang dikirim dari form, buat BillItem-nya
            if (isset($validatedData['items']) && !empty($validatedData['items'])) {
                foreach ($validatedData['items'] as $itemData) {
                    BillItem::create([
                        'bill_id'   => $bill->id,
                        'name'      => $itemData['name'],
                        'label'     => $itemData['label'] ?? $itemData['name'],
                        'amount'    => $itemData['amount'],
                        'status'    => $itemData['status'] ?? 'unpaid',
                        'due_date'  => $itemData['due_date'] ? Carbon::parse($itemData['due_date']) : $bill->due_date,
                    ]);
                }
            } else {
                // Jika tidak ada item yang dikirim (form manual sederhana), buat satu item default
                BillItem::create([
                    'bill_id'   => $bill->id,
                    'name'      => $validatedData['title'],
                    'label'     => $validatedData['title'],
                    'amount'    => $validatedData['total_amount'],
                    'status'    => $status,
                    'due_date'  => Carbon::parse($validatedData['due_date']),
                ]);
            }

            DB::commit();
            return redirect()->route('finance.bills.index')->with('success', 'Tagihan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan tagihan: ' . $e->getMessage());
        }
    }

    public function show(Bill $bill)
    {
        $bill->load(['student', 'billGroup', 'billType', 'items.billPayment', 'createdBy']);
        return view('admin.finance.bill.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        DB::beginTransaction();
        try {
            $bill->items()->delete();
            $bill->delete();

            DB::commit();
            return redirect()->route('finance.bills.index')->with('success', 'Tagihan siswa dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus tagihan: ' . $e->getMessage());
        }
    }

    // Metode untuk tampilan generate tagihan masal
    public function generateMass(Request $request) // Tambahkan Request $request
    {
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $billTypes = BillType::all();
        $billGroups = BillGroup::all();
        $schools = School::all();
        $gradeLevels = GradeLevel::all();

        // Ambil siswa berdasarkan filter yang diterapkan (jika ada)
        $queryStudents = Student::query()
            ->with(['school', 'grade', 'currentClassroomAssignment.classroom']); // Eager load relasi yang dibutuhkan

        if ($request->filled('academic_year_id')) {
            $queryStudents->whereHas('currentClassroomAssignment', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }
        if ($request->filled('school_id')) {
            $queryStudents->where('school_id', $request->school_id);
        }
        if ($request->filled('grade_level_id')) { // Menggunakan grade_level_id dari filter
            $queryStudents->whereHas('currentClassroomAssignment.classroom', function($q) use ($request) {
                $q->where('grade_id', $request->grade_level_id); // Asumsi kolom grade_id di tabel classrooms
            });
        }
        if ($request->filled('student_status')) {
            $queryStudents->where('student_status', $request->student_status);
        }
        if ($request->filled('search')) { // Filter pencarian
             $queryStudents->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $students = $queryStudents->paginate(15)->appends($request->query());

        // Hitung ringkasan siswa untuk tampilan
        $totalStudentsFiltered = $students->total(); // Total dari hasil paginasi
        $selectedStudentCount = count($request->input('student_ids', [])); // Jumlah siswa yang tercentang

        return view('admin.finance.bill.generate', compact(
            'academicYears', 'billTypes', 'billGroups', 'schools', 'gradeLevels',
            'students', 'totalStudentsFiltered', 'selectedStudentCount'
        ));
    }

    // Metode untuk memproses generate tagihan masal
    public function processMassGeneration(Request $request, BillService $billService)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1', // Harus ada setidaknya 1 siswa terpilih
            'student_ids.*' => 'exists:students,id',
            'bill_type_id' => 'required|exists:bill_types,id',
            'bill_group_id' => 'required|exists:bill_groups,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount_per_item' => 'required|numeric|min:0',
            'number_of_items' => 'required|integer|min:1',
            'due_date_per_item' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            // Panggil BillService untuk melakukan generate
            // BillService.php harus punya metode generateMassBills yang menerima array data
            $billService->generateMassBills(
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

            return redirect()->route('finance.bills.index')->with('success', 'Tagihan masal berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat tagihan masal: ' . $e->getMessage());
        }
    }

    // Endpoint API untuk memfilter siswa secara AJAX (digunakan di form generate massal)
    public function filterStudentsForGenerate(Request $request)
    {
        // Mendapatkan ID tahun ajaran aktif saat ini
        $currentAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        $query = Student::query()
            ->with([
                'school',
                'grade', // grade_level
                'currentClassroomAssignment.classroom', // Load classroom dari assignment
                'currentClassroomAssignment.academicYear' // Load academicYear dari assignment
            ]);

        // Terapkan filter yang sama seperti di generateMass()
        if ($request->filled('academic_year_id')) {
            $query->whereHas('currentClassroomAssignment', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        } else {
             // Jika academic_year_id tidak diisi, default ke tahun ajaran aktif
             $query->whereHas('currentClassroomAssignment', function($q) use ($currentAcademicYearId) {
                $q->where('academic_year_id', $currentAcademicYearId);
            });
        }
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }
        if ($request->filled('grade_level_id')) {
            $query->whereHas('currentClassroomAssignment.classroom', function($q) use ($request) {
                $q->where('grade_id', $request->grade_level_id);
            });
        }
        if ($request->filled('student_status')) {
            $query->where('student_status', $request->student_status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->get(); // Menggunakan get() karena frontend akan melakukan paginasi/filtering visual

        // Format data untuk frontend, termasuk relasi yang di-eager load
        $formattedStudents = $students->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'nisn' => $student->nisn,
                'nis' => $student->nis,
                'current_classroom' => [
                    'name' => optional(optional($student->currentClassroomAssignment)->classroom)->name,
                ],
                'grade' => [
                    'name' => optional($student->grade)->name,
                ],
                'school' => [
                    'name' => optional($student->school)->name,
                ],
                'student_status' => $student->student_status,
                // Tambahkan data lain yang dibutuhkan di student-checkbox label
            ];
        });


        return response()->json(['students' => $formattedStudents]);
    }
}