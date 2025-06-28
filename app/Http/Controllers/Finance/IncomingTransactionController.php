<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\IncomingTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class IncomingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wallets = Wallet::all();
        $transactions = IncomingTransaction::with(['wallet', 'receiver'])
            ->when($request->wallet_id, fn($q) => $q->where('wallet_id', $request->wallet_id))
            ->when($request->method, fn($q) => $q->where('method', $request->method))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(20);

        return view('finance.incoming_transactions.index', compact('transactions', 'wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wallets = Wallet::with('owner')->orderBy('id', 'desc')->get();
        return view('finance.incoming_transactions.create', compact('wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => ['required', 'exists:wallets,id'],
            'amount' => ['required', 'numeric', 'min:100'],
            'method' => ['required', 'string', 'max:50'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['received_by'] = auth()->id();
        $validated['status'] = 'confirmed';

        DB::transaction(function () use ($validated) {
            // Tambah saldo ke wallet
            $wallet = Wallet::findOrFail($validated['wallet_id']);
            $wallet->balance += $validated['amount'];
            $wallet->save();

            // Buat transaksi masuk
            $transaction = IncomingTransaction::create($validated);

            // Log ke wallet_logs
            $wallet->logs()->create([
                'type' => 'credit',
                'amount' => $validated['amount'],
                'balance_after' => $wallet->balance,
                'note' => $validated['note'] ?? 'Transaksi Masuk (' . $validated['method'] . ')',
                'source_type' => IncomingTransaction::class,
                'source_id' => $transaction->id,
                'created_by' => $validated['received_by'],
            ]);
        });

        return redirect()->route('incoming-transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingTransaction $incomingTransaction)
    {
        return view('finance.incoming_transactions.show', compact('incomingTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingTransaction $incomingTransaction)
    {
        abort(403, 'Transaksi masuk tidak dapat diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomingTransaction $incomingTransaction)
    {
        abort(403, 'Transaksi masuk tidak dapat diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingTransaction $incomingTransaction)
    {
        abort(403, 'Transaksi masuk tidak dapat dihapus.');
    }
}
