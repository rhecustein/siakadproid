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
        $bills = Bill::with(['student', 'group'])
            ->when($request->student_id, fn($q) => $q->where('student_id', $request->student_id))
            ->when($request->bill_group_id, fn($q) => $q->where('bill_group_id', $request->bill_group_id))
            ->latest()
            ->paginate(15);

        $students = Student::all();
        $groups = BillGroup::all();

        return view('admin.finance.bill.index', compact('bills', 'students', 'groups'));
    }

    public function create()
    {
        $students = Student::all();
        $billTypes = BillType::all();
        $billGroups = BillGroup::all();
        $users = User::all();

        return view('admin.finance.bill.create', compact('students', 'billTypes', 'billGroups', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'bill_type_id' => 'required|string',
            'title' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:unpaid,partial,paid',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'bill_group_id' => 'nullable|exists:bill_groups,id',
            'created_by' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        DB::beginTransaction();
        try {
            $bill = Bill::create([
                'student_id'    => $student->id,
                'bill_group_id' => $request->bill_group_id,
                'bill_type_id'  => $request->bill_type_id,
                'title'         => $request->title,
                'total_amount'  => $request->total_amount,
                'status'        => $request->status ?? 'unpaid',
                'start_date'    => $request->start_date ?? now(),
                'due_date'      => $request->due_date ?? now(),
                'created_by'    => $request->created_by,
                'notes'         => $request->notes,
            ]);

            BillItem::create([
                'bill_id'  => $bill->id,
                'name'     => $request->title,
                'label'    => $request->title,
                'amount'   => $request->total_amount,
                'status'   => $request->status ?? 'unpaid',
                'due_date' => $request->due_date ?? now(),
            ]);

            DB::commit();
            return redirect()->route('finance.bills.index')->with('success', 'Tagihan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan tagihan: ' . $e->getMessage());
        }
    }

    public function show(Bill $bill)
    {
        $bill->load(['student', 'group', 'items']);
        return view('admin.finance.bill.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        $bill->items()->delete();
        $bill->delete();

        return redirect()->route('finance.bills.index')->with('success', 'Tagihan siswa dihapus.');
    }

}
