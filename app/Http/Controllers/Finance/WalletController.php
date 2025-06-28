<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\WalletTransfer;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $query = Wallet::with('owner');

        $totalBalance = DB::table('wallets')->sum('balance');
        $totalTodayTransactions = WalletTransaction::whereDate('created_at', today())->sum('amount');
        $totalPending = WalletTransaction::where('status', 'pending')->sum('amount');
        $totalActiveWallet = DB::table('wallets')->where('status', 'active')->count();

        $query->where(function ($query) {
            $query->where(function ($q) {
                $q->where('owner_type', Student::class)
                    ->whereHasMorph('owner', [Student::class], fn($q2) =>
                        $q2->whereHas('user', fn($u) => $u->where('role_id', 9))
                    );
            })->orWhere(function ($q) {
                $q->where('owner_type', ParentModel::class)
                    ->whereHasMorph('owner', [ParentModel::class], fn($q2) =>
                        $q2->whereHas('user', fn($u) => $u->where('role_id', 10))
                    );
            });
        }); 

        if ($request->filled('role')) {
            $model = match ($request->role) {
                'student' => Student::class,
                'parent' => ParentModel::class,
                default => null,
            };
            if ($model) {
                $query->where('owner_type', $model);
            }
        }

        if ($request->filled('name')) {
            $query->whereHas('owner', fn($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            );
        }

        if ($request->filled('min')) {
            $query->where('balance', '>=', $request->min);
        }

        if ($request->filled('max')) {
            $query->where('balance', '<=', $request->max);
        }

        $wallets = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('admin.finance.wallet.index', compact(
            'wallets',
            'totalBalance',
            'totalTodayTransactions',
            'totalPending',
            'totalActiveWallet'
        ));
    }

    public function transferForm(Wallet $wallet)
    {
        $receivers = Wallet::with('owner')->where('id', '!=', $wallet->id)->get();
        return view('admin.finance.wallet.transfer', compact('wallet', 'receivers'));
    }

    public function transfer(Request $request, Wallet $wallet)
    {
        $request->validate([
            'to_wallet_id' => 'required|exists:wallets,id',
            'amount'       => 'required|numeric|min:1000',
            'description'  => 'nullable|string|max:255',
        ]);

        if ($request->to_wallet_id == $wallet->id) {
            return back()->withErrors(['to_wallet_id' => 'Tidak boleh transfer ke wallet yang sama.']);
        }

        if ($wallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi.']);
        }

        $to = Wallet::findOrFail($request->to_wallet_id);

        DB::transaction(function () use ($wallet, $to, $request) {
            $wallet->decrement('balance', $request->amount);
            WalletTransaction::create([
                'wallet_id'        => $wallet->id,
                'transaction_type' => 'transfer_out',
                'amount'           => $request->amount,
                'channel'          => 'manual',
                'status'           => 'success',
                'executed_by'      => auth()->id(),
                'description'      => $request->description,
            ]);

            $to->increment('balance', $request->amount);
            WalletTransaction::create([
                'wallet_id'        => $to->id,
                'transaction_type' => 'transfer_in',
                'amount'           => $request->amount,
                'channel'          => 'manual',
                'status'           => 'success',
                'executed_by'      => auth()->id(),
                'description'      => $request->description,
            ]);

            WalletTransfer::create([
                'from_wallet_id' => $wallet->id,
                'to_wallet_id'   => $to->id,
                'amount'         => $request->amount,
                'description'    => $request->description,
                'status'         => 'completed',
            ]);
        });

        return redirect()->route('finance.wallets.index')->with('success', 'Transfer berhasil.');
    }

    public function transactions(Wallet $wallet, Request $request)
    {
        $wallet->load('owner');

        $transactions = $wallet->transactions()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
            ->latest()
            ->paginate(15);

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $stats = [
            'balance' => $wallet->balance,
            'today' => $wallet->transactions()->whereDate('created_at', $today)->sum('amount'),
            'this_week' => $wallet->transactions()->whereDate('created_at', '>=', $startOfWeek)->sum('amount'),
            'this_month' => $wallet->transactions()->whereDate('created_at', '>=', $startOfMonth)->sum('amount'),
            'total' => $wallet->transactions()->sum('amount'),
        ];

        return view('admin.finance.wallet.transactions', compact('wallet', 'transactions', 'stats'));
    }

    public function logs(Request $request)
    {
        $logs = WalletTransaction::with(['wallet.owner'])
            ->when($request->type, fn($q, $type) => $q->where('type', $type))
            ->when($request->user, fn($q, $user) =>
                $q->whereHas('wallet.owner', fn($o) =>
                    $o->where('name', 'like', '%' . $user . '%')
                )
            )
            ->latest()
            ->paginate(15);

        return view('admin.finance.wallet.logs', compact('logs'));
    }

    public function multiTransferForm(Wallet $wallet, Request $request)
    {
        $wallet->load('owner');

        $students = Student::with(['user', 'wallet'])->get();

        $donationCategories = [
            'infaq' => 'Infaq',
            'wakaf' => 'Wakaf',
            'beasiswa' => 'Beasiswa',
        ];

        $transactions = WalletTransaction::with(['wallet.owner', 'target'])
        ->whereNotNull('transfer_type')
        ->when($request->type, fn($q) => $q->where('transfer_type', $request->type))
        ->when($request->owner, fn($q, $owner) =>
            $q->whereHas('wallet.owner', fn($o) => $o->where('name', 'like', '%' . $owner . '%'))
        )
        ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
        ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
        ->when($request->min, fn($q) => $q->where('amount', '>=', $request->min))
        ->when($request->max, fn($q) => $q->where('amount', '<=', $request->max))
        ->latest()
        ->paginate(15);

        return view('admin.finance.wallet.transfer_multi.index', compact(
            'wallet',
            'students',
            'donationCategories',
            'transactions'
        ));
    }

    public function createMultiTransfer(Wallet $wallet)
    {
        $wallet->load('owner');

        $students = Student::with(['user', 'wallet'])->get();

        $donationCategories = [
            'infaq' => 'Infaq',
            'wakaf' => 'Wakaf',
            'beasiswa' => 'Beasiswa',
        ];

        return view('admin.finance.wallet.transfer_multi.create', compact(
            'wallet',
            'students',
            'donationCategories'
        ));
    }


    public function multiTransfer(Request $request, Wallet $wallet)
    {
        $request->validate([
            'destination_type' => 'required|in:tagihan,saldo_anak,donasi',
            'target_id' => 'required',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:255',
        ]);

        if ($wallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi.']);
        }

        DB::transaction(function () use ($wallet, $request) {
            $wallet->decrement('balance', $request->amount);

            WalletTransaction::create([
                'wallet_id'        => $wallet->id,
                'transaction_type' => 'transfer_out',
                'amount'           => $request->amount,
                'channel'          => 'manual',
                'status'           => 'success',
                'executed_by'      => auth()->id(),
                'description'      => $request->description,
                'transfer_type'    => $request->destination_type,
                'target_id'        => $request->target_id,
                'target_type'      => match ($request->destination_type) {
                    'tagihan' => \App\Models\Bill::class,
                    'saldo_anak' => \App\Models\Wallet::class,
                    'donasi' => \App\Models\DonationTarget::class,
                },
            ]);

            // Tambahkan logika spesifik tujuan jika dibutuhkan di masa depan
        });

        return redirect()->route('finance.wallet.transactions', $wallet->id)->with('success', 'Transfer berhasil.');
    }

}
