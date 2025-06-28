@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Kurikulum
    </h1>
    <p class="text-gray-600 text-base">Perbarui informasi kurikulum ini.</p>
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
    <form action="{{ route('academic.curriculums.update', $curriculum->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Curriculum Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Kurikulum <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $curriculum->name) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Kurikulum Merdeka, K13" required autofocus>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Code --}}
        <div>
            <label for="code" class="block text-sm font-semibold text-gray-800 mb-1">Kode Kurikulum</label>
            <input type="text" id="code" name="code" value="{{ old('code', $curriculum->code) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: KKM2024">
            @error('code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
            <textarea id="description" name="description" rows="4"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Deskripsi singkat mengenai kurikulum ini.">{{ old('description', $curriculum->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Start Year --}}
            <div>
                <label for="start_year" class="block text-sm font-semibold text-gray-800 mb-1">Tahun Mulai</label>
                <input type="number" id="start_year" name="start_year" value="{{ old('start_year', $curriculum->start_year) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="e.g. 2024" min="1900" max="2100">
                @error('start_year')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- End Year --}}
            <div>
                <label for="end_year" class="block text-sm font-semibold text-gray-800 mb-1">Tahun Selesai (Opsional)</label>
                <input type="number" id="end_year" name="end_year" value="{{ old('end_year', $curriculum->end_year) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="e.g. 2026" min="1900" max="2100">
                @error('end_year')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Level Group --}}
        <div>
            <label for="level_group" class="block text-sm font-semibold text-gray-800 mb-1">Jenjang Pendidikan <span class="text-red-500">*</span></label>
            <select id="level_group" name="level_group" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 pr-8 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Jenjang —</option>
                {{-- Gunakan data $levelGroups dari controller (asumsi dilewatkan) --}}
                @foreach ($levelGroups as $key => $value)
                    <option value="{{ $key }}" {{ old('level_group', $curriculum->level_group) == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            @error('level_group')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Applicable Grades (assuming single input for comma-separated string) --}}
        <div>
            <label for="applicable_grades" class="block text-sm font-semibold text-gray-800 mb-1">Kelas yang Berlaku (pisahkan dengan koma)</label>
            <input type="text" id="applicable_grades" name="applicable_grades"
                   value="{{ old('applicable_grades', is_array($curriculum->applicable_grades) ? implode(',', $curriculum->applicable_grades) : $curriculum->applicable_grades) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: 1,2,3 (untuk SD), atau 10,11,12 (untuk SMA)">
            @error('applicable_grades')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Regulation Number --}}
        <div>
            <label for="regulation_number" class="block text-sm font-semibold text-gray-800 mb-1">Nomor Regulasi</label>
            <input type="text" id="regulation_number" name="regulation_number" value="{{ old('regulation_number', $curriculum->regulation_number) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Permendikbudristek No. 5 Tahun 2024">
            @error('regulation_number')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Reference Document --}}
        <div>
            <label for="reference_document" class="block text-sm font-semibold text-gray-800 mb-1">Dokumen Referensi (Link/Nama)</label>
            <input type="text" id="reference_document" name="reference_document" value="{{ old('reference_document', $curriculum->reference_document) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: https://drive.google.com/xyz atau SK Kepala Sekolah No. 001">
            @error('reference_document')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('academic.curriculums.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Perbarui Kurikulum
            </button>
        </div>
    </form>
</div>
@endsection