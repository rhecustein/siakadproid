@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Laporan Keuangan</h1>

    <form method="GET" action="{{ route('finance.financial-reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-lg mb-8">
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
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                Tampilkan
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('finance.financial-reports.balance-sheet', ['month' => $month, 'year' => $year]) }}"
           class="bg-white shadow hover:shadow-md p-4 rounded border border-gray-200">
            <h2 class="text-lg font-semibold mb-1">📊 Neraca</h2>
            <p class="text-gray-600 text-sm">Aset, kewajiban, dan modal per {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}.</p>
        </a>

        <a href="{{ route('finance.financial-reports.profit-loss', ['month' => $month, 'year' => $year]) }}"
           class="bg-white shadow hover:shadow-md p-4 rounded border border-gray-200">
            <h2 class="text-lg font-semibold mb-1">📈 Laba / Rugi</h2>
            <p class="text-gray-600 text-sm">Pendapatan dan beban bulan {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}.</p>
        </a>

        <a href="{{ route('finance.financial-reports.changes-in-equity', ['year' => $year]) }}"
           class="bg-white shadow hover:shadow-md p-4 rounded border border-gray-200">
            <h2 class="text-lg font-semibold mb-1">📘 Perubahan Dana</h2>
            <p class="text-gray-600 text-sm">Mutasi modal dan dana selama tahun {{ $year }}.</p>
        </a>

        <a href="{{ route('finance.financial-reports.cash-flow', ['month' => $month, 'year' => $year]) }}"
           class="bg-white shadow hover:shadow-md p-4 rounded border border-gray-200">
            <h2 class="text-lg font-semibold mb-1">💵 Arus Kas</h2>
            <p class="text-gray-600 text-sm">Arus kas masuk dan keluar bulan {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}.</p>
        </a>
    </div>
</div>
@endsection
