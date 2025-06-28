@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Detail Siswa</h2>
  <p class="text-sm text-gray-500">Informasi lengkap mengenai siswa terdaftar.</p>
</div>

<div class="bg-white shadow rounded-xl p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

    <div>
      <p class="text-gray-500">Nama Lengkap</p>
      <p class="font-medium text-gray-900">{{ $student->name }}</p>
    </div>

    <div>
      <p class="text-gray-500">NIS / NISN</p>
      <p class="font-medium text-gray-900">
        {{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Sekolah</p>
      <p class="font-medium text-gray-900">{{ $student->school->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Kelas</p>
      <p class="font-medium text-gray-900">{{ $student->grade->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Wali Utama</p>
      <p class="font-medium text-gray-900">{{ $student->parent->name ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Jenis Kelamin</p>
      <p class="font-medium text-gray-900">
        {{ $student->gender === 'L' ? 'Laki-laki' : ($student->gender === 'P' ? 'Perempuan' : '-') }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Tempat, Tanggal Lahir</p>
      <p class="font-medium text-gray-900">
        {{ $student->place_of_birth ?? '-' }},
        {{ $student->date_of_birth ? $student->date_of_birth->format('d M Y') : '-' }}
      </p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Masuk</p>
      <p class="font-medium text-gray-900">{{ $student->admission_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Tanggal Lulus</p>
      <p class="font-medium text-gray-900">{{ $student->graduation_date?->format('d M Y') ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Agama</p>
      <p class="font-medium text-gray-900">{{ $student->religion ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">No. HP</p>
      <p class="font-medium text-gray-900">{{ $student->phone ?? '-' }}</p>
    </div>

    <div class="md:col-span-2">
      <p class="text-gray-500">Alamat</p>
      <p class="font-medium text-gray-900">{{ $student->address ?? '-' }}</p>
    </div>

    <div>
      <p class="text-gray-500">Status</p>
      <p class="font-medium text-gray-900">{{ ucfirst($student->student_status) }}</p>
    </div>

    <div>
      <p class="text-gray-500">Aktif</p>
      <p class="font-medium {{ $student->is_active ? 'text-green-600' : 'text-red-600' }}">
        {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
      </p>
    </div>

    @if ($student->photo)
    <div class="md:col-span-2">
      <p class="text-gray-500">Foto</p>
      <img src="{{ asset('storage/' . $student->photo) }}" class="w-32 h-32 object-cover rounded-lg" alt="Foto Siswa">
    </div>
    @endif

    @if ($student->notes)
    <div class="md:col-span-2">
      <p class="text-gray-500">Catatan</p>
      <p class="font-medium text-gray-900">{{ $student->notes }}</p>
    </div>
    @endif

  </div>
</div>

<div class="mt-6">
  <a href="{{ route('core.students.index') }}"
     class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
    ← Kembali ke Daftar Siswa
  </a>
</div>
@endsection
