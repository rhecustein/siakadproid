@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Manajemen Pegawai</h2>
    <p class="text-sm text-gray-500">Kelola data karyawan, guru, dan staf yayasan.</p>
  </div>

  @if (session('success'))
    <div class="mb-6 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
    <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Cari nama pegawai..."
             class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />
      <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        Filter
      </button>
    </form>

    <a href="{{ route('employee.employees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
      + Tambah Pegawai
    </a>
  </div>

  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Nama</th>
          <th class="px-6 py-3">Email</th>
          <th class="px-6 py-3">Jabatan</th>
          <th class="px-6 py-3">Departemen</th>
          <th class="px-6 py-3">No. HP</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($employees as $index => $employee)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $employees->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $employee->name ?? '-' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $employee->email ?? '-' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $employee->position ?? '-' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $employee->department ?? '-' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $employee->phone ?? '-' }}</td>
            <td class="px-6 py-3">
              @if ($employee->status == 'aktif')
                <span class="text-green-500 font-medium">Aktif</span>
              @else
                <span class="text-red-500 font-medium">Nonaktif</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center space-x-2 whitespace-nowrap">
              <a href="{{ route('employee.employees.show', $employee->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                Lihat
              </a>
              <a href="{{ route('employee.employees.edit', $employee->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('employee.employees.destroy', $employee->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
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
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Data pegawai tidak ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
      Menampilkan {{ $employees->firstItem() }} – {{ $employees->lastItem() }} dari {{ $employees->total() }} pegawai
    </p>
    <div>
      {{ $employees->appends(request()->query())->onEachSide(1)->links() }}
    </div>
  </div>
@endsection
