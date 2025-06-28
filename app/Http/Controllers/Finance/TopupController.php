<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class TopupController extends Controller
{
    public function index(Request $request)
    {
        $topups = WalletTransaction::with(['wallet.owner'])
            ->where('transaction_type', 'topup')
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('channel'), fn($q) => $q->where('channel', $request->channel))
            ->when($request->filled('name'), function ($q) use ($request) {
                $q->whereHas('wallet.owner', fn($x) => $x->where('name', 'like', '%' . $request->name . '%'));
            })
            ->latest('created_at')
            ->paginate(20);

        return view('admin.finance.topup.index', compact('topups'));
    }

    public function create()
    {
        $wallets = Wallet::with('owner')->orderBy('id', 'desc')->get();
        return view('admin.finance.topup.create', compact('wallets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id'   => 'required|exists:wallets,id',
            'amount'      => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:255',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $wallet = Wallet::findOrFail($validated['wallet_id']);

        // Upload file (jika ada)
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('topup-receipts', 'public');
        }

        // Tambah saldo
        $wallet->increment('balance', $validated['amount']);

        // Simpan transaksi
        WalletTransaction::create([
            'wallet_id'        => $wallet->id,
            'transaction_type' => 'topup',
            'amount'           => $validated['amount'],
            'channel'          => 'manual',
            'status'           => 'success',
            'executed_by'      => auth()->id(),
            'description'      => $validated['description'],
            'meta'             => $receiptPath ? ['receipt_path' => $receiptPath] : null,
        ]);

        return redirect()->route('finance.topups.index')->with('success', 'Top-up berhasil disimpan.');
    }
}
