<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WalletTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = WalletTransfer::with(['fromWallet', 'toWallet'])->latest()->paginate(20);
        return view('finance.wallet_transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wallets = Wallet::all();
        return view('finance.wallet_transfers.create', compact('wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'from_wallet_id' => 'required|exists:wallets,id|different:to_wallet_id',
            'to_wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:100',
            'note' => 'nullable|string|max:255',
        ]);

        $fromWallet = Wallet::findOrFail($data['from_wallet_id']);
        $toWallet = Wallet::findOrFail($data['to_wallet_id']);

        if ($fromWallet->balance < $data['amount']) {
            throw ValidationException::withMessages(['amount' => 'Saldo wallet tidak mencukupi.']);
        }

        DB::transaction(function () use ($fromWallet, $toWallet, $data) {
            // Kurangi saldo wallet pengirim
            $fromWallet->balance -= $data['amount'];
            $fromWallet->save();

            // Tambahkan saldo wallet penerima
            $toWallet->balance += $data['amount'];
            $toWallet->save();

            // Catat transaksi transfer
            WalletTransfer::create([
                'from_wallet_id' => $fromWallet->id,
                'to_wallet_id' => $toWallet->id,
                'amount' => $data['amount'],
                'note' => $data['note'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('wallet-transfers.index')->with('success', 'Transfer berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WalletTransfer $walletTransfer)
    {
        return view('finance.wallet_transfers.show', compact('walletTransfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WalletTransfer $walletTransfer)
    {
        // Biasanya transfer tidak boleh diedit untuk menjaga integritas keuangan.
        abort(403, 'Transaksi tidak dapat diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WalletTransfer $walletTransfer)
    {
        // Diblokir untuk mencegah manipulasi transaksi.
        abort(403, 'Transaksi tidak dapat diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletTransfer $walletTransfer)
    {
        // Disarankan transaksi tidak dapat dihapus.
        abort(403, 'Transaksi tidak dapat dihapus.');
    }
}
