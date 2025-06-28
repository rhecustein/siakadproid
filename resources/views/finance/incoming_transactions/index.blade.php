@extends('layouts.app')

@section('title', 'Transaksi Masuk')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Transaksi Masuk</h1>
        <a href="{{ route('finance.incoming-transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Transaksi
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <select name="wallet_id" class="border rounded px-3 py-2">
            <option value="">Semua Wallet</option>
            @foreach ($wallets as $wallet)
                <option value="{{ $wallet->id }}" {{ request('wallet_id') == $wallet->id ? 'selected' : '' }}>
                    {{ $wallet->owner->name ?? '-' }} ({{ $wallet->uuid }})
                </option>
            @endforeach
        </select>

        <select name="method" class="border rounded px-3 py-2">
            <option value="">Semua Metode</option>
            <option value="tunai" {{ request('method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
            <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="topup" {{ request('method') == 'topup' ? 'selected' : '' }}>Top-up</option>
            <option value="donasi" {{ request('method') == 'donasi' ? 'selected' : '' }}>Donasi</option>
        </select>

        <select name="status" class="border rounded px-3 py-2">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Filter
        </button>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Wallet</th>
                    <th class="px-4 py-2 text-left">Metode</th>
                    <th class="px-4 py-2 text-left">Referensi</th>
                    <th class="px-4 py-2 text-right">Jumlah</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($transactions as $tx)
                    <tr>
                        <td class="px-4 py-2">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $tx->wallet->name ?? '-' }}</td>
                        <td class="px-4 py-2 capitalize">{{ $tx->method }}</td>
                        <td class="px-4 py-2">{{ $tx->reference_number ?? '-' }}</td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($tx->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 capitalize text-{{ $tx->status === 'confirmed' ? 'green' : ($tx->status === 'failed' ? 'red' : 'yellow') }}-600">
                            {{ $tx->status }}
                        </td>
                        <td class="px-4 py-2">{{ $tx->note }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data transaksi masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endsection
