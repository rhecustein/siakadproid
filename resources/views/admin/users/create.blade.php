@extends('layouts.app')

@section('content')
<div class="flex justify-center">
  <div class="w-full max-w-xl bg-white rounded-xl shadow-md p-8">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-blue-700">Tambah Pengguna</h2>
      <p class="text-sm text-gray-500">Lengkapi data untuk menambahkan pengguna baru.</p>
    </div>

    <form method="POST" action="{{ route('core.users.store') }}">
      @csrf
 
      <!-- Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Username -->
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Phone Number -->
      <div class="mb-4">
        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
        <input type="number" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500">
        @error('phone_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
               required>
        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Role -->
      <div class="mb-4">
        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
        <select name="role_id" id="role_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-500"
                required>
          <option value="">-- Pilih Role --</option>
          <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Admin</option>
          <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Guru</option>
          <option value="3" {{ old('role_id') == 3 ? 'selected' : '' }}>Orang Tua</option>
        </select>
        @error('role_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Tombol Aksi -->
      <div class="flex items-center justify-between mt-6">
        <a href="{{ route('core.users.index') }}" class="text-sm text-gray-600 hover:underline">
          ← Kembali ke Daftar Pengguna
        </a>
        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Pengguna
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
