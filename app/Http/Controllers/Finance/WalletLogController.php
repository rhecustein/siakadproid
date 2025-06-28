<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;

class WalletLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WalletLog::with('wallet')
            ->when($request->wallet_id, fn($q) => $q->where('wallet_id', $request->wallet_id))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->source_type, fn($q) => $q->where('source_type', $request->source_type))
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
            });

        $logs = $query->latest()->paginate(20);

        $wallets = Wallet::all();

        return view('finance.wallet_logs.index', compact('logs', 'wallets'));
    }

    /**
     * Display the specified resource.
     */
    public function show(WalletLog $walletLog)
    {
        return view('finance.wallet_logs.show', compact('walletLog'));
    }

    // Log wallet bersifat read-only — sisanya dinonaktifkan:

    public function create()
    {
        abort(403, 'Akses dilarang.');
    }

    public function store(Request $request)
    {
        abort(403, 'Akses dilarang.');
    }

    public function edit(WalletLog $walletLog)
    {
        abort(403, 'Akses dilarang.');
    }

    public function update(Request $request, WalletLog $walletLog)
    {
        abort(403, 'Akses dilarang.');
    }

    public function destroy(WalletLog $walletLog)
    {
        abort(403, 'Akses dilarang.');
    }
}
