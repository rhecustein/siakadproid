<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillManualController extends Controller
{
    /**
     * Tampilkan form pemilihan siswa dan tagihannya.
     */
    public function index(Request $request)
    {
        $students = Student::orderBy('name')->get();

        $selectedStudent = null;
        $bills = collect();

        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->student_id);

            $bills = Bill::with(['items' => function ($q) {
                    $q->whereIn('status', ['unpaid', 'partial']);
                }])
                ->where('student_id', $selectedStudent->id)
                ->whereIn('status', ['unpaid', 'partial'])
                ->get();
        }

        return view('admin.finance.bill.manual.index', compact('students', 'selectedStudent', 'bills'));
    }

    /**
     * Simpan pembayaran manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'bill_id'      => 'required|exists:bills,id',
            'item_ids'     => 'required|array|min:1',
            'item_ids.*'   => 'exists:bill_items,id',
            'amount'       => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method'       => 'required|string|max:50',
            'notes'        => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'student_id'   => $request->student_id,
                'bill_id'      => $request->bill_id,
                'amount'       => $request->amount,
                'payment_date' => Carbon::parse($request->payment_date),
                'method'       => $request->method,
                'notes'        => $request->notes,
                'created_by'   => auth()->id(),
            ]);

            $remaining = $payment->amount;

            foreach ($request->item_ids as $itemId) {
                $item = BillItem::findOrFail($itemId);

                if ($item->status === 'paid') continue;

                if ($remaining >= $item->amount) {
                    $item->status = 'paid';
                    $remaining -= $item->amount;
                } elseif ($remaining > 0) {
                    $item->status = 'partial';
                    $remaining = 0;
                }

                $item->save();

                if ($remaining <= 0) break;
            }

            // Update status bill
            $bill = Bill::with('items')->find($request->bill_id);
            $paidCount = $bill->items->where('status', 'paid')->count();
            $totalItems = $bill->items->count();

            if ($paidCount === $totalItems) {
                $bill->status = 'paid';
            } elseif ($paidCount > 0) {
                $bill->status = 'partial';
            }

            $bill->save();

            DB::commit();
            return redirect()->route('finance.bills.index')->with('success', 'Pembayaran berhasil dicatat.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
        }
    }
}
