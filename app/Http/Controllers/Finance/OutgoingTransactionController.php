<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\OutgoingTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OutgoingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wallets = Wallet::all();
        $transactions = OutgoingTransaction::with(['wallet', 'issuer'])
            ->when($request->wallet_id, fn($q) => $q->where('wallet_id', $request->wallet_id))
            ->when($request->method, fn($q) => $q->where('method', $request->method))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('finance.outgoing_transactions.index', compact('transactions', 'wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wallets = Wallet::all();
        return view('finance.outgoing_transactions.create', compact('wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:100',
            'method' => 'required|string|max:50',
            'recipient' => 'required|string|max:100',
            'reference_number' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::findOrFail($data['wallet_id']);
        if ($wallet->balance < $data['amount']) {
            throw ValidationException::withMessages(['amount' => 'Saldo wallet tidak mencukupi.']);
        }

        $data['issued_by'] = auth()->id();
        $data['status'] = 'confirmed';

        DB::transaction(function () use ($wallet, $data) {
            // Kurangi saldo wallet
            $wallet->balance -= $data['amount'];
            $wallet->save();

            // Buat transaksi keluar
            $transaction = OutgoingTransaction::create($data);

            // Catat ke wallet_logs
            $wallet->logs()->create([
                'type' => 'debit',
                'amount' => $data['amount'],
                'balance_after' => $wallet->balance,
                'note' => $data['note'] ?? 'Transaksi Keluar (' . $data['method'] . ')',
                'source_type' => OutgoingTransaction::class,
                'source_id' => $transaction->id,
                'created_by' => $data['issued_by'],
            ]);
        });

        return redirect()->route('outgoing-transactions.index')->with('success', 'Transaksi keluar berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingTransaction $outgoingTransaction)
    {
        return view('finance.outgoing_transactions.show', compact('outgoingTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingTransaction $outgoingTransaction)
    {
        abort(403, 'Transaksi keluar tidak dapat diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingTransaction $outgoingTransaction)
    {
        abort(403, 'Transaksi keluar tidak dapat diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingTransaction $outgoingTransaction)
    {
        abort(403, 'Transaksi keluar tidak dapat dihapus.');
    }
}
