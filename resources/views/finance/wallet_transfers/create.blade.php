@extends('layouts.app')

@section('title', 'Transfer Antar Wallet')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Transfer Antar Wallet</h1>
        <p class="text-gray-600">Silakan isi formulir untuk melakukan transfer saldo antar wallet.</p>
    </div>

    <form action="{{ route('finance.wallet-transfers.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        {{-- Dari Wallet --}}
        <div class="mb-4">
            <label for="from_wallet_id" class="block text-sm font-medium text-gray-700">Dari Wallet</label>
            <select name="from_wallet_id" id="from_wallet_id" class="w-full border rounded px-3 py-2 mt-1" required>
                <option value="">-- Pilih Wallet --</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ old('from_wallet_id') == $wallet->id ? 'selected' : '' }}>
                        {{ $wallet->name }} (Saldo: Rp{{ number_format($wallet->balance, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
            @error('from_wallet_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ke Wallet --}}
        <div class="mb-4">
            <label for="to_wallet_id" class="block text-sm font-medium text-gray-700">Ke Wallet</label>
            <select name="to_wallet_id" id="to_wallet_id" class="w-full border rounded px-3 py-2 mt-1" required>
                <option value="">-- Pilih Wallet --</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ old('to_wallet_id') == $wallet->id ? 'selected' : '' }}>
                        {{ $wallet->name }} (Saldo: Rp{{ number_format($wallet->balance, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
            @error('to_wallet_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Transfer</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="100"
                   class="w-full border rounded px-3 py-2 mt-1" required>
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-4">
            <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="note" id="note" rows="3"
                      class="w-full border rounded px-3 py-2 mt-1">{{ old('note') }}</textarea>
            @error('note')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('finance.wallet-transfers.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Transfer Sekarang
            </button>
        </div>
    </form>
</div>
@endsection
