@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold text-gray-800 mb-2">
        Riwayat Transaksi Wallet
    </h1>
    <a href="{{ route('finance.wallets.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:underline mb-4">
    ← Kembali ke Daftar Wallet
</a>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white shadow rounded p-4">
        <p class="text-sm text-gray-500">Saldo Saat Ini</p>
        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
        <p class="text-lg font-semibold">Rp {{ number_format($stats['today'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <p class="text-sm text-gray-500">Transaksi Minggu Ini</p>
        <p class="text-lg font-semibold">Rp {{ number_format($stats['this_week'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <p class="text-sm text-gray-500">Transaksi Bulan Ini</p>
        <p class="text-lg font-semibold">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-gray-50 rounded border border-gray-200 mb-6 p-4">
    <p class="text-sm text-gray-600">Total Semua Transaksi: 
        <span class="font-bold text-gray-800">Rp {{ number_format($stats['total'], 0, ',', '.') }}</span>
    </p>
</div>
    <p class="text-gray-600 mb-4">
        Pemilik: <strong>{{ $wallet->owner->name ?? 'Tidak Diketahui' }}</strong>
        @if($wallet->owner && $wallet->owner->user)
            <span class="text-sm text-gray-500">({{ $wallet->owner->user->email }})</span>
        @endif
    </p>

    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipe Transaksi</label>
            <select name="type" class="border p-2 rounded w-full">
                <option value="">Semua</option>
                @foreach(['topup', 'payment', 'transfer_in', 'transfer_out', 'adjust_in', 'adjust_out'] as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Awal</label>
            <input type="date" name="start_date" class="border p-2 rounded w-full" value="{{ request('start_date') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
            <input type="date" name="end_date" class="border p-2 rounded w-full" value="{{ request('end_date') }}">
        </div>
        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('finance.wallet.transactions', $wallet->id) }}"
               class="px-4 py-2 border border-gray-300 rounded text-gray-600 hover:bg-gray-100">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Tipe</th>
                    <th class="p-2 text-right">Jumlah</th>
                    <th class="p-2 text-left">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-2">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-2">
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium
                            {{ match($tx->type) {
                                'topup' => 'bg-green-100 text-green-800',
                                'payment' => 'bg-red-100 text-red-800',
                                'transfer_in' => 'bg-blue-100 text-blue-800',
                                'transfer_out' => 'bg-yellow-100 text-yellow-800',
                                'adjust_in' => 'bg-green-50 text-green-700',
                                'adjust_out' => 'bg-red-50 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            } }}">
                            {{ ucfirst(str_replace('_', ' ', $tx->type)) }}
                        </span>
                    </td>
                    <td class="p-2 text-right font-semibold">
                        {{ number_format($tx->amount, 0, ',', '.') }}
                    </td>
                    <td class="p-2">{{ $tx->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->withQueryString()->links() }}
    </div>
</div>
@endsection
