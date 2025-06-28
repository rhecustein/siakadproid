@extends('layouts.app')

@section('title', 'Rekap Bulanan Keuangan')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Rekap Bulanan Keuangan</h1>

    {{-- Filter Bulan & Tahun --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-lg">
        <div>
            <label for="month" class="text-sm font-medium text-gray-700">Bulan</label>
            <select name="month" id="month" class="w-full border rounded px-3 py-2">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="year" class="text-sm font-medium text-gray-700">Tahun</label>
            <input type="number" name="year" id="year" value="{{ $year }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tampilkan
            </button>
        </div>
    </form>

    {{-- 1. Pemasukan --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">📥 Total Pemasukan</h2>
        <div class="bg-white p-4 shadow rounded">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Wallet</th><th>Metode</th><th class="text-right">Total</th></tr></thead>
                <tbody class="divide-y">
                    @foreach($incoming as $item)
                        <tr>
                            <td>{{ $item->wallet->name ?? '-' }}</td>
                            <td>{{ ucfirst($item->method) }}</td>
                            <td class="text-right">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 2. Pengeluaran --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">📤 Total Pengeluaran</h2>
        <div class="bg-white p-4 shadow rounded">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Wallet</th><th>Metode</th><th class="text-right">Total</th></tr></thead>
                <tbody class="divide-y">
                    @foreach($outgoing as $item)
                        <tr>
                            <td>{{ $item->wallet->name ?? '-' }}</td>
                            <td>{{ ucfirst($item->method) }}</td>
                            <td class="text-right">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. Transfer Antar Wallet --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">🔁 Transfer Antar Wallet</h2>
        <div class="bg-white p-4 shadow rounded">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Dari</th><th>Ke</th><th class="text-right">Jumlah</th></tr></thead>
                <tbody class="divide-y">
                    @foreach($transfers as $t)
                        <tr>
                            <td>{{ $t->fromWallet->name ?? '-' }}</td>
                            <td>{{ $t->toWallet->name ?? '-' }}</td>
                            <td class="text-right">Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. Mutasi & Saldo Wallet --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">💰 Saldo Wallet</h2>
        <div class="bg-white p-4 shadow rounded">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th>Wallet</th>
                        <th class="text-right">Saldo Awal</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Kredit</th>
                        <th class="text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($walletRecap as $row)
                        <tr>
                            <td>{{ $row['wallet']->name }}</td>
                            <td class="text-right">Rp{{ number_format($row['saldo_awal'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($row['debit'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($row['kredit'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($row['saldo_akhir'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. Ringkasan Jurnal --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">📘 Ringkasan Jurnal</h2>
        <div class="bg-white p-4 shadow rounded">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Kredit</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($journals as $j)
                        <tr>
                            <td>{{ $j->account_code }}</td>
                            <td>{{ $j->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($j->total_debit, 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($j->total_credit, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
