@extends('layouts.app')

@section('title', 'Riwayat Wallet Logs')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Riwayat Wallet Logs</h1>
        <p class="text-gray-600">Daftar semua transaksi yang terjadi pada wallet.</p>
    </div>

    {{-- Filter Form --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <select name="wallet_id" class="border rounded px-3 py-2">
            <option value="">Semua Wallet</option>
            @foreach ($wallets as $wallet)
                <option value="{{ $wallet->id }}" {{ request('wallet_id') == $wallet->id ? 'selected' : '' }}>
                    {{ $wallet->name }}
                </option>
            @endforeach
        </select>

        <select name="type" class="border rounded px-3 py-2">
            <option value="">Semua Jenis</option>
            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Kredit</option>
            <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
        </select>

        <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-3 py-2" placeholder="Dari Tanggal">
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-3 py-2" placeholder="Sampai Tanggal">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 col-span-1 md:col-span-4">
            Filter
        </button>
    </form>

    {{-- Logs Table --}}
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Wallet</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-right">Jumlah</th>
                    <th class="px-4 py-2 text-right">Saldo Setelah</th>
                    <th class="px-4 py-2 text-left">Sumber</th>
                    <th class="px-4 py-2 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-4 py-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $log->wallet->name ?? '-' }}</td>
                        <td class="px-4 py-2 capitalize text-{{ $log->type === 'credit' ? 'green' : 'red' }}-600">
                            {{ $log->type }}
                        </td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($log->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($log->balance_after, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ class_basename($log->source_type) ?? '-' }} #{{ $log->source_id }}</td>
                        <td class="px-4 py-2">{{ $log->note }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                            Tidak ada data log transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
