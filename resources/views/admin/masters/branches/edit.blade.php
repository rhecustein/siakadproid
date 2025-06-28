@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <div class="mb-8 text-center">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                Edit Data Cabang
            </h1>
            <p class="text-gray-600 text-base">Perbarui informasi cabang ini sesuai kebutuhan.</p>
        </div>

        <form method="POST" action="{{ route('shared.branches.update', $branch->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Cabang <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       required placeholder="Contoh: Cabang Pusat, Cabang Surabaya">
                @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                <textarea name="address" id="address" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                          required placeholder="Alamat lengkap cabang, termasuk kota dan provinsi">{{ old('address', $branch->address) }}</textarea>
                @error('address') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('shared.branches.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Cabang
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-base font-semibold shadow-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-2-4l-4-4m0 0L8 7m4-4v3m0-3c1.333-1.333 3.333-1.333 4.667 0"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection