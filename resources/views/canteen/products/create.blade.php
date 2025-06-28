@extends('layouts.canteen-admin')

@section('title', 'Tambah Produk Kantin')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl mx-auto">
  {{-- Form --}}
  <form action="{{ route('canteen.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow">
    @csrf
    <h2 class="text-xl font-bold text-gray-800 mb-4">Form Produk</h2>

    {{-- Nama Produk --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
      <input type="text" name="name" id="name" value="{{ old('name') }}" required oninput="updatePreview()"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- SKU & Barcode --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('sku') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}" oninput="updatePreview()"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('barcode') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Kategori & Kantin --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select name="category_id" id="category_id" required
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">Pilih Kategori</option>
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
        @error('category_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="canteen_id" class="block text-sm font-medium text-gray-700">Kantin</label>
        <select name="canteen_id" id="canteen_id" required
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">Pilih Kantin</option>
          @foreach ($canteens as $id => $name)
            <option value="{{ $id }}" {{ old('canteen_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
        @error('canteen_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Harga & Stok --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required oninput="updatePreview()"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('price') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="stock" class="block text-sm font-medium text-gray-700">Stok Awal</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" oninput="updatePreview()"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('stock') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Unit --}}
    <div>
      <label for="unit" class="block text-sm font-medium text-gray-700">Satuan</label>
      <input type="text" name="unit" id="unit" value="{{ old('unit', 'pcs') }}" required oninput="updatePreview()"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      @error('unit') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
      <textarea name="description" id="description" rows="3"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
      @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Upload Foto --}}
    <div>
      <label for="photo" class="block text-sm font-medium text-gray-700">Foto Produk</label>
      <input type="file" name="photo" id="photo" accept="image/*" onchange="previewImage(event)"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm">
      <img id="photoPreview" class="w-32 h-32 mt-3 object-cover border rounded hidden">
    </div>

    {{-- Status --}}
    <div class="flex items-center space-x-2 mt-2">
      <input type="checkbox" name="is_active" id="is_active" value="1"
        {{ old('is_active', true) ? 'checked' : '' }}
        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end pt-4 gap-2">
      <a href="{{ route('canteen.products.index') }}"
         class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</a>
      <button type="submit"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
    </div>
  </form>

  {{-- Preview Panel --}}
  <div class="bg-white p-6 rounded-xl shadow space-y-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Preview Produk</h2>

    <img id="previewImageOutput" class="w-full h-48 object-cover border rounded hidden">
    <h3 id="previewName" class="text-lg font-semibold text-gray-900">Nama Produk</h3>
    <p id="previewBarcode" class="text-sm text-gray-600">Barcode: -</p>
    <p id="previewPrice" class="text-xl font-bold text-blue-600 mt-2">Rp 0</p>
    <p class="text-sm text-gray-600">Stok: <span id="previewStock">0</span> <span id="previewUnit">pcs</span></p>
  </div>
</div>

<script>
  function updatePreview() {
    document.getElementById('previewName').innerText = document.getElementById('name').value || 'Nama Produk';
    document.getElementById('previewBarcode').innerText = 'Barcode: ' + (document.getElementById('barcode').value || '-');
    document.getElementById('previewPrice').innerText = 'Rp ' + (document.getElementById('price').value || '0');
    document.getElementById('previewStock').innerText = document.getElementById('stock').value || '0';
    document.getElementById('previewUnit').innerText = document.getElementById('unit').value || 'pcs';
  }

  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => {
      const preview = document.getElementById('photoPreview');
      const output = document.getElementById('previewImageOutput');
      preview.src = reader.result;
      output.src = reader.result;
      preview.classList.remove('hidden');
      output.classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endsection
