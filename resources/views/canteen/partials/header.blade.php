<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
  {{-- Filter Kategori + Search --}}
  <div class="flex flex-col sm:flex-row gap-3 w-full sm:max-w-3xl">
    {{-- Kategori --}}
    <select
      name="category"
      id="categoryFilter"
      class="w-full sm:w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
    >
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
      @endforeach
    </select>

    {{-- Search Nama / Barcode / SKU --}}
    <input
      type="text"
      id="barcodeSearch"
      placeholder="Scan barcode / cari nama / SKU"
      class="w-full sm:flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
    />
  </div>

  {{-- Filter Tambahan + Tombol --}}
  <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
    {{-- Urutkan --}}
    <select
      id="sortBy"
      class="px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
    >
      <option value="">Urutkan</option>
      <option value="name_asc">Nama A-Z</option>
      <option value="name_desc">Nama Z-A</option>
      <option value="price_asc">Harga Terendah</option>
      <option value="price_desc">Harga Tertinggi</option>
    </select>

    {{-- Filter Unggulan --}}
    <label class="inline-flex items-center gap-2 text-sm">
      <input type="checkbox" id="filterFeatured" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      <span>Unggulan</span>
    </label>

    {{-- Tombol Reset --}}
    <button
      type="button"
      onclick="resetCart()"
      class="px-4 py-2 bg-yellow-400 text-white text-sm rounded-md hover:bg-yellow-500 transition"
    >
      Kosongkan
    </button>

    {{-- Tombol Batal --}}
    <button
      type="button"
      id="cancelBtn"
      class="px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition"
    >
      Batal
    </button>
  </div>
</div>
