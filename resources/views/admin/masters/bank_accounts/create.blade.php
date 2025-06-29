@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Rekening Bank Baru
    </h1>
    <p class="text-gray-600 text-base">Isi detail rekening bank untuk layanan keuangan sekolah.</p>
</div>

{{-- Success/Error Alert (consistent with other pages) --}}
@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <ul class="font-medium list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow-xl rounded-2xl p-8 mb-8 border border-gray-100">
    <form action="{{ route('finance.bank-accounts.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="account_number" class="block text-sm font-semibold text-gray-800 mb-1">Nomor Rekening <span class="text-red-500">*</span></label>
                <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 1234567890" required autofocus>
                @error('account_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_holder" class="block text-sm font-semibold text-gray-800 mb-1">Nama Pemegang Rekening <span class="text-red-500">*</span></label>
                <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: Yayasan Al-Bahjah" required>
                @error('account_holder') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="bank_name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Bank <span class="text-red-500">*</span></label>
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: Bank Syariah Indonesia (BSI)" required>
                @error('bank_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="bank_code" class="block text-sm font-semibold text-gray-800 mb-1">Kode Bank</label>
                <input type="text" name="bank_code" id="bank_code" value="{{ old('bank_code') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 451">
                @error('bank_code') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-1">Sekolah Terkait (Opsional)</label>
            <select name="school_id" id="school_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Sekolah —</option>
                @foreach ($schools as $school) {{-- Asumsi $schools dilewatkan dari controller --}}
                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
            @error('school_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Penggunaan Rekening</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ([
                    'online_payment' => 'Pembayaran Online',
                    'can_pay_bills' => 'Pembayaran Tagihan',
                    'can_save' => 'Tabungan',
                    'can_donate' => 'Donasi',
                ] as $name => $label)
                <div class="flex items-center">
                    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1" class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" {{ old($name) ? 'checked' : '' }}>
                    <label for="{{ $name }}" class="ml-2 text-sm text-gray-700 font-medium">{{ $label }}</label>
                </div>
                @endforeach
            </div>
             {{-- @error untuk setiap boolean field jika diperlukan --}}
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Status Rekening</h4>
            <div class="flex items-center space-x-4">
                <label for="is_active_true" class="inline-flex items-center">
                    <input type="radio" id="is_active_true" name="is_active" value="1"
                           class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                           {{ old('is_active', true) == 1 ? 'checked' : '' }}> {{-- Default checked true --}}
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
                <label for="is_active_false" class="inline-flex items-center">
                    <input type="radio" id="is_active_false" name="is_active" value="0"
                           class="form-radio h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500"
                           {{ old('is_active') == 0 && old('is_active') !== null ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                </label>
            </div>
            @error('is_active') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>


        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('finance.bank-accounts.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Rekening
            </button>
        </div>
    </form>
</div>
@endsection