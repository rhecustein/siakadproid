@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Data Orang Tua / Wali
    </h1>
    <p class="text-gray-600 text-base">Perbarui informasi orang tua atau wali siswa.</p>
</div>

{{-- Success/Error Alert --}}
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
    <form action="{{ route('core.parents.update', $parent->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $parent->name) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Bapak Budi Santoso" required autofocus>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Jenis Kelamin --}}
            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Kelamin</label>
                <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih —</option>
                    <option value="L" {{ old('gender', $parent->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $parent->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Hubungan --}}
            <div>
                <label for="relationship" class="block text-sm font-semibold text-gray-800 mb-1">Hubungan</label>
                <select name="relationship" id="relationship"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih —</option>
                    <option value="ayah" {{ old('relationship', $parent->relationship) == 'ayah' ? 'selected' : '' }}>Ayah</option>
                    <option value="ibu" {{ old('relationship', $parent->relationship) == 'ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="wali" {{ old('relationship', $parent->relationship) == 'wali' ? 'selected' : '' }}>Wali</option>
                </select>
                @error('relationship')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Nomor HP --}}
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-800 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $parent->phone) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 081234567890" required>
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $parent->email) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="email@example.com">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-800 mb-1">Alamat</label>
            <textarea name="address" id="address" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Alamat lengkap">{{ old('address', $parent->address) }}</textarea>
            @error('address')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status Aktif/Nonaktif --}}
        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-1">Status Akun</label>
            <div class="mt-1 flex items-center space-x-4">
                <label for="is_active_true" class="inline-flex items-center">
                    <input type="radio" id="is_active_true" name="is_active" value="1"
                           class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                           {{ old('is_active', $parent->is_active) == 1 ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
                <label for="is_active_false" class="inline-flex items-center">
                    <input type="radio" id="is_active_false" name="is_active" value="0"
                           class="form-radio h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500"
                           {{ old('is_active', $parent->is_active) == 0 ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                </label>
            </div>
            @error('is_active')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('core.parents.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection