@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
  <div>
    <h2 class="text-2xl font-bold text-green-700">Inventory Types</h2>
    <p class="text-sm text-gray-500">List of all registered inventory types.</p>
  </div>
  <div class="flex flex-wrap gap-2">
    <a href="{{ route('facility.inventories.index') }}"
       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
      ← Back to Inventory
    </a>
    <a href="{{ route('facility.inventory-types.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
      + Add Type
    </a>
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

<form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
  <input type="text" name="search" value="{{ request('search') }}"
         placeholder="Search type name..."
         class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-green-500" />

  <select name="electronic" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
    <option value="">All Types</option>
    <option value="1" {{ request('electronic') === '1' ? 'selected' : '' }}>Electronic</option>
    <option value="0" {{ request('electronic') === '0' ? 'selected' : '' }}>Non-Electronic</option>
  </select>

  <button type="submit"
          class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
    Filter
  </button>
</form>

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3">Is Electronic</th>
        <th class="px-6 py-3">Economic Life</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($types as $index => $type)
        <tr class="hover:bg-green-50 transition">
          <td class="px-6 py-3">{{ $index + 1 }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $type->name }}</td>
          <td class="px-6 py-3">{{ $type->is_electronic ? 'Yes' : 'No' }}</td>
          <td class="px-6 py-3">{{ $type->economic_life ?? '—' }}</td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('facility.inventory-types.edit', $type->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
              Edit
            </a>
            <form action="{{ route('facility.inventory-types.destroy', $type->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure to delete this type?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-6 py-4 text-center text-gray-500">No inventory types found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 text-sm text-yellow-800 rounded">
  <p class="font-semibold mb-1">Apa itu Economic Life?</p>
  <p>
    <strong>Economic Life</strong> atau umur ekonomis adalah estimasi lamanya suatu aset atau barang dapat digunakan secara produktif dan ekonomis. Umur ini penting dalam sistem manajemen inventaris karena:
  </p>
  <ul class="mt-2 list-disc pl-5 space-y-1">
    <li>Digunakan untuk perhitungan penyusutan aset tiap tahun.</li>
    <li>Menjadi indikator kapan barang perlu diganti atau dihapus dari daftar aset aktif.</li>
    <li>Membantu perencanaan anggaran jangka panjang untuk pengadaan kembali.</li>
    <li>Barang elektronik biasanya memiliki umur lebih pendek (3–5 tahun), sedangkan furniture bisa mencapai 10 tahun atau lebih.</li>
  </ul>
  <p class="mt-2">Semakin akurat nilai economic life yang dimasukkan, semakin baik data inventaris dalam mencerminkan kondisi nyata aset yang dimiliki lembaga.</p>
</div>
@endsection
