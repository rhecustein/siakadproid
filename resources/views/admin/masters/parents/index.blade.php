@extends('layouts.app')

@section('content')
<div class="mb-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div class="mb-4 sm:mb-0">
      <h2 class="text-2xl font-bold text-blue-700">Daftar Orang Tua / Wali</h2>
      <p class="text-sm text-gray-500">Data orang tua atau wali yang terhubung dengan siswa.</p>
    </div>
    <div class="flex items-center gap-2">
      <a href="#" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-200">Import</a>
      <a href="#" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-200">Export</a>
      <a href="{{ route('core.parents.create') }}"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Orang Tua
      </a>
    </div>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
      <p class="text-sm text-gray-600">Total Orang Tua</p>
      <p class="text-2xl font-bold text-blue-700">{{ $parents->total() }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
      <p class="text-sm text-gray-600">Status Aktif</p>
      <p class="text-2xl font-bold text-green-600">{{ $parents->filter(fn($p) => $p->is_active)->count() }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
      <p class="text-sm text-gray-600">Laki-laki</p>
      <p class="text-2xl font-bold text-gray-800">{{ $parents->filter(fn($p) => $p->gender === 'L')->count() }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
      <p class="text-sm text-gray-600">Perempuan</p>
      <p class="text-2xl font-bold text-pink-600">{{ $parents->filter(fn($p) => $p->gender === 'P')->count() }}</p>
    </div>
  </div>

  @if (session('success'))
  <div class="mt-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
    <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
  </div>
  @endif

  <form method="GET" action="{{ route('core.parents.index') }}" class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded-xl shadow">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no HP"
           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

    <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Gender</option>
      <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
      <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>

    <select name="relationship" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Hubungan</option>
      <option value="ayah" {{ request('relationship') == 'ayah' ? 'selected' : '' }}>Ayah</option>
      <option value="ibu" {{ request('relationship') == 'ibu' ? 'selected' : '' }}>Ibu</option>
      <option value="wali" {{ request('relationship') == 'wali' ? 'selected' : '' }}>Wali</option>
    </select>

    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">Semua Status</option>
      <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
      <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>

    <button type="submit"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition self-end">
      Terapkan Filter
    </button>
  </form>
</div>

<div class="bg-white shadow rounded-xl overflow-x-auto mt-6">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Nama</th>
        <th class="px-6 py-3">Jenis Kelamin</th>
        <th class="px-6 py-3">Hubungan</th>
        <th class="px-6 py-3">Email</th>
        <th class="px-6 py-3">No HP</th>
        <th class="px-6 py-3">Saldo</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($parents as $index => $parent)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ ($parents->currentPage() - 1) * $parents->perPage() + $index + 1 }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $parent->name }}</td>
          <td class="px-6 py-3">
            {{ $parent->gender === 'L' ? 'Laki-laki' : ($parent->gender === 'P' ? 'Perempuan' : '—') }}
          </td>
          <td class="px-6 py-3 capitalize">{{ $parent->relationship ?? '—' }}</td>
          <td class="px-6 py-3">{{ $parent->email ?? '—' }}</td>
          <td class="px-6 py-3">{{ $parent->phone ?? '—' }}</td>
          <td class="px-6 py-3">Rp {{ number_format($parent->balance ?? 0, 0, ',', '.') }}</td>
          <td class="px-6 py-3">
            @if ($parent->is_active)
              <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
            @else
              <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Nonaktif</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
            <a href="{{ route('core.parents.edit', $parent->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="{{ route('core.parents.destroy', $parent->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus data orang tua ini?')">
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
          <td colspan="9" class="px-6 py-4 text-center text-gray-500">Belum ada data orang tua.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <div class="px-6 py-4">{{ $parents->withQueryString()->links() }}</div>
</div>
@endsection
