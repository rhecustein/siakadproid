@extends('layouts.canteen-admin')

@section('title', 'Manajemen Produk')

@section('content')
  <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
  <h2 class="text-2xl font-semibold text-gray-800">Produk Kantin</h2>
  <div class="flex gap-2">
    <a href="{{ route('canteen.categories.index') }}"
       class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
      Kategori Produk
    </a>
    <a href="{{ route('canteen.products.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
      + Tambah Produk
    </a>
  </div>
</div>


  {{-- Filter Form --}}
  <form method="GET" action="{{ route('canteen.products.index') }}" class="mb-6 bg-white p-4 rounded-xl shadow flex flex-wrap gap-4 items-end border">
    <div class="w-full sm:w-1/4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
      <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm">
        <option value="">Semua Kategori</option>
        @foreach ($allCategories as $id => $name)
          <option value="{{ $id }}" @selected(request('category') == $id)>{{ $name }}</option>
        @endforeach
      </select>
    </div>
    <div class="w-full sm:w-1/3">
      <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / SKU</label>
      <input type="text" name="search" value="{{ request('search') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Contoh: susu, PENS001" />
    </div>
    <div class="flex gap-2 mt-2">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Terapkan</button>
      <a href="{{ route('canteen.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Reset</a>
    </div>
  </form>

  {{-- Total --}}
  <p class="text-sm text-gray-500 mb-4">
    Menampilkan <span class="font-medium">{{ $products->count() }}</span> produk dari total <span class="font-medium">{{ $total }}</span> data.
  </p>

  {{-- Tabel Produk --}}
  <div class="overflow-x-auto bg-white rounded-xl shadow border">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100 sticky top-0 z-10">
        <tr>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">#</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Kategori</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Harga</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Stok</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Unit</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Store</th>
          <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
          <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse ($products as $i => $product)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">{{ $i + 1 }}</td>
            <td class="px-4 py-3 font-medium text-gray-900">
              {{ $product->name }}
              <div class="text-xs text-gray-500">{{ $product->sku }}</div>
              @if ($product->barcode)
                <div class="text-[10px] text-gray-400 italic">Barcode: {{ $product->barcode }}</div>
              @endif
            </td>
            <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
            <td class="px-4 py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td class="px-4 py-3">
              {{ $product->stock }}
              @if ($product->stock <= $product->reorder_point)
                <span class="ml-1 text-xs text-red-500 font-medium">(Low)</span>
              @endif
            </td>
            <td class="px-4 py-3">{{ $product->unit }}</td>
            <td class="px-4 py-3">{{ $product->canteen->name ?? '-' }}</td>
            <td class="px-4 py-3">
              @if ($product->is_active)
                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Aktif</span>
              @else
                <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">Nonaktif</span>
              @endif
            </td>
            <td class="px-4 py-3 text-center">
              <div class="flex justify-center gap-2">
                <a href="{{ route('canteen.products.edit', $product) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</a>
                <form action="{{ route('canteen.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center text-gray-500 py-6">Belum ada produk</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
