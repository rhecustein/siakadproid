<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenCashShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CanteenCashShiftController extends Controller
{
    public function index()
    {
        $shifts = CanteenCashShift::with(['canteen', 'cashier'])
            ->latest('shift_start')
            ->get();

        return view('canteen.shifts.index', compact('shifts'));
    }

    public function open()
    {
        return view('canteen.shifts.open');
    }

    public function store(Request $request)
    {
        $request->validate([
            'canteen_id' => 'required|exists:canteens,id',
            'opening_cash' => 'required|numeric|min:0',
        ]);

        CanteenCashShift::create([
            'canteen_id' => $request->canteen_id,
            'cashier_id' => Auth::id(),
            'shift_start' => Carbon::now(),
            'opening_cash' => $request->opening_cash,
        ]);

        return redirect()->route('canteen.pos')->with('success', 'Shift kasir dimulai');
    }

    public function close(Request $request, $id)
    {
        $shift = CanteenCashShift::findOrFail($id);

        $request->validate([
            'closing_cash' => 'required|numeric|min:0',
        ]);

        $systemTotal = $shift->canteen->sales()
            ->where('cashier_id', $shift->cashier_id)
            ->whereBetween('transaction_time', [$shift->shift_start, now()])
            ->sum('total_amount');

        $shift->update([
            'closing_cash' => $request->closing_cash,
            'shift_end' => now(),
            'system_sales' => $systemTotal,
            'difference' => $request->closing_cash - $systemTotal,
            'note' => $request->note,
        ]);

        return redirect()->route('canteen.pos')->with('success', 'Shift kasir ditutup');
    }
}
