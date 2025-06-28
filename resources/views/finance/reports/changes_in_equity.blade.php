@extends('layouts.app')

@section('title', 'Perubahan Dana / Modal')

@section('content')
<div class="container mx-auto px-4 max-w-3xl">
    <h1 class="text-2xl font-bold mb-2">📘 Laporan Perubahan Dana / Modal</h1>
    <p class="text-sm text-gray-600 mb-6">Tahun: {{ $year }}</p>

    <div class="bg-white shadow rounded p-4">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="text-left">Akun Modal</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Kredit</th>
                    <th class="text-right">Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @php $totalDebit = 0; $totalCredit = 0; @endphp
                @forelse($modalLines as $item)
                    @php
                        $change = $item->credit - $item->debit;
                        $totalDebit += $item->debit;
                        $totalCredit += $item->credit;
                    @endphp
                    <tr>
                        <td>{{ $item->account_code }} - {{ $item->account_name }}</td>
                        <td class="text-right">Rp{{ number_format($item->debit, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->credit, 0, ',', '.') }}</td>
                        <td class="text-right {{ $change >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            Rp{{ number_format($change, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-2">Tidak ada data modal ditemukan.</td>
                    </tr>
                @endforelse
                <tr class="bg-gray-100 font-semibold">
                    <td>Total</td>
                    <td class="text-right">Rp{{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($totalCredit, 0, ',', '.') }}</td>
                    <td class="text-right">
                        Rp{{ number_format($totalCredit - $totalDebit, 0, ',', '.') }}
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
