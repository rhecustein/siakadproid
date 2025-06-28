@extends('layouts.canteen-admin')

@section('title', 'Edit Produk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl mx-auto">
  {{-- Form --}}
  <form action="{{ route('canteen.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow">
    @csrf
    @method('PUT')

    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Data Produk</h2>

    {{-- Nama --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
      <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required oninput="updatePreview()"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- SKU & Barcode --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">SKU</label>
        <input type="text" value="{{ $product->sku }}" disabled
          class="mt-1 block w-full rounded-md bg-gray-100 border border-gray-300 shadow-sm text-gray-600 cursor-not-allowed">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Barcode</label>
        <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" oninput="updatePreview()"
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
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" {{ $product->category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
        @error('category_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="canteen_id" class="block text-sm font-medium text-gray-700">Kantin</label>
        <select name="canteen_id" id="canteen_id" required
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          @foreach ($canteens as $id => $name)
            <option value="{{ $id }}" {{ $product->canteen_id == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
        @error('canteen_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Harga & Unit --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
        <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price) }}"
          required oninput="updatePreview()"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('price') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="unit" class="block text-sm font-medium text-gray-700">Satuan</label>
        <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" required oninput="updatePreview()"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('unit') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Deskripsi --}}
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
      <textarea name="description" id="description" rows="3"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
      @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Upload Foto Baru --}}
    <div>
      <label for="photo" class="block text-sm font-medium text-gray-700">Ganti Foto Produk</label>
      <input type="file" name="photo" id="photo" accept="image/*" onchange="previewImage(event)"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm">
      <img id="photoPreview" class="w-32 h-32 mt-3 object-cover border rounded {{ $product->photo_path ? '' : 'hidden' }}"
        src="{{ $product->photo_path ? asset('storage/' . $product->photo_path) : '' }}">
    </div>

    {{-- Status --}}
    <div class="flex items-center space-x-2 mt-2">
      <input type="checkbox" name="is_active" id="is_active" value="1"
        {{ $product->is_active ? 'checked' : '' }}
        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end pt-4 gap-2">
      <a href="{{ route('canteen.products.index') }}"
         class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</a>
      <button type="submit"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
    </div>
  </form>

  {{-- Preview Panel --}}
  <div class="bg-white p-6 rounded-xl shadow space-y-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Preview Produk</h2>

    <img id="previewImageOutput" class="w-full h-48 object-cover border rounded {{ $product->photo_path ? '' : 'hidden' }}"
         src="{{ $product->photo_path ? asset('storage/' . $product->photo_path) : '' }}">
    <h3 id="previewName" class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
    <p id="previewBarcode" class="text-sm text-gray-600">Barcode: {{ $product->barcode ?? '-' }}</p>
    <p id="previewPrice" class="text-xl font-bold text-blue-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p class="text-sm text-gray-600">Satuan: <span id="previewUnit">{{ $product->unit }}</span></p>
  </div>
</div>

<script>
  function updatePreview() {
    document.getElementById('previewName').innerText = document.getElementById('name').value || 'Nama Produk';
    document.getElementById('previewBarcode').innerText = 'Barcode: ' + (document.getElementById('barcode').value || '-');
    document.getElementById('previewPrice').innerText = 'Rp ' + (document.getElementById('price').value || '0');
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
