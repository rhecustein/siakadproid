@extends('layouts.app')

@section('content')
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Daftar Tahun Ajaran</h2>
      <p class="text-sm text-gray-500">Semua tahun ajaran yang terdaftar dalam sistem.</p>
    </div>
    <a href="{{ route('academic.academic-years.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Tambah Tahun Ajaran
    </a>
  </div>

  <!-- Filter/Search -->
  <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari tahun ajaran..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="status" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">Semua Status</option>
      <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
      <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Filter
    </button>
  </form>

  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Tahun Ajaran</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($years as $index => $year)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $years->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $year->year }}</td>
            <td class="px-6 py-3">
              @if ($year->is_active)
                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
              @else
                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Nonaktif</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
              @if (!$year->is_active)
                <form action="{{ route('academic.academic-years.activate', $year->id) }}" method="POST" class="inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit"
                          class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
                    Aktifkan
                  </button>
                </form>
              @endif
              <a href="{{ route('academic.academic-years.edit', $year->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('academic.academic-years.destroy', $year->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data tahun ajaran.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex justify-between text-sm text-gray-600">
    <p>Menampilkan {{ $years->firstItem() }} - {{ $years->lastItem() }} dari {{ $years->total() }} tahun ajaran</p>
    {{ $years->appends(request()->query())->onEachSide(1)->links() }}
  </div>
@endsection
