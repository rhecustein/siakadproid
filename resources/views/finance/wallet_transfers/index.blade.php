@extends('layouts.app')

@section('title', 'Riwayat Transfer Wallet')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Riwayat Transfer Wallet</h1>
        <a href="{{ route('finance.wallet-transfers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Transfer Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Dari Wallet</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Ke Wallet</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Jumlah</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($transfers as $transfer)
                    <tr>
                        <td class="px-4 py-2">{{ $transfer->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $transfer->fromWallet->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $transfer->toWallet->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-right">Rp{{ number_format($transfer->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $transfer->note }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Tidak ada data transfer.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transfers->links() }}
    </div>
</div>
@endsection
