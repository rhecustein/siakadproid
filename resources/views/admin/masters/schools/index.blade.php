@extends('layouts.app')

@section('content')
  <!-- Header & Buttons -->
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Sekolah & Cabang</h2>
      <p class="text-sm text-gray-500">Daftar sekolah dan unit cabang terdaftar dalam sistem.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('shared.branches.create') }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Cabang
      </a>
      <a href="{{ route('shared.schools.create') }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Sekolah
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

  <!-- Filter/Search -->
  <form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama sekolah atau cabang..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="type" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">Semua Tipe</option>
      <option value="formal" {{ request('type') == 'formal' ? 'selected' : '' }}>Formal</option>
      <option value="informal" {{ request('type') == 'informal' ? 'selected' : '' }}>Informal</option>
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Filter
    </button>
  </form>

  <!-- Cabang Table -->
  <div class="mb-10">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Cabang</h3>
    <div class="bg-white shadow rounded-xl overflow-x-auto">
      <table class="min-w-full table-auto text-sm text-left border-collapse">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
          <tr>
            <th class="px-6 py-3">#</th>
            <th class="px-6 py-3">Nama Cabang</th>
            <th class="px-6 py-3">Alamat</th>
            <th class="px-6 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($branches as $index => $branch)
            <tr class="hover:bg-blue-50 transition">
              <td class="px-6 py-3">{{ $branches->firstItem() + $index }}</td>
              <td class="px-6 py-3 font-medium text-gray-900">{{ $branch->name }}</td>
              <td class="px-6 py-3 text-gray-700">{{ $branch->address ?? '-' }}</td>
              <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
                <a href="{{ route('shared.branches.edit', $branch->id) }}"
                   class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                  Edit
                </a>
                <form action="{{ route('shared.branches.destroy', $branch->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus data cabang ini?')">
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
              <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data cabang.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4 flex justify-between text-sm text-gray-600">
      <p>Menampilkan {{ $branches->firstItem() }} - {{ $branches->lastItem() }} dari {{ $branches->total() }} cabang</p>
      {{ $branches->appends(request()->query())->onEachSide(1)->links() }}
    </div>
  </div>

  <!-- Sekolah Table -->
  <div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Sekolah</h3>
    <div class="bg-white shadow rounded-xl overflow-x-auto">
      <table class="min-w-full table-auto text-sm text-left border-collapse">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
          <tr>
            <th class="px-6 py-3">#</th>
            <th class="px-6 py-3">Nama Sekolah</th>
            <th class="px-6 py-3">Cabang</th>
            <th class="px-6 py-3">NPSN</th>
            <th class="px-6 py-3">Tipe</th>
            <th class="px-6 py-3">Telepon</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($schools as $index => $school)
            <tr class="hover:bg-blue-50 transition">
              <td class="px-6 py-3">{{ $schools->firstItem() + $index }}</td>
              <td class="px-6 py-3 font-medium text-gray-900">{{ $school->name }}</td>
              <td class="px-6 py-3 text-gray-700">{{ $school->branch->name ?? '-' }}</td>
              <td class="px-6 py-3 text-gray-700">{{ $school->npsn ?? '-' }}</td>
              <td class="px-6 py-3 text-gray-700">{{ ucfirst($school->type ?? '-') }}</td>
              <td class="px-6 py-3 text-gray-700">{{ $school->phone ?? '-' }}</td>
              <td class="px-6 py-3 text-gray-700">{{ $school->email ?? '-' }}</td>
              <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
                <a href="{{ route('shared.schools.edit', $school->id) }}"
                   class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                  Edit
                </a>
                <form action="{{ route('shared.schools.destroy', $school->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus data sekolah ini?')">
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
              <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data sekolah.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4 flex justify-between text-sm text-gray-600">
      <p>Menampilkan {{ $schools->firstItem() }} - {{ $schools->lastItem() }} dari {{ $schools->total() }} sekolah</p>
      {{ $schools->appends(request()->query())->onEachSide(1)->links() }}
    </div>
  </div>
@endsection
