@php
$products = $products ?? [];
@endphp
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
  @forelse($products as $product)
    <div
      onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
      class="relative cursor-pointer bg-white border rounded-lg shadow hover:shadow-md transition p-3 flex flex-col justify-between"
    >
      {{-- Label Rekomendasi --}}
      @if($product->is_featured)
        <span class="absolute top-2 right-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow">
          ⭐ Rekomendasi
        </span>
      @endif

      {{-- Label Diskon --}}
      @if($product->discount > 0)
        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
          -{{ number_format($product->discount, 0) }}%
        </span>
      @endif

      {{-- Gambar Produk --}}
      <div class="mb-2">
        <img
          src="{{ $product->photo_path ? asset('storage/'.$product->photo_path) : asset('images/produk.png') }}"
          alt="{{ $product->name }}"
          class="w-full h-32 object-cover rounded"
        >
      </div>

      {{-- Informasi Produk --}}
      <div class="flex-1 flex flex-col justify-between space-y-1">
        <h3 class="text-sm font-semibold text-gray-800 leading-tight truncate">{{ $product->name }}</h3>
        <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500">Stok: {{ $product->stock }} {{ $product->unit }}</p>

        @if($product->category)
          <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
            {{ $product->category->name }}
          </span>
        @endif

        @if($product->stock_location)
          <span class="inline-block bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded">
            Lokasi: {{ $product->stock_location }}
          </span>
        @endif

        {{-- Tags --}}
        @if($product->tags && is_array($product->tags))
          <div class="flex flex-wrap gap-1 mt-1">
            @foreach($product->tags as $tag)
              <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded">{{ $tag }}</span>
            @endforeach
          </div>
        @endif

        {{-- Labels --}}
        @if($product->labels && is_array($product->labels))
          <div class="flex flex-wrap gap-1 mt-1">
            @foreach($product->labels as $label)
              <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $label }}</span>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  @empty
    <p class="text-center col-span-full text-gray-500 py-8">Tidak ada produk tersedia.</p>
  @endforelse
</div>
