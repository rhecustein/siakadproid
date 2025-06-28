// kantin-pos.js - Logika interaktif POS Kantin

const products = [
  { id: 'p1', name: 'Espresso', price: 15000 },
  { id: 'p2', name: 'Latte', price: 18000 },
  { id: 'p3', name: 'Pulpen', price: 7000 },
];

const cart = [];

function formatRupiah(value) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

function renderProducts() {
  const container = document.getElementById('productList');
  if (!container) return;
  container.innerHTML = '';
  products.forEach(p => {
    const div = document.createElement('div');
    div.className = 'product-card';
    div.innerHTML = `
      <h3 style="font-weight: bold; margin-bottom: 0.5rem;">${p.name}</h3>
      <p>${formatRupiah(p.price)}</p>
      <button class="btn btn-green" data-id="${p.id}" style="margin-top: 0.5rem;">Tambah</button>
    `;
    container.appendChild(div);
  });
  container.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('click', () => {
      addToCart(btn.dataset.id);
    });
  });
}

function addToCart(productId) {
  const product = products.find(p => p.id === productId);
  const found = cart.find(item => item.id === productId);
  if (found) {
    found.qty += 1;
  } else {
    cart.push({ ...product, qty: 1 });
  }
  renderCart();
}

function renderCart() {
  const tbody = document.getElementById('checkoutTable');
  const totalDisplay = document.getElementById('checkoutTotal');
  if (!tbody || !totalDisplay) return;
  tbody.innerHTML = '';
  let total = 0;

  cart.forEach(item => {
    const row = document.createElement('tr');
    const itemTotal = item.qty * item.price;
    total += itemTotal;
    row.innerHTML = `
      <td>${item.name}</td>
      <td>${item.qty}</td>
      <td>${formatRupiah(item.price)}</td>
      <td>${formatRupiah(itemTotal)}</td>
      <td><button class="btn btn-red" data-remove="${item.id}">X</button></td>
    `;
    tbody.appendChild(row);
  });

  tbody.querySelectorAll('[data-remove]').forEach(btn => {
    btn.addEventListener('click', () => {
      const index = cart.findIndex(i => i.id === btn.dataset.remove);
      if (index > -1) cart.splice(index, 1);
      renderCart();
    });
  });

  totalDisplay.textContent = formatRupiah(total);
}

function setupModal() {
  const modal = document.getElementById('modal-bayar');
  document.querySelectorAll('[data-modal-target="bayar"]').forEach(btn => {
    btn.addEventListener('click', () => modal.style.display = 'flex');
  });
  document.querySelectorAll('[data-action="close-modal"]').forEach(btn => {
    btn.addEventListener('click', () => modal.style.display = 'none');
  });
  const payBtn = document.getElementById('confirmPaymentBtn');
  if (payBtn) {
    payBtn.addEventListener('click', () => {
      alert('Transaksi Berhasil!');
      cart.length = 0;
      renderCart();
      modal.style.display = 'none';
    });
  }
}

function setupUI() {
  const cancelBtn = document.getElementById('cancelBtn');
  if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
      if (confirm('Batalkan transaksi ini?')) {
        cart.length = 0;
        renderCart();
      }
    });
  }

  const fullscreenToggle = document.getElementById('fullscreenToggle');
  if (fullscreenToggle) {
    fullscreenToggle.addEventListener('click', () => {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      } else {
        document.exitFullscreen();
      }
    });
  }
}

window.addEventListener('DOMContentLoaded', () => {
  renderProducts();
  renderCart();
  setupModal();
  setupUI();
});
