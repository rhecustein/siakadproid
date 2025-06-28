@extends('layouts.app')

@section('title', 'Laporan Arus Kas')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <h1 class="text-2xl font-bold mb-2">💵 Laporan Arus Kas</h1>
    <p class="text-sm text-gray-600 mb-6">
        Periode: {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
    </p>

    @php
        $totalIn = 0;
        $totalOut = 0;
    @endphp

    <div class="bg-white shadow rounded p-4">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead>
                <tr>
                    <th>Wallet</th>
                    <th class="text-right">Masuk (Debit)</th>
                    <th class="text-right">Keluar (Kredit)</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($cashLogs as $wallet => $types)
                    @php
                        $debit = $types->where('type', 'credit')->sum('total');  // uang masuk
                        $credit = $types->where('type', 'debit')->sum('total');  // uang keluar
                        $totalIn += $debit;
                        $totalOut += $credit;
                    @endphp
                    <tr>
                        <td>{{ $wallet }}</td>
                        <td class="text-right text-green-600">Rp{{ number_format($debit, 0, ',', '.') }}</td>
                        <td class="text-right text-red-600">Rp{{ number_format($credit, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-gray-500 py-2">Tidak ada data arus kas.</td></tr>
                @endforelse
                <tr class="bg-gray-100 font-semibold">
                    <td>Total Arus Kas</td>
                    <td class="text-right">Rp{{ number_format($totalIn, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($totalOut, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-100 font-semibold">
                    <td>Selisih</td>
                    <td colspan="2" class="text-right">
                        Rp{{ number_format($totalIn - $totalOut, 0, ',', '.') }}
                        @if($totalIn - $totalOut >= 0)
                            <span class="text-green-600"> (Surplus)</span>
                        @else
                            <span class="text-red-600"> (Defisit)</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('finance.financial-reports.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke menu laporan
        </a>
    </div>
</div>
@endsection
