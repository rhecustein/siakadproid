@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Manajemen Siswa</h2>
  <p class="text-sm text-gray-500">Kelola data siswa dari berbagai unit sekolah.</p>
</div>

@if (session('success'))
  <div class="mb-6 bg-emerald-100 border border-emerald-300 rounded-lg px-4 py-3 text-sm text-emerald-800 shadow">
    {{ session('success') }}
  </div>
@endif

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
  <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama/NIS/NISN..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Cari
    </button>
  </form>

  <a href="{{ route('core.students.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
    + Tambah Siswa
  </a>
</div>

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Nama</th>
        <th class="px-6 py-3">NIS</th>
        <th class="px-6 py-3">Sekolah</th>
        <th class="px-6 py-3">Kelas</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3">Aktif</th>
        <th class="px-6 py-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($students as $index => $student)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $students->firstItem() + $index }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $student->name }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $student->nis ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $student->school->name ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $student->grade->label ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ ucfirst($student->student_status) }}</td>
          <td class="px-6 py-3">
            <span class="text-sm font-medium {{ $student->is_active ? 'text-green-600' : 'text-red-600' }}">
              {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
          </td>
          <td class="px-6 py-3 text-center space-x-2 whitespace-nowrap">
            <a href="{{ route('core.students.show', $student->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
              Lihat
            </a>
            <a href="{{ route('core.students.edit', $student->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="{{ route('core.students.destroy', $student->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
          <td colspan="8" class="px-6 py-4 text-center text-gray-500">Data siswa tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
  <p>
    Menampilkan {{ $students->firstItem() }} – {{ $students->lastItem() }} dari {{ $students->total() }} siswa
  </p>
  <div>
    {{ $students->appends(request()->query())->onEachSide(1)->links() }}
  </div>
</div>
@endsection
