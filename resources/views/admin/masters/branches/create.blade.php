@extends('layouts.app')

@section('content')
<div class="flex justify-center">
  <div class="w-full max-w-xl bg-white rounded-xl shadow-md p-8">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-blue-700">Tambah Cabang</h2>
      <p class="text-sm text-gray-500">Silakan isi informasi cabang baru dengan lengkap.</p>
    </div>

    <form method="POST" action="{{ route('master.branches.store') }}">
      @csrf

      <!-- Nama Cabang -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Cabang</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Alamat -->
      <div class="mb-6">
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
        <textarea name="address" id="address" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
                  placeholder="Alamat lengkap">{{ old('address') }}</textarea>
        @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Tombol Aksi -->
      <div class="flex items-center justify-between mt-6">
        <a href="{{ route('master.branches.index') }}" class="text-sm text-gray-600 hover:underline">
          ← Kembali ke Daftar Cabang
        </a>
        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Cabang
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
