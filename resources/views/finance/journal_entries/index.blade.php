@extends('layouts.app')

@section('title', 'Jurnal Umum')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Jurnal Umum</h1>
        <a href="{{ route('finance.journal-entries.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Jurnal
        </a>
    </div>

    {{-- Filter Tanggal (opsional) --}}
    <form method="GET" class="mb-6 max-w-sm">
        <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2 w-full">
    </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                    <th class="px-4 py-2 text-right">Total Debit</th>
                    <th class="px-4 py-2 text-right">Total Kredit</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($journals as $journal)
                    <tr>
                        <td class="px-4 py-2">{{ $journal->date->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ Str::limit($journal->description, 50) }}</td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($journal->totalDebit(), 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($journal->totalCredit(), 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('finance.journal-entries.show', $journal) }}" class="text-blue-600 hover:underline">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Belum ada jurnal dicatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $journals->appends(request()->query())->links() }}
    </div>
</div>
@endsection
