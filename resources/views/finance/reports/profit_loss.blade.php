@extends('layouts.app')

@section('title', 'Laporan Laba/Rugi')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <h1 class="text-2xl font-bold mb-2">📈 Laporan Laba / Rugi</h1>
    <p class="text-sm text-gray-600 mb-6">
        Periode: {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
    </p>

    {{-- PENDAPATAN --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Pendapatan</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Akun</th><th class="text-right">Jumlah</th></tr></thead>
                <tbody class="divide-y">
                    @php $totalRevenue = 0; @endphp
                    @forelse($revenue as $item)
                        @php $value = $item->total_credit - $item->total_debit; @endphp
                        <tr>
                            <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($value, 0, ',', '.') }}</td>
                        </tr>
                        @php $totalRevenue += $value; @endphp
                    @empty
                        <tr><td colspan="2" class="text-center text-gray-500 py-2">Tidak ada data.</td></tr>
                    @endforelse
                    <tr class="bg-gray-100 font-semibold">
                        <td>Total Pendapatan</td>
                        <td class="text-right">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- BEBAN --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Beban</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead><tr><th>Akun</th><th class="text-right">Jumlah</th></tr></thead>
                <tbody class="divide-y">
                    @php $totalExpense = 0; @endphp
                    @forelse($expense as $item)
                        @php $value = $item->total_debit - $item->total_credit; @endphp
                        <tr>
                            <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                            <td class="text-right">Rp{{ number_format($value, 0, ',', '.') }}</td>
                        </tr>
                        @php $totalExpense += $value; @endphp
                    @empty
                        <tr><td colspan="2" class="text-center text-gray-500 py-2">Tidak ada data.</td></tr>
                    @endforelse
                    <tr class="bg-gray-100 font-semibold">
                        <td>Total Beban</td>
                        <td class="text-right">Rp{{ number_format($totalExpense, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- LABA / RUGI --}}
    <div class="bg-gray-100 p-4 rounded font-semibold text-sm mb-6">
        <div class="flex justify-between">
            <span>Hasil Laba / Rugi</span>
            <span>
                Rp{{ number_format($totalRevenue - $totalExpense, 0, ',', '.') }}
                @if($totalRevenue - $totalExpense >= 0)
                    <span class="text-green-600"> (Laba)</span>
                @else
                    <span class="text-red-600"> (Rugi)</span>
                @endif
            </span>
        </div>
    </div>

    <div>
        <a href="{{ route('finance.financial-reports.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke menu laporan
        </a>
    </div>
</div>
@endsection
