@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Detail Staff</h2>
  <p class="text-sm text-gray-500">Informasi lengkap staf yang terdaftar.</p>
</div>

<div class="bg-white shadow rounded-xl p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

    <div>
      <p class="text-gray-500">Nama</p>
      <p class="font-medium text-gray-900">{{ $staffs->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">NIP</p>
      <p class="font-medium text-gray-900">{{ $staffs->nip ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Email</p>
      <p class="font-medium text-gray-900">{{ $staffs->email ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">No. HP</p>
      <p class="font-medium text-gray-900">{{ $staffs->phone ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Sekolah</p>
      <p class="font-medium text-gray-900">{{ $staffs->school->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Akun User</p>
      <p class="font-medium text-gray-900">{{ $staffs->user->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Posisi</p>
      <p class="font-medium text-gray-900">{{ $staffs->position ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Departemen</p>
      <p class="font-medium text-gray-900">{{ $staffs->department ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status Kepegawaian</p>
      <p class="font-medium text-gray-900">{{ $staffs->employment_status ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Tempat, Tanggal Lahir</p>
      <p class="font-medium text-gray-900">
        {{ $staffs->birth_place ?? '-' }},
        {{ $staffs->birth_date ? $staffs->birth_date->format('d M Y') : '-' }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Masuk</p>
      <p class="font-medium text-gray-900">{{ $staffs->join_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Keluar</p>
      <p class="font-medium text-gray-900">{{ $staffs->end_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Jenis Kelamin</p>
      <p class="font-medium text-gray-900">{{ $staffs->gender ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status Pernikahan</p>
      <p class="font-medium text-gray-900">{{ $staffs->marital_status ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Agama</p>
      <p class="font-medium text-gray-900">{{ $staffs->religion ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Pendidikan Terakhir</p>
      <p class="font-medium text-gray-900">
        {{ $staffs->education_level ?? '-' }} - {{ $staffs->last_education_institution ?? '-' }}
      </p>
    </div>

    <div class="md:col-span-2">
      <p class="text-gray-500">Alamat</p>
      <p class="font-medium text-gray-900">{{ $staffs->address ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status</p>
      <p class="font-medium {{ $staffs->status === 'aktif' ? 'text-green-600' : 'text-red-600' }}">
        {{ ucfirst($staffs->status) }}
      </p>
    </div>

    @if ($staffs->photo)
      <div>
        <p class="text-gray-500">Foto</p>
        <img src="{{ asset('storage/' . $staffs->photo) }}" class="w-32 h-32 rounded-lg object-cover" alt="Foto Staff">
      </div>
    @endif

  </div>
</div>

<div class="mt-6">
  <a href="{{ route('employee.staffs.index') }}"
     class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
    ← Kembali ke Daftar Staff
  </a>
</div>
@endsection
