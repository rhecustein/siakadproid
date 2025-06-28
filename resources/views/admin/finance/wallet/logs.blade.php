@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Wallet Transaction Logs</h1>

    <form method="GET" class="mb-4 flex gap-4">
        <input name="user" type="text" placeholder="Cari pengguna..." class="border p-2 rounded w-64" value="{{ request('user') }}">
        <select name="type" class="border p-2 rounded">
            <option value="">Semua Tipe</option>
            <option value="topup" {{ request('type')=='topup' ? 'selected' : '' }}>Top-Up</option>
            <option value="payment" {{ request('type')=='payment' ? 'selected' : '' }}>Payment</option>
            <option value="transfer_in" {{ request('type')=='transfer_in' ? 'selected' : '' }}>Transfer Masuk</option>
            <option value="transfer_out" {{ request('type')=='transfer_out' ? 'selected' : '' }}>Transfer Keluar</option>
            <option value="adjust_in" {{ request('type')=='adjust_in' ? 'selected' : '' }}>Adjust +</option>
            <option value="adjust_out" {{ request('type')=='adjust_out' ? 'selected' : '' }}>Adjust -</option>
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Pengguna</th>
                    <th class="p-2 text-left">Tipe</th>
                    <th class="p-2 text-right">Jumlah</th>
                    <th class="p-2 text-left">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-t">
                    <td class="p-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-2">{{ $log->wallet->user->name ?? '-' }}</td>
                    <td class="p-2 capitalize">{{ str_replace('_', ' ', $log->type) }}</td>
                    <td class="p-2 text-right">{{ number_format($log->amount, 0, ',', '.') }}</td>
                    <td class="p-2">{{ $log->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->withQueryString()->links() }}
    </div>
</div>
@endsection
