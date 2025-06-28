@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Pembelian Baru</h1>

  <form action="{{ route('canteen.purchases.store') }}" method="POST">
    @csrf

    <!-- Informasi Umum -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-white border p-4 rounded shadow">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
        <select name="supplier_id" required class="w-full border px-3 py-2 rounded">
          <option value="">-- Pilih Supplier --</option>
          @foreach ($suppliers as $supplier)
          <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian</label>
        <input type="date" name="tanggal" required class="w-full border px-3 py-2 rounded" value="{{ date('Y-m-d') }}">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
        <input type="text" name="note" class="w-full border px-3 py-2 rounded" placeholder="Keterangan tambahan...">
      </div>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white border rounded shadow p-4 mb-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-3">Daftar Produk</h2>
      <table class="min-w-full text-sm" id="productTable">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2 text-left">Produk</th>
            <th class="p-2 text-center">Qty</th>
            <th class="p-2 text-center">Harga Satuan</th>
            <th class="p-2 text-center">Subtotal</th>
            <th class="p-2"></th>
          </tr>
        </thead>
        <tbody>
          <!-- baris produk dinamis -->
        </tbody>
      </table>

      <button type="button" onclick="addRow()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        + Tambah Produk
      </button>
    </div>

    <!-- Total & Tombol -->
    <div class="flex items-center justify-between">
      <div class="text-xl font-bold text-gray-800">Total: <span id="grandTotal">Rp 0</span></div>
      <div class="flex gap-3">
        <button type="submit" name="action" value="draft" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">
          💾 Simpan Draft
        </button>
        <button type="submit" name="action" value="approve" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          🚀 Kirim untuk Approval
        </button>
      </div>
    </div>
  </form>
</div>

<!-- Script Produk Dinamis -->
<script>
  let productIndex = 0;
  const products = @json($products);

  function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
  }

  function addRow() {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td class="p-2">
        <select name="items[${productIndex}][product_id]" required class="w-full border rounded">
          <option value="">-- Pilih Produk --</option>
          ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
        </select>
      </td>
      <td class="p-2 text-center">
        <input type="number" name="items[${productIndex}][quantity]" value="1" min="1" class="qty border px-2 py-1 rounded w-20 text-center" onchange="updateTotal()" required>
      </td>
      <td class="p-2 text-center">
        <input type="number" name="items[${productIndex}][unit_price]" value="0" min="0" class="price border px-2 py-1 rounded w-28 text-right" onchange="updateTotal()" required>
      </td>
      <td class="p-2 text-right subtotal">Rp 0</td>
      <td class="p-2 text-center">
        <button type="button" onclick="this.closest('tr').remove(); updateTotal()" class="text-red-500 hover:text-red-700">✖</button>
      </td>
    `;
    document.querySelector('#productTable tbody').appendChild(row);
    productIndex++;
    updateTotal();
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('#productTable tbody tr').forEach(tr => {
      const qty = parseInt(tr.querySelector('.qty')?.value || 0);
      const price = parseFloat(tr.querySelector('.price')?.value || 0);
      const subtotal = qty * price;
      tr.querySelector('.subtotal').textContent = formatRupiah(subtotal);
      total += subtotal;
    });
    document.getElementById('grandTotal').textContent = formatRupiah(total);
  }
</script>
@endsection
