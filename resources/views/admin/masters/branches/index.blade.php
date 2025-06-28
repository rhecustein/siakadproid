@extends('layouts.app')

@section('content')
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Daftar Cabang</h2>
      <p class="text-sm text-gray-500">Semua cabang aktif yang terdaftar dalam sistem.</p>
    </div>
    <div class="flex gap-2">
    <a href="{{ route('master.branches.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Tambah Cabang
    </a>
    <a href="{{ route('master.schools.index') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      Kembali ke Sekolah
    </a>
    </div>
  </div>


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
              <a href="{{ route('master.branches.edit', $branch->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('master.branches.destroy', $branch->id) }}" method="POST" class="inline"
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

  <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
    <p>
      Menampilkan {{ $branches->firstItem() }} sampai {{ $branches->lastItem() }} dari total {{ $branches->total() }} cabang
    </p>
    {{ $branches->appends(request()->query())->onEachSide(1)->links() }}
  </div>
@endsection
