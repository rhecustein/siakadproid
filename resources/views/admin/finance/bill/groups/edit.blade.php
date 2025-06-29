@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Grup Tagihan
    </h1>
    <p class="text-gray-600 text-base">Perbarui detail kelompok tagihan ini.</p>
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
    <form action="{{ route('finance.bill-groups.update', $billGroup->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Grup Tagihan --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Grup Tagihan <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $billGroup->name) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: SPP Siswa Baru 2024" required autofocus>
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            {{-- Jenis Tagihan (BillType) --}}
            <div>
                <label for="bill_type_id" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Tagihan <span class="text-red-500">*</span></label>
                <select name="bill_type_id" id="bill_type_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Jenis Tagihan —</option>
                    @foreach($billTypes as $type)
                        <option value="{{ $type->id }}" {{ old('bill_type_id', $billGroup->bill_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('bill_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Sekolah --}}
            <div>
                <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-1">Sekolah (Opsional)</label>
                <select name="school_id" id="school_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Sekolah —</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id', $billGroup->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Level --}}
            <div>
                <label for="level_id" class="block text-sm font-semibold text-gray-800 mb-1">Jenjang Pendidikan (Opsional)</label>
                <select name="level_id" id="level_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Jenjang —</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $billGroup->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('level_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tahun Ajaran --}}
            <div>
                <label for="academic_year_id" class="block text-sm font-semibold text-gray-800 mb-1">Tahun Ajaran (Opsional)</label>
                <select name="academic_year_id" id="academic_year_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Tahun Ajaran —</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $billGroup->academic_year_id) == $year->id ? 'selected' : '' }}>
                            {{ $year->year }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Gender Target --}}
            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-800 mb-1">Target Jenis Kelamin (Opsional)</label>
                <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Semua —</option>
                    <option value="male" {{ old('gender', $billGroup->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $billGroup->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jumlah Item Tagihan --}}
            <div>
                <label for="tagihan_count" class="block text-sm font-semibold text-gray-800 mb-1">Jumlah Item Tagihan <span class="text-red-500">*</span></label>
                <input type="number" name="tagihan_count" id="tagihan_count" value="{{ old('tagihan_count', $billGroup->tagihan_count) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 12 (untuk 12 bulan SPP)" min="1" required>
                @error('tagihan_count') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nominal per Item --}}
            <div>
                <label for="amount_per_tagihan" class="block text-sm font-semibold text-gray-800 mb-1">Nominal per Item (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="amount_per_tagihan" id="amount_per_tagihan" value="{{ old('amount_per_tagihan', $billGroup->amount_per_tagihan) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 250000" min="0" step="0.01" required>
                @error('amount_per_tagihan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tanggal Mulai Periode --}}
            <div>
                <label for="start_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Mulai Periode (Opsional)</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', optional($billGroup->start_date)->format('Y-m-d')) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
                @error('start_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Selesai Periode --}}
            <div>
                <label for="end_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Selesai Periode (Opsional)</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', optional($billGroup->end_date)->format('Y-m-d')) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
                @error('end_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Deskripsi Grup --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi Grup (Opsional)</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Penjelasan singkat mengenai grup tagihan ini.">{{ old('description', $billGroup->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status Aktif (Checkbox) --}}
        <div>
            <div class="flex items-center mt-4">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                       {{ old('is_active', $billGroup->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700 font-medium">Aktifkan Grup Tagihan ini</label>
            </div>
            @error('is_active') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('finance.bill-groups.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Perbarui Grup Tagihan
            </button>
        </div>
    </form>
</div>
@endsection