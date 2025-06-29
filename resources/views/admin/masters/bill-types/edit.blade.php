{{-- resources/views/admin/masters/bill-types/edit.blade.php --}}

{{-- Anda bisa memanggil form dari file terpisah seperti 'form.blade.php' --}}
{{-- Atau langsung salin kode di bawah ini ke dalam edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Tipe Tagihan
    </h1>
    <p class="text-gray-600 text-base">Perbarui detail untuk tipe tagihan ini.</p>
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
    <form method="POST"
          action="{{ route('finance.bill-types.update', $billType->id) }}"
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Tipe Tagihan <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $billType->name ?? '') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: SPP Bulanan" required autofocus>
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="code" class="block text-sm font-semibold text-gray-800 mb-1">Kode Tipe Tagihan <span class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" value="{{ old('code', $billType->code ?? '') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: SPP" required>
                @error('code') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Penjelasan singkat mengenai tipe tagihan ini.">{{ old('description', $billType->description ?? '') }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Tipe Tagihan</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_online_payment" id="is_online_payment" value="1"
                           class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                           {{ old('is_online_payment', $billType->is_online_payment ?? false) ? 'checked' : '' }}>
                    <label for="is_online_payment" class="ml-2 text-sm text-gray-700 font-medium">Bisa Dibayar Online</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_monthly" id="is_monthly" value="1"
                           class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                           {{ old('is_monthly', $billType->is_monthly ?? false) ? 'checked' : '' }}>
                    <label for="is_monthly" class="ml-2 text-sm text-gray-700 font-medium">Tagihan Bulanan</label>
                </div>
            </div>
            @error('is_online_payment') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            @error('is_monthly') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Status Aktif</h4>
            <div class="flex items-center space-x-4">
                <label for="is_active_true" class="inline-flex items-center">
                    <input type="radio" id="is_active_true" name="is_active" value="1"
                           class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                           {{ old('is_active', $billType->is_active ?? true) == 1 ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
                <label for="is_active_false" class="inline-flex items-center">
                    <input type="radio" id="is_active_false" name="is_active" value="0"
                           class="form-radio h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500"
                           {{ old('is_active', $billType->is_active ?? false) == 0 ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                </label>
            </div>
            @error('is_active') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('finance.bill-types.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Perbarui Tipe Tagihan
            </button>
        </div>
    </form>
</div>
@endsection