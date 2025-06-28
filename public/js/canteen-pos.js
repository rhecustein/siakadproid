// canteen-pos.js

let cart = [];

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
    const row = document.createElement('tr');
    total += item.total;
    row.innerHTML = `
      <td>${item.name}</td>
      <td>${item.qty}</td>
      <td>${formatRupiah(item.price)}</td>
      <td>${formatRupiah(item.total)}</td>
      <td><button class="btn btn-red" onclick="removeFromCart(${index})">X</button></td>
    `;
    table.appendChild(row);
  });

  totalEl.textContent = formatRupiah(total);
}

function removeFromCart(index) {
  cart.splice(index, 1);
  renderCart();
}

function resetCart() {
  cart = [];
  renderCart();
}

function openModal() {
  document.getElementById('modal-bayar').style.display = 'flex';
}

function closeModal() {
  document.getElementById('modal-bayar').style.display = 'none';
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

  alert('Transaksi berhasil!');
  closeModal();
  resetCart();
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('cancelBtn')?.addEventListener('click', () => {
    if (confirm('Yakin batal?')) resetCart();
  });

  document.querySelector('[data-modal-target="bayar"]')?.addEventListener('click', openModal);
  document.querySelector('[data-action="close-modal"]')?.addEventListener('click', closeModal);
  document.getElementById('confirmPaymentBtn')?.addEventListener('click', confirmPayment);
});
