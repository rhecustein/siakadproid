@extends('layouts.app')

@section('title', 'Tambah Transaksi Masuk')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tambah Transaksi Masuk</h1>
        <p class="text-gray-600">Masukkan data transaksi penerimaan saldo atau uang ke sistem.</p>
    </div>

    <form action="{{ route('finance.incoming-transactions.store') }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf

        {{-- Wallet Tujuan --}}
        <div class="mb-4">
            <label for="wallet_id" class="block text-sm font-medium text-gray-700">Wallet Tujuan</label>
            <select name="wallet_id" id="wallet_id" required class="w-full border rounded px-3 py-2 mt-1">
                <option value="">-- Pilih Wallet --</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                       {{ $wallet->owner->name ?? '-' }} ({{ $wallet->uuid }})
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

        {{-- Metode Pembayaran --}}
        <div class="mb-4">
            <label for="method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <select name="method" id="method" required class="w-full border rounded px-3 py-2 mt-1">
                <option value="">-- Pilih Metode --</option>
                <option value="tunai" {{ old('method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="topup" {{ old('method') == 'topup' ? 'selected' : '' }}>Top-up</option>
                <option value="donasi" {{ old('method') == 'donasi' ? 'selected' : '' }}>Donasi</option>
            </select>
            @error('method')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor Referensi --}}
        <div class="mb-4">
            <label for="reference_number" class="block text-sm font-medium text-gray-700">Nomor Referensi (Opsional)</label>
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
            <a href="{{ route('finance.incoming-transactions.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>
@endsection
