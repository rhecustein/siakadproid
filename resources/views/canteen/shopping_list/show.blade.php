@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pembelian dari Supplier</h1>
    <p class="text-gray-600">Kode Pembelian: #{{ $purchase->id }}</p>
  </div>

  <!-- Informasi Umum -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 bg-white border p-4 rounded shadow">
    <div>
      <p class="text-sm text-gray-500">Tanggal Pembelian</p>
      <p class="text-lg text-gray-800 font-medium">{{ $purchase->created_at->format('d M Y') }}</p>
    </div>
    <div>
      <p class="text-sm text-gray-500">Supplier</p>
      <p class="text-lg text-gray-800 font-medium">{{ $purchase->supplier->name ?? '-' }}</p>
    </div>
    <div>
      <p class="text-sm text-gray-500">Status</p>
      <span class="inline-block px-3 py-1 text-sm rounded-full font-semibold
        {{ $purchase->status === 'received' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
        {{ ucfirst($purchase->status) }}
      </span>
    </div>
    <div>
      <p class="text-sm text-gray-500">Tanggal Diterima</p>
      <p class="text-lg text-gray-800 font-medium">
        {{ $purchase->received_date ? \Carbon\Carbon::parse($purchase->received_date)->format('d M Y') : '-' }}
      </p>
    </div>
  </div>

  <!-- Tabel Item -->
  <div class="overflow-x-auto bg-white rounded shadow border">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Produk</th>
          <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Qty</th>
          <th class="px-4 py-2 text-right text-sm font-semibold text-gray-700">Harga Satuan</th>
          <th class="px-4 py-2 text-right text-sm font-semibold text-gray-700">Subtotal</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach ($purchase->items as $item)
        <tr>
          <td class="px-4 py-2 text-sm text-gray-800">{{ $item->product?->name ?? '[Produk tidak ditemukan]' }}</td>
          <td class="px-4 py-2 text-sm text-center">{{ $item->quantity }}</td>
          <td class="px-4 py-2 text-sm text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
          <td class="px-4 py-2 text-sm text-right font-semibold text-gray-800">
            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700">Total</td>
          <td class="px-4 py-3 text-right font-bold text-blue-600">
            Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="mt-6">
    <a href="{{ route('canteen.shopping_list') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
      ← Kembali ke Daftar Belanja
    </a>
  </div>
</div>
@endsection
