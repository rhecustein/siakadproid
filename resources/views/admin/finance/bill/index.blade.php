@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-2">
    <h1 class="text-2xl font-bold text-gray-800">Tagihan Siswa</h1>
    <div class="flex gap-2">
        <a href="{{ route('finance.bills.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Buat Tagihan
        </a>
        <a href="{{ route('finance.bill-generates.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            📦 Generate Tagihan Masal
        </a>
    </div>
</div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4 text-sm">
        <select name="student_id" class="border rounded px-3 py-2 w-full">
            <option value="">Semua Siswa</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
            @endforeach
        </select>

        <select name="bill_group_id" class="border rounded px-3 py-2 w-full">
            <option value="">Semua Grup Tagihan</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ request('bill_group_id') == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>

        <div class="col-span-2 md:col-span-1">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 w-full">
                Filter
            </button>
        </div>
    </form>

    {{-- Tabel Tagihan --}}
    <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left text-gray-700">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Nama Siswa</th>
                <th class="p-3">Tagihan</th>
                <th class="p-3">Grup Tagihan</th>
                <th class="p-3">Progress Pembayaran</th>
                <th class="p-3">Pembayaran Terakhir</th>
                <th class="p-3">Total Tagihan</th>
                <th class="p-3">Sisa Tagihan</th>
                <th class="p-3">Status</th>
                <th class="p-3">Dibuat</th>
                <th class="p-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
                @php
                    $items = $bill->items ?? collect();
                    $totalItems = $items->count();
                    $paidItems = $items->where('status', 'paid')->count();
                    $lastPaymentDate = $items->whereNotNull('paid_at')->sortByDesc('paid_at')->first()?->paid_at;
                    $paidAmount = $items->where('status', 'paid')->sum('amount');
                    $remaining = $bill->total_amount - $paidAmount;
                @endphp
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($bills->currentPage() - 1) * $bills->perPage() }}</td>
                    <td class="p-3 text-gray-800 font-medium">{{ $bill->student->name ?? '-' }}</td>
                    <td class="p-3 text-gray-700">{{ $bill->title ?? '-' }}</td>
                    <td class="p-3 text-gray-700">{{ $bill->bill_group->name ?? '-' }}</td>
                    <td class="p-3 text-gray-700">
                        {{ $paidItems }} / {{ $totalItems }}
                    </td>
                    <td class="p-3 text-gray-600">
                        {{ $lastPaymentDate ? \Carbon\Carbon::parse($lastPaymentDate)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-3 text-right text-gray-700">
                        Rp {{ number_format($bill->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="p-3 text-right text-gray-700">
                        Rp {{ number_format($remaining, 0, ',', '.') }}
                    </td>
                    <td class="p-3">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-700' :
                               ($bill->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-600">
                        {{ $bill->created_at->format('d M Y') }}
                    </td>
                    <td class="p-3 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('finance.bills.show', $bill->id) }}"
                               class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                👁️ Lihat
                            </a>
                            <!-- <form action="{{ route('finance.bills.destroy', $bill->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus tagihan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                    🗑️ Hapus
                                </button>
                            </form> -->
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada tagihan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


    <div class="mt-4">
        {{ $bills->withQueryString()->links() }}
    </div>
</div>
@endsection
