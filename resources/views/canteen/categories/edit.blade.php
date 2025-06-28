@extends('layouts.canteen-admin')

@section('title', 'Edit Kategori Produk')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Kategori Produk</h2>

  <form action="{{ route('canteen.product_categories.update', $canteenProductCategory) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- Nama Kategori --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
      <input type="text" name="name" id="name" value="{{ old('name', $canteenProductCategory->name) }}" required
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
      <textarea name="description" id="description" rows="3"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $canteenProductCategory->description) }}</textarea>
      @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end gap-2">
      <a href="{{ route('canteen.product_categories.index') }}"
         class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</a>
      <button type="submit"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Perbarui</button>
    </div>
  </form>
</div>
@endsection
