<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use App\Models\WalletTransfer;
use App\Models\WalletLog;
use App\Models\Wallet;
use App\Models\JournalEntryLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyRecapController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari request atau default bulan ini
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $end = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // 1. Pemasukan
        $incoming = IncomingTransaction::select('wallet_id', 'method', DB::raw('SUM(amount) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('wallet_id', 'method')
            ->with('wallet')
            ->get();

        // 2. Pengeluaran
        $outgoing = OutgoingTransaction::select('wallet_id', 'method', DB::raw('SUM(amount) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('wallet_id', 'method')
            ->with('wallet')
            ->get();

        // 3. Transfer antar wallet
        $transfers = WalletTransfer::select('from_wallet_id', 'to_wallet_id', DB::raw('SUM(amount) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('from_wallet_id', 'to_wallet_id')
            ->with('fromWallet', 'toWallet')
            ->get();

        // 4. Saldo awal dan akhir per wallet
        $wallets = Wallet::all();
        $walletLogs = WalletLog::whereBetween('created_at', [$start, $end])->get()->groupBy('wallet_id');

        $walletRecap = $wallets->map(function ($wallet) use ($walletLogs, $start) {
            $logs = $walletLogs[$wallet->id] ?? collect();
            $debit = $logs->where('type', 'credit')->sum('amount');
            $credit = $logs->where('type', 'debit')->sum('amount');

            // Saldo awal = saldo - mutasi bulan ini
            $balanceNow = $wallet->balance;
            $balanceStart = $balanceNow + $credit - $debit;

            return [
                'wallet' => $wallet,
                'saldo_awal' => $balanceStart,
                'debit' => $debit,
                'kredit' => $credit,
                'saldo_akhir' => $balanceNow,
            ];
        });

        // 5. Jurnal
        $journals = JournalEntryLine::select('account_code', 'account_name',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('account_code', 'account_name')
            ->get();

        return view('finance.monthly_recap.index', compact(
            'month', 'year', 'incoming', 'outgoing', 'transfers', 'walletRecap', 'journals'
        ));
    }
}
