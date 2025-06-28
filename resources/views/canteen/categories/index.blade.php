@extends('layouts.canteen-admin')

@section('title', 'Kategori Produk')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Kategori Produk</h2>
    <a href="{{ route('canteen.product_categories.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Tambah Kategori</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white shadow border rounded-xl">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">#</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
          <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($categories as $i => $category)
  <tr class="hover:bg-gray-50">
    <td class="px-4 py-3">{{ $i + 1 }}</td>
    <td class="px-4 py-3 font-medium text-gray-900">{{ $category->name }}</td>
    <td class="px-4 py-3 text-gray-700">{{ $category->description ?? '-' }}</td>
    <td class="px-4 py-3 text-center">
      <div class="flex justify-center gap-2">
        <a href="{{ route('canteen.product_categories.edit', $category->id) }}"
           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</a>
        <form action="{{ route('canteen.product_categories.destroy', $category->id) }}"
              method="POST"
              onsubmit="return confirm('Hapus kategori ini?')">
          @csrf @method('DELETE')
          <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
            Hapus
          </button>
        </form>
      </div>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="4" class="text-center py-6 text-gray-500">Belum ada kategori.</td>
  </tr>
@endforelse

      </tbody>
    </table>
  </div>
@endsection
