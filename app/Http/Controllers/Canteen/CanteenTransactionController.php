<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenTransaction;
use Illuminate\Http\Request;

class CanteenTransactionController extends Controller
{
    public function index()
    {
        $transactions = CanteenTransaction::with(['student', 'cashier'])->latest()->get();
        return view('canteen_transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('canteen_transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'transaction_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'nullable|array',
            'processed_by' => 'required|exists:users,id',
        ]);

        CanteenTransaction::create([
            'student_id' => $request->student_id,
            'transaction_date' => $request->transaction_date,
            'total_amount' => $request->total_amount,
            'items' => $request->items,
            'processed_by' => $request->processed_by,
        ]);

        return redirect()->route('canteen-transactions.index')->with('success', 'Transaction recorded.');
    }

    public function show(CanteenTransaction $canteenTransaction)
    {
        return view('canteen_transactions.show', compact('canteenTransaction'));
    }

    public function edit(CanteenTransaction $canteenTransaction)
    {
        return view('canteen_transactions.edit', compact('canteenTransaction'));
    }

    public function update(Request $request, CanteenTransaction $canteenTransaction)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'nullable|array',
        ]);

        $canteenTransaction->update([
            'transaction_date' => $request->transaction_date,
            'total_amount' => $request->total_amount,
            'items' => $request->items,
        ]);

        return redirect()->route('canteen-transactions.index')->with('success', 'Transaction updated.');
    }

    public function destroy(CanteenTransaction $canteenTransaction)
    {
        $canteenTransaction->delete();

        return redirect()->route('canteen-transactions.index')->with('success', 'Transaction deleted.');
    }
}
