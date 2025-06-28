@extends('layouts.app')

@section('content')
<div class="flex justify-center">
  <div class="w-full max-w-xl bg-white rounded-xl shadow-md p-8">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-blue-700">Detail Pengguna</h2>
      <p class="text-sm text-gray-500">Informasi lengkap pengguna sistem.</p>
    </div>

    <div class="space-y-4 text-sm">
      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">Nama</span>
        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
      </div>

      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">Username</span>
        <span class="text-gray-900 font-medium">{{ $user->username }}</span>
      </div>

      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">Email</span>
        <span class="text-gray-900 font-medium">{{ $user->email }}</span>
      </div>

      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">Nomor HP</span>
        <span class="text-gray-900 font-medium">{{ $user->phone_number ?? '-' }}</span>
      </div>

      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">Role</span>
        @php
          $roles = [1 => 'Admin', 2 => 'Guru', 3 => 'Orang Tua', 4 => 'Siswa'];
        @endphp
        <span class="text-gray-900 font-medium">{{ $roles[$user->role_id] ?? '-' }}</span>
      </div>

      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-500">UUID</span>
        <span class="text-gray-900 font-mono text-xs">{{ $user->uuid }}</span>
      </div>

      <div class="flex justify-between">
        <span class="text-gray-500">Dibuat Pada</span>
        <span class="text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</span>
      </div>
    </div>

    <div class="mt-6 text-right">
      <a href="{{ route('core.users.index') }}"
         class="text-sm text-blue-600 hover:underline">
        ← Kembali ke Daftar Pengguna
      </a>
    </div>
  </div>
</div>
@endsection
