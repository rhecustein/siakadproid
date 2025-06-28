@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Tagihan Siswa</h1>
        <p class="text-sm text-gray-500">Informasi lengkap tagihan siswa.</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        {{-- Info Siswa & Tagihan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Data Siswa</h2>
                <p><strong>Nama:</strong> {{ $bill->student->name }}</p>
                <p><strong>NISN:</strong> {{ $bill->student->nisn ?? '-' }}</p>
                <p><strong>Kelas:</strong> {{ $bill->student->grade->label ?? '-' }}</p>
                <p><strong>Sekolah:</strong> {{ $bill->student->school->name ?? '-' }}</p>
            </div>
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Info Tagihan</h2>
                <p><strong>Judul:</strong> {{ $bill->title }}</p>
                <p><strong>Jenis:</strong> {{ \App\Models\BillGroup::TYPES[$bill->bill_type] ?? $bill->bill_type }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</p>
                <p><strong>Status:</strong>
                    <span class="inline-block px-2 py-1 rounded text-xs font-medium
                        {{ $bill->status === 'paid' ? 'bg-green-100 text-green-700' :
                           ($bill->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($bill->status) }}
                    </span>
                </p>
                @if($bill->due_date)
                    <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}</p>
                @endif
                @if($bill->notes)
                    <p><strong>Catatan:</strong> {{ $bill->notes }}</p>
                @endif
            </div>
        </div>

        {{-- Rincian Item Tagihan --}}
        <div class="mt-6">
            <h2 class="font-semibold text-gray-700 mb-2">Rincian Tagihan</h2>
            @if($bill->items && $bill->items->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm table-auto border-collapse border rounded">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">Label</th>
                                <th class="px-4 py-2 text-left">Nominal</th>
                                <th class="px-4 py-2 text-left">Jatuh Tempo</th>
                                <th class="px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($bill->items as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $item->name }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format('d M Y') : '-' }}</td>
                                    <td class="px-4 py-2 capitalize">
                                        <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                            {{ $item->status === 'paid' ? 'bg-green-100 text-green-700' :
                                               ($item->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada item tagihan.</p>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('finance.bills.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali ke daftar</a>
        </div>
    </div>
</div>
@endsection
