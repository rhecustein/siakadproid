@extends('layouts.canteen')

@section('title', 'POS Canteen')

@section('content')
<pre>{{ var_dump($categories ?? 'no $categories passed') }}</pre>
<main class="grid grid-cols-1 lg:grid-cols-[2fr_1.3fr] gap-4 min-h-[calc(100vh-4rem)] p-4">
  {{-- Produk Section --}}
  <section class="bg-white p-4 rounded-lg shadow border overflow-y-auto">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
      <input type="text" placeholder="Cari produk..." class="px-3 py-2 border border-gray-300 rounded-lg w-64 focus:ring focus:ring-blue-200">
    </div>
    @include('canteen.partials.product')
  </section>
  {{-- Checkout Section --}}
  @include('canteen.partials.checkout')
</main>

{{-- Modal Pembayaran --}}
<div id="modal-bayar" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Pembayaran</h3>
    <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
    <select id="paymentMethod" class="w-full mb-4 px-3 py-2 border border-gray-300 rounded">
      <option value="cash">Tunai</option>
      <option value="qris">QRIS</option>
    </select>
    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
    <input type="number" id="payAmount" class="w-full mb-4 px-3 py-2 border border-gray-300 rounded" placeholder="Masukkan jumlah bayar">
    <div class="flex justify-end gap-2">
      <button data-action="close-modal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
      <button id="confirmPaymentBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Konfirmasi</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let currentCustomer = null; // Untuk menyimpan data dari fingerprint

function formatRupiah(value) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
  }).format(value);
}

function addToCart(id, name, price) {
  const existing = cart.find(item => item.id === id);
  if (existing) {
    existing.qty++;
    existing.total = existing.qty * existing.price;
  } else {
    cart.push({ id, name, price, qty: 1, total: price });
  }
  renderCart();
}

function renderCart() {
  const table = document.getElementById('checkoutTable');
  const totalEl = document.getElementById('checkoutTotal');
  table.innerHTML = '';
  let total = 0;

  cart.forEach((item, index) => {
    total += item.total;
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.name}</td>
      <td>${item.qty}</td>
      <td>${formatRupiah(item.price)}</td>
      <td>${formatRupiah(item.total)}</td>
      <td>
        <button onclick="removeFromCart(${index})" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">
          X
        </button>
      </td>
    `;
    table.appendChild(row);
  });

  totalEl.textContent = formatRupiah(total);

  // Jika customer fingerprint sedang aktif → update ulang UI saldo
  if (currentCustomer) updateCustomerInfoDisplay();
}

function removeFromCart(index) {
  cart.splice(index, 1);
  renderCart();
}

function resetCart() {
  cart = [];
  currentCustomer = null;
  renderCart();
  hideCustomerInfo();
}

function openModal() {
  document.getElementById('modal-bayar').classList.remove('hidden');
  document.getElementById('modal-bayar').classList.add('flex');
}

function closeModal() {
  document.getElementById('modal-bayar').classList.add('hidden');
  document.getElementById('modal-bayar').classList.remove('flex');
}

function closeSuccessModal() {
  const modal = document.getElementById('modal-success');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function confirmPayment() {
  if (cart.length === 0) {
    alert('Keranjang kosong!');
    return;
  }

  const method = document.getElementById('paymentMethod').value;
  const payAmount = parseInt(document.getElementById('payAmount').value);
  const total = cart.reduce((acc, item) => acc + item.total, 0);

  if (isNaN(payAmount) || payAmount < total) {
    alert('Pembayaran tidak valid.');
    return;
  }

  // Transaksi sukses
  closeModal();

  setTimeout(() => {
    document.getElementById('modal-success').classList.remove('hidden');
    document.getElementById('modal-success').classList.add('flex');
    resetCart();
  }, 400);
}

// ========== Fingerprint ==========

function useFingerprintCustomer() {
  const data = window.currentCustomer;
  if (!data) return alert('Data tidak valid.');

  currentCustomer = data;
  closeFingerprintModal();
  updateCustomerInfoDisplay();
}

function updateCustomerInfoDisplay() {
  const section = document.getElementById('selectedCustomerInfo');
  const nameEl = document.getElementById('infoCustomerName');
  const saldoEl = document.getElementById('infoCustomerSaldo');
  const tagihanEl = document.getElementById('infoCustomerTagihan');
  const sisaEl = document.getElementById('infoCustomerSisa');

  const total = cart.reduce((sum, item) => sum + item.total, 0);
  const saldo = currentCustomer.saldo;
  const sisa = saldo - total;

  section.classList.remove('hidden');
  nameEl.textContent = currentCustomer.name;
  saldoEl.textContent = formatRupiah(saldo);
  tagihanEl.textContent = formatRupiah(total);
  sisaEl.textContent = formatRupiah(sisa >= 0 ? sisa : 0);

  if (sisa < 0) {
    alert(`⚠️ Saldo ${currentCustomer.name} tidak cukup untuk pembayaran ini.`);
  }
}

function hideCustomerInfo() {
  const section = document.getElementById('selectedCustomerInfo');
  section?.classList.add('hidden');
}

function closeFingerprintModal() {
  document.getElementById('fingerprintModal').classList.add('hidden');
}

// ========== Event Listeners ==========

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('cancelBtn')?.addEventListener('click', () => {
    if (confirm('Yakin batal?')) resetCart();
  });

  document.querySelector('[data-modal-target="bayar"]')?.addEventListener('click', openModal);
  document.querySelector('[data-action="close-modal"]')?.addEventListener('click', closeModal);
  document.getElementById('confirmPaymentBtn')?.addEventListener('click', confirmPayment);
});
</script>

@endpush
