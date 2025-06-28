<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JournalEntryLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * Tampilkan halaman utama laporan keuangan.
     */
    public function index(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        return view('finance.reports.index', compact('month', 'year'));
    }

    /**
     * Neraca: Aset = Kewajiban + Modal
     */
    public function balanceSheet(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));
        $date = Carbon::create($year, $month, 1)->endOfMonth();

        $data = JournalEntryLine::select(
                'account_code',
                'account_name',
                DB::raw('SUM(debit - credit) as saldo')
            )
            ->where('created_at', '<=', $date)
            ->groupBy('account_code', 'account_name')
            ->orderBy('account_code')
            ->get();

        $assets = $data->filter(fn($a) => str_starts_with($a->account_code, '1'));
        $liabilities = $data->filter(fn($a) => str_starts_with($a->account_code, '2'));
        $equity = $data->filter(fn($a) => str_starts_with($a->account_code, '3'));

        return view('finance.reports.balance_sheet', compact('assets', 'liabilities', 'equity', 'date'));
    }

    /**
     * Laba Rugi: Pendapatan - Beban
     */
    public function profitLoss(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        $data = JournalEntryLine::select(
                'account_code',
                'account_name',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('account_code', 'account_name')
            ->orderBy('account_code')
            ->get();

        $revenue = $data->filter(fn($a) => str_starts_with($a->account_code, '4'));
        $expense = $data->filter(fn($a) => str_starts_with($a->account_code, '5'));

        return view('finance.reports.profit_loss', compact('revenue', 'expense', 'month', 'year'));
    }

    /**
     * Perubahan Dana / Modal
     */
    public function changesInEquity(Request $request)
    {
        $year = (int) $request->get('year', date('Y'));
        $start = Carbon::create($year, 1, 1)->startOfYear();
        $end = Carbon::create($year, 12, 31)->endOfYear();

        $modalLines = JournalEntryLine::select(
                'account_code',
                'account_name',
                DB::raw('SUM(debit) as debit'),
                DB::raw('SUM(credit) as credit')
            )
            ->where('account_code', 'like', '3%')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('account_code', 'account_name')
            ->orderBy('account_code')
            ->get();

        return view('finance.reports.changes_in_equity', compact('modalLines', 'year'));
    }

    /**
     * Arus Kas: per wallet dan tipe transaksi.
     */
    public function cashFlow(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        $cashLogs = DB::table('wallet_logs')
            ->join('wallets', 'wallet_logs.wallet_id', '=', 'wallets.id')
            ->select('wallets.name as wallet_name', 'wallet_logs.type', DB::raw('SUM(wallet_logs.amount) as total'))
            ->whereBetween('wallet_logs.created_at', [$start, $end])
            ->groupBy('wallets.name', 'wallet_logs.type')
            ->get()
            ->groupBy('wallet_name');

        return view('finance.reports.cash_flow', compact('cashLogs', 'month', 'year'));
    }
}
