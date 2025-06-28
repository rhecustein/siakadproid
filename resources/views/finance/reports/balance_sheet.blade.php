@extends('layouts.app')

@section('title', 'Laporan Neraca')

@section('content')
<div class="container mx-auto px-4 max-w-5xl">
    <h1 class="text-2xl font-bold mb-2">📊 Laporan Neraca</h1>
    <p class="text-sm text-gray-600 mb-6">
        Periode: {{ \Carbon\Carbon::parse($date)->translatedFormat('F Y') }}
    </p>

    {{-- ASET --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Aktiva (Aset)</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Akun</th><th class="text-right">Saldo</th></tr></thead>
                <tbody class="divide-y">
                    @php $totalAssets = 0; @endphp
                    @forelse($assets as $item)
                        <tr>
                            <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($item->saldo, 0, ',', '.') }}</td>
                        </tr>
                        @php $totalAssets += $item->saldo; @endphp
                    @empty
                        <tr><td colspan="2" class="text-center text-gray-500 py-2">Tidak ada data.</td></tr>
                    @endforelse
                    <tr class="bg-gray-100 font-semibold">
                        <td>Total Aset</td>
                        <td class="text-right">Rp{{ number_format($totalAssets, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- KEWAJIBAN --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Pasiva (Kewajiban)</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Akun</th><th class="text-right">Saldo</th></tr></thead>
                <tbody class="divide-y">
                    @php $totalLiabilities = 0; @endphp
                    @forelse($liabilities as $item)
                        <tr>
                            <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($item->saldo, 0, ',', '.') }}</td>
                        </tr>
                        @php $totalLiabilities += $item->saldo; @endphp
                    @empty
                        <tr><td colspan="2" class="text-center text-gray-500 py-2">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Pasiva (Modal)</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Akun</th><th class="text-right">Saldo</th></tr></thead>
                <tbody class="divide-y">
                    @php $totalEquity = 0; @endphp
                    @forelse($equity as $item)
                        <tr>
                            <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($item->saldo, 0, ',', '.') }}</td>
                        </tr>
                        @php $totalEquity += $item->saldo; @endphp
                    @empty
                        <tr><td colspan="2" class="text-center text-gray-500 py-2">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOTAL PASIVA --}}
    <div class="mb-8">
        <div class="bg-gray-100 p-4 rounded text-sm font-semibold">
            <div class="flex justify-between">
                <span>Total Pasiva (Kewajiban + Modal)</span>
                <span>Rp{{ number_format($totalLiabilities + $totalEquity, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Validasi keseimbangan --}}
    <div class="mt-4">
        @if ($totalAssets == ($totalLiabilities + $totalEquity))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">✅ Neraca Seimbang</div>
        @else
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded">⚠️ Neraca Tidak Seimbang</div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('finance.financial-reports.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke menu laporan
        </a>
    </div>
</div>
@endsection
