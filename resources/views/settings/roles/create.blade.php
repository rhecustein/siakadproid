@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Peran Baru
    </h1>
    <p class="text-gray-600 text-base">Isi detail peran baru untuk mengelola hak akses pengguna.</p>
</div>

{{-- Success/Error Alert (consistent with other pages) --}}
@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@elseif(session('error'))
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
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
    <form action="{{ route('core.roles.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nama Peran (name) --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Peran <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: admin, guru, siswa" required autofocus>
            <p class="text-xs text-gray-500 mt-1">Gunakan nama peran unik dalam format lowercase dan tanpa spasi (misal: `admin_smp`, `guru_akademik`).</p>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Nama Tampilan (display_name) --}}
        <div>
            <label for="display_name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Tampilan <span class="text-red-500">*</span></label>
            <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Administrator Sistem, Guru Mata Pelajaran" required>
            <p class="text-xs text-gray-500 mt-1">Nama ini akan ditampilkan di antarmuka pengguna.</p>
            @error('display_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Guard Name --}}
        <div>
            <label for="guard_name" class="block text-sm font-semibold text-gray-800 mb-1">Guard <span class="text-red-500">*</span></label>
            <select name="guard_name" id="guard_name" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>Web (Aplikasi Utama)</option>
                <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API (Aplikasi Mobile/Lainnya)</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Menentukan sistem autentikasi yang digunakan peran ini.</p>
            @error('guard_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Penjelasan singkat tentang tugas dan tanggung jawab peran ini.">{{ old('description') }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Scope (Lingkup) --}}
        <div>
            <label for="scope" class="block text-sm font-semibold text-gray-800 mb-1">Lingkup / Batasan Peran (Opsional)</label>
            {{-- Ini bisa jadi multiple select atau input tag untuk custom scope --}}
            {{-- Contoh sederhana: input teks untuk scope yang dipisahkan koma --}}
            <input type="text" name="scope" id="scope" value="{{ old('scope') ? implode(',', old('scope')) : '' }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: sd, smp, sma (pisahkan dengan koma)">
            <p class="text-xs text-gray-500 mt-1">Jika peran ini hanya berlaku untuk unit tertentu (misal: hanya untuk SD atau SMP). Kosongkan jika berlaku untuk semua.</p>
            @error('scope') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('core.roles.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Peran
            </button>
        </div>
    </form>
</div>
@endsection