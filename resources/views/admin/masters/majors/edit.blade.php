@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Jurusan
    </h1>
    <p class="text-gray-600 text-base">Perbarui informasi untuk jurusan ini.</p>
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
    <form action="{{ route('academic.majors.update', $major->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Jurusan --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Jurusan <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $major->name) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Ilmu Pengetahuan Alam (IPA)" required autofocus>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label for="slug" class="block text-sm font-semibold text-gray-800 mb-1">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $major->slug) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                   placeholder="Misal: ipa (otomatis jika kosong)">
            @error('slug')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Code --}}
        <div>
            <label for="code" class="block text-sm font-semibold text-gray-800 mb-1">Kode Jurusan</label>
            <input type="text" name="code" id="code" value="{{ old('code', $major->code) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                   placeholder="Misal: SMA-IPA">
            @error('code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                      placeholder="Deskripsi singkat mengenai jurusan ini.">{{ old('description', $major->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block text-sm font-semibold text-gray-800 mb-1">Tipe Jurusan <span class="text-red-500">*</span></label>
            <select name="type" id="type" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Tipe —</option>
                <option value="academic" {{ old('type', $major->type) == 'academic' ? 'selected' : '' }}>Akademik</option>
                <option value="vocational" {{ old('type', $major->type) == 'vocational' ? 'selected' : '' }}>Kejuruan</option>
                {{-- Tambahkan tipe lain jika relevan: academic, vocational, religious, special --}}
                <option value="religious" {{ old('type', $major->type) == 'religious' ? 'selected' : '' }}>Agama</option>
                <option value="special" {{ old('type', $major->type) == 'special' ? 'selected' : '' }}>Khusus</option>
            </select>
            @error('type')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Level --}}
            <div>
                <label for="level_id" class="block text-sm font-semibold text-gray-800 mb-1">Jenjang Pendidikan</label>
                <select name="level_id" id="level_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Jenjang —</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $major->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('level_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- School --}}
            <div>
                <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-1">Sekolah</label>
                <select name="school_id" id="school_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Sekolah —</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id', $major->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Order --}}
        <div>
            <label for="order" class="block text-sm font-semibold text-gray-800 mb-1">Urutan (Prioritas Tampilan)</label>
            <input type="number" name="order" id="order" value="{{ old('order', $major->order) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: 0 untuk prioritas tertinggi">
            @error('order')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('academic.majors.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Perbarui Jurusan
            </button>
        </div>
    </form>
</div>
@endsection