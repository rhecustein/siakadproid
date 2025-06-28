@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8"> {{-- Added horizontal padding and vertical padding for better spacing --}}
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100"> {{-- Increased max-w-xl to max-w-2xl, rounded-xl to rounded-2xl, shadow-md to shadow-xl, added border --}}

        <div class="mb-8 text-center"> {{-- Centered title and description --}}
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight"> {{-- Increased font size, changed color --}}
                Edit Pengguna
            </h1>
            <p class="text-gray-600 text-base">Perbarui informasi pengguna ini sesuai kebutuhan.</p> {{-- Changed text size and color --}}
        </div>

        <form method="POST" action="{{ route('core.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-5"> {{-- Increased margin-bottom --}}
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label> {{-- Bold label, added asterisk for required --}}
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm" {{-- Increased padding, font size, added focus styles, transition, shadow --}}
                       required placeholder="Masukkan nama lengkap">
                @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror {{-- Adjusted margin-top --}}
            </div>

            <div class="mb-5">
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       required placeholder="Username unik">
                @error('username') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       required placeholder="contoh@domain.com">
                @error('email') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       placeholder="Contoh: 081234567890">
                @error('phone_number') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6"> {{-- Increased margin-bottom for role select --}}
                <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                <select name="role_id" id="role_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm appearance-none bg-white pr-8"
                        required>
                    <option value="">-- Pilih Role --</option>
                    <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Guru</option>
                    <option value="3" {{ old('role_id', $user->role_id) == 3 ? 'selected' : '' }}>Orang Tua</option>
                    <option value="4" {{ old('role_id', $user->role_id) == 4 ? 'selected' : '' }}>Siswa</option>
                    <option value="5" {{ old('role_id', $user->role_id) == 5 ? 'selected' : '' }}>Operator</option>
                    <option value="6" {{ old('role_id', $user->role_id) == 6 ? 'selected' : '' }}>Petugas Kesehatan</option>
                    <option value="7" {{ old('role_id', $user->role_id) == 7 ? 'selected' : '' }}>Perpustakaan</option>
                    <option value="8" {{ old('role_id', $user->role_id) == 8 ? 'selected' : '' }}>PPDB</option>
                    <option value="9" {{ old('role_id', $user->role_id) == 9 ? 'selected' : '' }}>BK</option>
                    <option value="10" {{ old('role_id', $user->role_id) == 10 ? 'selected' : '' }}>Kantin</option>
                    <option value="11" {{ old('role_id', $user->role_id) == 11 ? 'selected' : '' }}>Laundry</option>
                    <option value="12" {{ old('role_id', $user->role_id) == 12 ? 'selected' : '' }}>Visitor</option>
                    <option value="13" {{ old('role_id', $user->role_id) == 13 ? 'selected' : '' }}>Mitra</option>
                </select>
                @error('role_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200"> {{-- Added top padding and border, made responsive flex --}}
                <a href="{{ route('core.users.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
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