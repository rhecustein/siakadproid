@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
  <div>
    <h2 class="text-2xl font-bold text-blue-700">Daftar Siswa</h2>
    <p class="text-sm text-gray-500">Semua siswa yang terdaftar dalam sistem.</p>
  </div>
  <div class="flex gap-2">
    <a href="#" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-200">Import</a>
    <a href="#" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-200">Export</a>
    <a href="{{ route('master.students.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Tambah Siswa
    </a>
  </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
    <p class="text-sm text-gray-600">Total Siswa</p>
    <p class="text-2xl font-bold text-blue-700">{{ $students->total() }}</p>
  </div>
  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
    <p class="text-sm text-gray-600">Aktif</p>
    <p class="text-2xl font-bold text-green-600">{{ $students->filter(fn($s) => $s->student_status === 'aktif')->count() }}</p>
  </div>
  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
    <p class="text-sm text-gray-600">Laki-laki</p>
    <p class="text-2xl font-bold text-gray-800">{{ $students->filter(fn($s) => $s->gender === 'L')->count() }}</p>
  </div>
  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
    <p class="text-sm text-gray-600">Perempuan</p>
    <p class="text-2xl font-bold text-pink-600">{{ $students->filter(fn($s) => $s->gender === 'P')->count() }}</p>
  </div>
</div>

@if (session('success'))
  <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
    <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
  </div>
@endif

<form method="GET" action="{{ route('master.students.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded-xl shadow">
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS"
         class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

  <select name="grade_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
    <option value="">Semua Kelas</option>
 
  </select>

  <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
    <option value="">Semua Gender</option>
    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
  </select>

  <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
    <option value="">Semua Status</option>
    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
  </select>

  <button type="submit"
          class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition self-end">
    Terapkan Filter
  </button>
</form>

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
  <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
    <tr>
      <th class="px-4 py-3">#</th>
      <th class="px-4 py-3">NIS</th>
      <th class="px-4 py-3">NISN</th>
      <th class="px-4 py-3">Nama</th>
      <th class="px-4 py-3">Sekolah</th>
      <th class="px-4 py-3">Kelas</th>
      <th class="px-4 py-3">Orang Tua</th>
      <th class="px-4 py-3">Gender</th>
      <th class="px-4 py-3">Masuk</th>
      <th class="px-4 py-3">Status</th>
      <th class="px-4 py-3 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody class="divide-y divide-gray-200">
    @forelse ($students as $index => $student)
      <tr class="hover:bg-blue-50 transition">
        <td class="px-4 py-2">{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}</td>
        <td class="px-4 py-2">{{ $student->nis ?? '—' }}</td>
        <td class="px-4 py-2">{{ $student->nisn ?? '—' }}</td>
        <td class="px-4 py-2 font-semibold text-gray-800">{{ $student->name }}</td>
        <td class="px-4 py-2">{{ $student->school->name ?? '—' }}</td>
        <td class="px-4 py-2">{{ $student->grade->label ?? '—' }}</td>
        <td class="px-4 py-2">{{ $student->parent->name ?? '—' }}</td>
        <td class="px-4 py-2">
          @if($student->gender === 'L') Laki-laki
          @elseif($student->gender === 'P') Perempuan
          @else -
          @endif
        </td>
        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($student->admission_date)->format('d M Y') ?? '—' }}</td>
        <td class="px-4 py-2">
          @if ($student->student_status === 'aktif')
            <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
          @else
            <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">
              {{ ucfirst($student->student_status) }}
            </span>
          @endif
        </td>
        <td class="px-4 py-2 text-center whitespace-nowrap space-x-1">
          <a href="{{ route('master.students.edit', $student->id) }}"
             class="inline-block px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded hover:bg-blue-200">
            ✏️ Edit
          </a>
          <a href="{{ route('master.students.show', $student->id) }}"
             class="inline-block px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
            🔍 Detail
          </a>
          <form action="{{ route('master.students.destroy', $student->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-block px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded hover:bg-red-200">
              🗑️ Hapus
            </button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="11" class="px-6 py-4 text-center text-gray-500">Belum ada data siswa.</td>
      </tr>
    @endforelse
  </tbody>
</table>
  
  <div class="px-6 py-4">{{ $students->withQueryString()->links() }}</div>
</div>
@endsection
