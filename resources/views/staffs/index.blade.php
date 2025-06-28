@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Manajemen Staff</h2>
  <p class="text-sm text-gray-500">Kelola data staf, guru, dan karyawan yayasan.</p>
</div>

@if (session('success'))
  <div class="mb-6 bg-emerald-100 border border-emerald-300 rounded-lg px-4 py-3 text-sm text-emerald-800 shadow">
    {{ session('success') }}
  </div>
@endif

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
  <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama atau posisi staff..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Cari
    </button>
  </form>

  <a href="{{ route('employee.staffs.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
    + Tambah Staff
  </a>
</div>

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Nama</th>
        <th class="px-6 py-3">Email</th>
        <th class="px-6 py-3">Posisi</th>
        <th class="px-6 py-3">Sekolah</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($staffs as $index => $staff)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $staffs->firstItem() + $index }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $staff->name ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $staff->email ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $staff->position ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $staff->school->name ?? '-' }}</td>
          <td class="px-6 py-3">
            <span class="text-sm font-medium {{ $staff->status === 'aktif' ? 'text-green-600' : 'text-red-600' }}">
              {{ ucfirst($staff->status) }}
            </span>
          </td>
          <td class="px-6 py-3 text-center space-x-2 whitespace-nowrap">
            <a href="{{ route('employee.staffs.show', $staff->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
              Lihat
            </a>
            <a href="{{ route('employee.staffs.edit', $staff->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="{{ route('employee.staffs.destroy', $staff->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus staff ini?')">
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
          <td colspan="7" class="px-6 py-4 text-center text-gray-500">Data staff tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
  <p>
    Menampilkan {{ $staffs->firstItem() }} – {{ $staffs->lastItem() }} dari {{ $staffs->total() }} staff
  </p>
  <div>
    {{ $staffs->appends(request()->query())->onEachSide(1)->links() }}
  </div>
</div>
@endsection
