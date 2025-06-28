@extends('layouts.app')

@section('content')
<div class="mb-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div class="mb-4 sm:mb-0">
      <h2 class="text-2xl font-bold text-blue-700">Daftar Guru & Wali Kelas</h2>
      <p class="text-sm text-gray-500">Semua guru aktif yang terdaftar dalam sistem.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('academic.teachers.create') }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Guru
      </a>
      <a href="{{ route('academic.homeroom.index') }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        + Wali Kelas
      </a>
    </div>
  </div>

      @if (session('success'))
    <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- FILTER & SEARCH --}}
  <form method="GET" action="{{ route('academic.teachers.index') }}" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-xl shadow">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau email"
      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

    <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Jenis Kelamin</option>
      <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
      <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>

    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Status</option>
      <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
      <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>

    <select name="school_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Sekolah</option>
      @foreach ($schools as $school)
        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
          {{ $school->name }}
        </option>
      @endforeach
    </select>
  </form>
</div>

{{-- TABEL DATA --}}
<div class="bg-white shadow rounded-xl overflow-x-auto mt-6">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Nama</th>
        <th class="px-6 py-3">NIP</th>
        <th class="px-6 py-3">Jenis Kelamin</th>
        <th class="px-6 py-3">Email</th>
        <th class="px-6 py-3">Sekolah</th>
        <th class="px-6 py-3">Jabatan</th>
        <th class="px-6 py-3">Wali Kelas</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($teachers as $index => $teacher)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $index + 1 }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $teacher->name }}</td>
          <td class="px-6 py-3">{{ $teacher->nip ?? '—' }}</td>
          <td class="px-6 py-3">{{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
          <td class="px-6 py-3">{{ $teacher->email ?? '—' }}</td>
          <td class="px-6 py-3">{{ $teacher->school->name ?? '—' }}</td>
          <td class="px-6 py-3">{{ $teacher->position ?? '—' }}</td>
          <td class="px-6 py-3">
            @if ($teacher->homeroom)
              {{ $teacher->homeroom->classroom->name ?? '—' }}
            @else
              —
            @endif
          </td>
          <td class="px-6 py-3">
            @if ($teacher->is_active)
              <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
            @else
              <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Nonaktif</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
            <a href="{{ route('academic.teachers.edit', $teacher->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="{{ route('academic.teachers.destroy', $teacher->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" class="px-6 py-4 text-center text-gray-500">Belum ada data guru.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
