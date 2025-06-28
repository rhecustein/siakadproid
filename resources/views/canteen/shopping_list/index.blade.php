@extends('layouts.canteen-admin')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold text-gray-800">Pembelian Barang dari Supplier</h1>
    <a href="{{ route('canteen.shopping-lists.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      + Tambah Pembelian
    </a>
  </div>

  <!-- Tab Navigasi -->
  <div class="mb-6">
    @php
      $status = request('status', 'approved');
    @endphp
    <div class="flex gap-3 text-sm font-medium">
      <a href="{{ route('canteen.shopping-lists.index', ['status' => 'approved']) }}"
         class="px-3 py-2 rounded {{ $status == 'approved' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        📦 Menunggu Diterima
      </a>
      <a href="{{ route('canteen.shopping-lists.index', ['status' => 'received']) }}"
         class="px-3 py-2 rounded {{ $status == 'received' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        ✅ Riwayat Pembelian
      </a>
      <a href="{{ route('canteen.shopping-lists.index', ['status' => 'draft']) }}"
         class="px-3 py-2 rounded {{ $status == 'draft' ? 'bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        ✏️ Draft / Belum Disetujui
      </a>
    </div>
  </div>

  <!-- Filter -->
  <form method="GET" class="mb-4 max-w-md">
    <input type="hidden" name="status" value="{{ $status }}">
    <label class="block text-sm text-gray-600 mb-1">Filter Tanggal</label>
    <div class="flex gap-2">
      <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2 border rounded">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Filter</button>
    </div>
  </form>

  <!-- Tabel Pembelian -->
  <div class="overflow-x-auto bg-white shadow rounded border">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Supplier</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total Produk</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total Harga</th>
          <th class="px-4 py-2 text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse ($purchases as $purchase)
        <tr>
          <td class="px-4 py-2 text-sm text-gray-700">
            {{ $purchase->created_at->format('d M Y') }}
          </td>
          <td class="px-4 py-2 text-sm text-gray-800">
            {{ $purchase->supplier->name ?? '-' }}
          </td>
          <td class="px-4 py-2 text-sm text-gray-700">
            {{ $purchase->items->count() }} item
          </td>
          <td class="px-4 py-2 text-sm text-gray-800 font-semibold">
            Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
          </td>
          <td class="px-4 py-2 text-sm">
            <div class="flex gap-2 flex-wrap">
              <a href="{{ route('canteen.shopping-lists.show', $purchase->id) }}"
                 class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 text-sm text-gray-800">Detail</a>

              @if($purchase->status === 'draft')
                <a href="{{ route('canteen.shopping-lists.edit', $purchase->id) }}"
                   class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">Edit</a>
              @endif

              @if($purchase->status === 'approved')
              <form action="{{ route('canteen.shopping-lists.receive', $purchase->id) }}" method="POST"
                    onsubmit="return confirm('Yakin terima pembelian ini dan update stok?')">
                @csrf
                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                  ✅ Terima
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center px-4 py-6 text-gray-500">Tidak ada data pada kategori ini.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
