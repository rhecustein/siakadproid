@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
  <div>
    <h2 class="text-2xl font-bold text-yellow-700">Inventory Conditions</h2>
    <p class="text-sm text-gray-500">List of all registered inventory conditions.</p>
  </div>
  <div class="flex flex-wrap gap-2">
    <a href="{{ route('facility.inventories.index') }}"
       class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
      ← Back to Inventory
    </a>
    <a href="{{ route('facility.inventory-conditions.create') }}"
       class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-600 transition">
      + Add Condition
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

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3">Description</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($conditions as $index => $condition)
        <tr class="hover:bg-yellow-50 transition">
          <td class="px-6 py-3">{{ $index + 1 }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $condition->name }}</td>
          <td class="px-6 py-3">{{ $condition->description ?? '—' }}</td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('facility.inventory-conditions.edit', $condition->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200">
              Edit
            </a>
            <form action="{{ route('facility.inventory-conditions.destroy', $condition->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure to delete this condition?')">
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
          <td colspan="4" class="px-6 py-4 text-center text-gray-500">No inventory conditions found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 text-sm text-yellow-800 rounded">
  <p class="font-semibold mb-1">Apa itu Inventory Condition?</p>
  <p>
    <strong>Inventory Condition</strong> adalah status fisik atau operasional suatu barang atau aset dalam sistem inventaris.
    Penentuan kondisi membantu lembaga untuk:
  </p>
  <ul class="mt-2 list-disc pl-5 space-y-1">
    <li>Mengetahui apakah suatu barang masih layak digunakan atau perlu diganti.</li>
    <li>Menjadi dasar penjadwalan perbaikan atau penghapusan aset.</li>
    <li>Menyusun laporan kondisi aset secara akurat dan transparan.</li>
  </ul>
  <p class="mt-2">Kategori umum mencakup kondisi <strong>baik</strong>, <strong>rusak ringan</strong>, <strong>rusak berat</strong>, dan <strong>hilang</strong>. Penyesuaian dapat dilakukan sesuai kebutuhan institusi.</p>
</div>
@endsection
