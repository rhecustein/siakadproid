@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Tipe Inventaris Baru
    </h1>
    <p class="text-gray-600 text-base">Isi detail jenis inventaris baru untuk sistem.</p>
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
    <form method="POST" action="{{ route('facility.inventory-types.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Tipe <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Contoh: Elektronik, Furnitur, Bahan Ajar" required autofocus>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="flex items-center">
                <input type="checkbox" name="is_electronic" id="is_electronic" value="1"
                       class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                       {{ old('is_electronic') ? 'checked' : '' }}>
                <label for="is_electronic" class="ml-2 text-sm text-gray-700 font-medium">Termasuk Barang Elektronik</label>
                @error('is_electronic') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_consumable" id="is_consumable" value="1"
                       class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                       {{ old('is_consumable') ? 'checked' : '' }}>
                <label for="is_consumable" class="ml-2 text-sm text-gray-700 font-medium">Termasuk Barang Habis Pakai</label>
                @error('is_consumable') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="economic_life" class="block text-sm font-semibold text-gray-800 mb-1">Umur Ekonomis (tahun)</label>
            <input type="number" name="economic_life" id="economic_life" value="{{ old('economic_life') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Contoh: 5" min="1">
            @error('economic_life') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('facility.inventory-types.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Tipe Inventaris
            </button>
        </div>
    </form>
</div>
@endsection