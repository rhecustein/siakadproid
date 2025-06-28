@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Detail Pegawai</h2>
  <p class="text-sm text-gray-500">Informasi lengkap mengenai pegawai.</p>
</div>

<div class="bg-white shadow rounded-xl p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
      <p class="text-gray-500">NIP</p>
      <p class="font-medium text-gray-900">{{ $employee->nip ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Nama</p>
      <p class="font-medium text-gray-900">{{ $employee->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Email</p>
      <p class="font-medium text-gray-900">{{ $employee->email ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">No. HP</p>
      <p class="font-medium text-gray-900">{{ $employee->phone ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Posisi</p>
      <p class="font-medium text-gray-900">{{ $employee->position ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Departemen</p>
      <p class="font-medium text-gray-900">{{ $employee->department ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Unit Sekolah</p>
      <p class="font-medium text-gray-900">
        {{ $employee->school?->name ?? '-' }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Tempat, Tanggal Lahir</p>
      <p class="font-medium text-gray-900">
        {{ $employee->birth_place ?? '-' }},
        {{ $employee->birth_date ? $employee->birth_date->format('d M Y') : '-' }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Bergabung</p>
      <p class="font-medium text-gray-900">{{ $employee->join_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Keluar</p>
      <p class="font-medium text-gray-900">{{ $employee->end_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status Pernikahan</p>
      <p class="font-medium text-gray-900">{{ $employee->marital_status ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Jenis Kelamin</p>
      <p class="font-medium text-gray-900">{{ $employee->gender ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Agama</p>
      <p class="font-medium text-gray-900">{{ $employee->religion ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Pendidikan Terakhir</p>
      <p class="font-medium text-gray-900">
        {{ $employee->education_level ?? '-' }} - {{ $employee->last_education_institution ?? '-' }}
      </p>
    </div>

    <div class="md:col-span-2">
      <p class="text-gray-500">Alamat</p>
      <p class="font-medium text-gray-900">{{ $employee->address ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status</p>
      <p class="font-medium {{ $employee->status === 'aktif' ? 'text-green-600' : 'text-red-600' }}">
        {{ ucfirst($employee->status) }}
      </p>
    </div>

    @if ($employee->photo)
      <div>
        <p class="text-gray-500">Foto</p>
        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto Pegawai" class="w-32 h-32 rounded-lg object-cover">
      </div>
    @endif
  </div>
</div>

<div class="mt-6">
  <a href="{{ route('employee.employees.index') }}"
     class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
    ← Kembali ke Daftar Pegawai
  </a>
</div>
@endsection
