@extends('layouts.app')

@section('title', 'Tambah Transaksi Keluar')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tambah Transaksi Keluar</h1>
        <p class="text-gray-600">Form untuk mencatat pengeluaran dana dari wallet tertentu.</p>
    </div>

    <form action="{{ route('finance.outgoing-transactions.store') }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf

        {{-- Wallet Asal --}}
        <div class="mb-4">
            <label for="wallet_id" class="block text-sm font-medium text-gray-700">Wallet Sumber Dana</label>
            <select name="wallet_id" id="wallet_id" required class="w-full border rounded px-3 py-2 mt-1">
                <option value="">-- Pilih Wallet --</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                        {{ $wallet->name }} (Saldo: Rp{{ number_format($wallet->balance, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
            @error('wallet_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" name="amount" id="amount" min="100" value="{{ old('amount') }}"
                   required class="w-full border rounded px-3 py-2 mt-1">
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Metode --}}
        <div class="mb-4">
            <label for="method" class="block text-sm font-medium text-gray-700">Metode Pengeluaran</label>
            <select name="method" id="method" required class="w-full border rounded px-3 py-2 mt-1">
                <option value="">-- Pilih Metode --</option>
                <option value="tunai" {{ old('method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="operasional" {{ old('method') == 'operasional' ? 'selected' : '' }}>Operasional</option>
                <option value="pembayaran" {{ old('method') == 'pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                <option value="refund" {{ old('method') == 'refund' ? 'selected' : '' }}>Refund</option>
            </select>
            @error('method')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Penerima --}}
        <div class="mb-4">
            <label for="recipient" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
            <input type="text" name="recipient" id="recipient" value="{{ old('recipient') }}"
                   required class="w-full border rounded px-3 py-2 mt-1">
            @error('recipient')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Referensi --}}
        <div class="mb-4">
            <label for="reference_number" class="block text-sm font-medium text-gray-700">No. Referensi (Opsional)</label>
            <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}"
                   class="w-full border rounded px-3 py-2 mt-1">
            @error('reference_number')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-4">
            <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="note" id="note" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('note') }}</textarea>
            @error('note')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end mt-6">
            <a href="{{ route('finance.outgoing-transactions.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>
@endsection
