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
        $students = Student::orderBy('name')->get(); // Mengurutkan siswa
        $billGroups = BillGroup::orderBy('name')->get(); // Mengurutkan grup tagihan
        $billTypes = BillType::orderBy('name')->get(); // Jika dibutuhkan filter tipe tagihan di index

        return view('admin.finance.bill.index', compact('bills', 'students', 'billGroups', 'billTypes', 'totalBillsAmount', 'unpaidBillsAmount', 'paidBillsAmount', 'totalStudentsWithBills'));
    }

    public function create()
    {
        $students = Student::all();
        $billTypes = BillType::all();
        $billGroups = BillGroup::all();
        $users = User::all(); // Untuk 'created_by'

        return view('admin.finance.bill.create', compact('students', 'billTypes', 'billGroups', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'bill_type_id'  => 'required|exists:bill_types,id', // Pastikan ini ID dari bill_types
            'title'         => 'required|string|max:255',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'nullable|in:unpaid,partial,paid',
            'start_date'    => 'nullable|date',
            'due_date'      => 'required|date|after_or_equal:start_date', // Due date wajib dan setelah start_date
            'bill_group_id' => 'nullable|exists:bill_groups,id',
            'created_by'    => 'nullable|exists:users,id', // User yang membuat tagihan
            'notes'         => 'nullable|string',
            // Jika ada detail item tagihan yang dikirim bersamaan, tambahkan validasinya di sini
            'items'         => 'array', // Array item tagihan
            'items.*.name'  => 'required_with:items|string|max:255',
            'items.*.label' => 'nullable|string|max:255',
            'items.*.amount'=> 'required_with:items|numeric|min:0',
            'items.*.due_date' => 'nullable|date|after_or_equal:items.*.start_date', // Jika item punya start_date
            'items.*.status' => 'nullable|in:unpaid,partial,paid',
        ]);

        DB::beginTransaction();
        try {
            // Jika status tidak dikirim, default ke 'unpaid'
            $status = $validatedData['status'] ?? 'unpaid';

            // Buat tagihan utama
            $bill = Bill::create([
                'student_id'    => $validatedData['student_id'],
                'bill_group_id' => $validatedData['bill_group_id'],
                'bill_type_id'  => $validatedData['bill_type_id'], // Menggunakan ID
                'title'         => $validatedData['title'],
                'total_amount'  => $validatedData['total_amount'],
                'status'        => $status,
                'start_date'    => $validatedData['start_date'] ? Carbon::parse($validatedData['start_date']) : now(),
                'due_date'      => Carbon::parse($validatedData['due_date']),
                'created_by'    => $validatedData['created_by'] ?? Auth::id(), // Default ke user yang sedang login
                'notes'         => $validatedData['notes'],
            ]);

            // Jika ada item tagihan, buat BillItem-nya
            if (!empty($validatedData['items'])) {
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
                // Jika tidak ada item yang dikirim, buat satu item default dari data tagihan utama
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
        $bill->load(['student', 'billGroup', 'billType', 'items.billPayment', 'createdBy']); // Load billType dan createdBy
        return view('admin.finance.bill.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        DB::beginTransaction();
        try {
            $bill->items()->delete(); // Hapus semua item tagihan terkait
            $bill->delete(); // Hapus tagihan utama

            DB::commit();
            return redirect()->route('finance.bills.index')->with('success', 'Tagihan siswa berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus tagihan: ' . $e->getMessage());
        }
    }

    // Metode untuk tampilan generate tagihan masal
    public function generateMass()
    {
        // Logika untuk menampilkan form generate tagihan masal
        // Perlu data seperti academic years, classrooms, students, bill types, dll.
        $academicYears = AcademicYear::orderByDesc('year')->get(); // Asumsi ada model AcademicYear
        $billTypes = BillType::all();
        $billGroups = BillGroup::all();
        $schools = School::all(); // Asumsi ada model School
        $gradeLevels = GradeLevel::all(); // Asumsi ada model GradeLevel

        return view('admin.finance.bill.generate', compact('academicYears', 'billTypes', 'billGroups', 'schools', 'gradeLevels'));
    }

    // Metode untuk memproses generate tagihan masal
    public function processMassGeneration(Request $request, BillService $billService)
    {
        $request->validate([
            'bill_type_id' => 'required|exists:bill_types,id',
            'bill_group_id' => 'required|exists:bill_groups,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount_per_item' => 'required|numeric|min:0',
            'number_of_items' => 'required|integer|min:1', // Jumlah item jika berulang (misal: 12 untuk SPP)
            'due_date_per_item' => 'required|date', // Jatuh tempo untuk setiap item
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            // Filter siswa
            'school_id' => 'nullable|exists:schools,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'student_status' => 'nullable|string|in:aktif,nonaktif,lulus,alumni',
        ]);

        try {
            $billService->generateMassBills($request->all()); // Memanggil service untuk logika generate
            return redirect()->route('finance.bills.index')->with('success', 'Tagihan masal berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat tagihan masal: ' . $e->getMessage());
        }
    }
}