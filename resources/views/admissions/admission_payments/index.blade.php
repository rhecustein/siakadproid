@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pembayaran Formulir</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama Pendaftar</th>
                    <th class="px-4 py-2 text-left">Metode</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $payment->admission->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $payment->method }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $payment->payment_date }}</td>
                        <td class="px-4 py-2">
                            @if($payment->proof)
                                <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="text-blue-600 underline text-sm">Lihat</a>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
