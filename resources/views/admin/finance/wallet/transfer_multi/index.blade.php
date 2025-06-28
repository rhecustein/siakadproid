@extends('layouts.app')

@section('content')
<div class="p-4">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('finance.wallets.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar Wallet
        </a>
        <a href="{{ route('finance.wallet.transfer.multi.create', $wallet->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Tambah Transfer
        </a>
    </div>

    <h1 class="text-xl font-bold mb-4 text-gray-800">Riwayat Transfer Multi-Tujuan</h1>

    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-6 gap-4 text-sm">
        <input type="text" name="owner" placeholder="Nama Pengirim" value="{{ request('owner') }}"
               class="border p-2 rounded col-span-2" />
        <select name="type" class="border p-2 rounded">
            <option value="">Semua Jenis</option>
            <option value="tagihan" {{ request('type') == 'tagihan' ? 'selected' : '' }}>Tagihan</option>
            <option value="saldo_anak" {{ request('type') == 'saldo_anak' ? 'selected' : '' }}>Saldo Anak</option>
            <option value="donasi" {{ request('type') == 'donasi' ? 'selected' : '' }}>Donasi</option>
        </select>
        <input type="date" name="start_date" class="border p-2 rounded" value="{{ request('start_date') }}">
        <input type="date" name="end_date" class="border p-2 rounded" value="{{ request('end_date') }}">
        <input type="number" name="min" class="border p-2 rounded" placeholder="Min (Rp)" value="{{ request('min') }}">
        <input type="number" name="max" class="border p-2 rounded" placeholder="Max (Rp)" value="{{ request('max') }}">
        <div class="col-span-2 md:col-span-1">
            <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">Filter</button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Pengirim</th>
                    <th class="p-2">Jenis</th>
                    <th class="p-2">Tujuan</th>
                    <th class="p-2 text-right">Jumlah</th>
                    <th class="p-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $tx)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-2">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-2">{{ $tx->wallet->owner->name ?? '-' }}</td>
                    <td class="p-2">
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium
                            {{ match($tx->transfer_type) {
                                'tagihan' => 'bg-yellow-100 text-yellow-800',
                                'saldo_anak' => 'bg-blue-100 text-blue-800',
                                'donasi' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            } }}">
                            {{ ucfirst(str_replace('_', ' ', $tx->transfer_type)) }}
                        </span>
                    </td>
                    <td class="p-2">
                        @if ($tx->target)
                            {{ method_exists($tx->target, 'name') ? $tx->target->name : class_basename($tx->target) . ' #' . $tx->target->id }}
                        @else
                            <span class="italic text-gray-400">Tidak ditemukan</span>
                        @endif
                    </td>
                    <td class="p-2 text-right font-semibold">Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                    <td class="p-2">{{ $tx->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Tidak ada data.</td>
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
