@extends('layouts.app')

@section('title', 'Detail Jurnal')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-1">Detail Jurnal</h1>
        <p class="text-sm text-gray-600">Jurnal #{{ $journalEntry->id }} — Tanggal: {{ $journalEntry->date->format('d/m/Y') }}</p>
    </div>

    <div class="mb-6 bg-white shadow rounded p-4">
        <p class="mb-2"><strong>Deskripsi:</strong></p>
        <p class="text-gray-700">{{ $journalEntry->description }}</p>

        @if($journalEntry->reference_type)
            <p class="mt-4 text-sm text-gray-600 italic">
                Sumber: {{ class_basename($journalEntry->reference_type) }} #{{ $journalEntry->reference_id }}
            </p>
        @endif
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Kode Akun</th>
                    <th class="px-4 py-2 text-left">Nama Akun</th>
                    <th class="px-4 py-2 text-right">Debit</th>
                    <th class="px-4 py-2 text-right">Kredit</th>
                    <th class="px-4 py-2 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($journalEntry->lines as $line)
                    <tr>
                        <td class="px-4 py-2">{{ $line->account_code }}</td>
                        <td class="px-4 py-2">{{ $line->account_name }}</td>
                        <td class="px-4 py-2 text-right">
                            @if($line->debit > 0) Rp{{ number_format($line->debit, 0, ',', '.') }} @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            @if($line->credit > 0) Rp{{ number_format($line->credit, 0, ',', '.') }} @endif
                        </td>
                        <td class="px-4 py-2">{{ $line->note }}</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-100 font-semibold">
                    <td colspan="2" class="px-4 py-2 text-right">Total</td>
                    <td class="px-4 py-2 text-right text-green-700">
                        Rp{{ number_format($journalEntry->totalDebit(), 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 text-right text-red-700">
                        Rp{{ number_format($journalEntry->totalCredit(), 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('journal-entries.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke daftar jurnal
        </a>
    </div>
</div>
@endsection
