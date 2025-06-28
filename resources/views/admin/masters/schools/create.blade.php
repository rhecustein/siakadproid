@extends('layouts.app')

@section('content')
<div class="flex justify-center">
  <div class="w-full max-w-2xl bg-white rounded-xl shadow-md p-8">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-blue-700">Tambah Sekolah</h2>
      <p class="text-sm text-gray-500">Form untuk menambahkan data sekolah baru.</p>
    </div>

    <form method="POST" action="{{ route('master.schools.store') }}">
      @csrf

      <!-- Cabang -->
      <div class="mb-4">
        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
        <select name="branch_id" id="branch_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
                required>
          <option value="">-- Pilih Cabang --</option>
          @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
              {{ $branch->name }}
            </option>
          @endforeach
        </select>
        @error('branch_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Nama Sekolah -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- NPSN -->
      <div class="mb-4">
        <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
        <input type="text" name="npsn" id="npsn" value="{{ old('npsn') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500">
        @error('npsn') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Jenis Sekolah -->
      <div class="mb-4">
        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Sekolah</label>
        <input type="text" name="type" id="type" value="{{ old('type') }}"
               placeholder="misal: formal, pondok, diniyah..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500">
        @error('type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Alamat -->
      <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
        <textarea name="address" id="address"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
                  rows="3">{{ old('address') }}</textarea>
        @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Telepon -->
      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500">
        @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Email -->
      <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500">
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Tombol Aksi -->
      <div class="flex items-center justify-between mt-6">
        <a href="{{ route('master.schools.index') }}" class="text-sm text-gray-600 hover:underline">
          ← Kembali ke Daftar Sekolah
        </a>
        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Sekolah
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
