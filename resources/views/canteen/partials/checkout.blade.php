<section class="bg-white p-4 rounded-lg shadow border flex flex-col justify-between h-full">
  <div class="flex-1 overflow-y-auto space-y-3">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Keranjang</h2>

  {{-- Pilihan Tipe Customer --}}
  <div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Customer</label>

    <div id="customerType" class="grid grid-cols-2 gap-3">
      @foreach ([
        'santri' => 'Santri / Siswa',
        'wali' => 'Wali Santri',
        'staff' => 'Pejuang / Staff',
        'umum' => 'Customer Umum'
      ] as $val => $label)
        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:shadow-sm transition relative">
          <input type="radio" name="customer_type" value="{{ $val }}"
                class="peer hidden" onchange="handleCustomerType(this.value)">
          <div class="flex-1">
            <p class="font-medium text-gray-800 peer-checked:text-blue-600">{{ $label }}</p>
            <p class="text-xs text-gray-500">
              {{ $val === 'umum' ? 'Tanpa fingerprint' : 'Bisa scan fingerprint' }}
            </p>
          </div>
          <div class="w-4 h-4 border-2 border-gray-400 rounded-full peer-checked:border-blue-600 peer-checked:bg-blue-600"></div>
        </label>
      @endforeach
    </div>
  </div>

    {{-- Nama customer baru --}}
    <div id="newCustomerForm" class="hidden mt-2">
      <label class="block text-sm font-medium text-gray-700">Nama Santri/Siswa</label>
      <input type="text" id="customerName" class="w-full px-3 py-2 border rounded" placeholder="Nama customer umum">
    </div>

    {{-- Item List --}}
    <div id="checkoutList" class="space-y-3 mt-4"></div>
     {{-- Metode Pembayaran --}}
    <div id="paymentOptions" class="mt-4 space-y-2 hidden">
      <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
      <select id="paymentMethod" class="w-full px-3 py-2 border rounded">
        {{-- Akan diisi secara dinamis --}}
      </select>
    </div>
    
    {{-- Tombol scan fingerprint --}}
    <div id="scanSection" class="hidden">
      <button onclick="scanFingerprint()" class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
        Scan Fingerprint
      </button>
    </div>

    <!-- Info Customer -->
  <div id="selectedCustomerInfo" class="hidden border p-4 rounded bg-gray-50 space-y-2">
    <div class="flex justify-between items-center">
      <p class="text-gray-700 font-medium">Nama</p>
      <p id="infoCustomerName" class="text-right text-gray-900 font-semibold"></p>
    </div>
    <div class="flex justify-between items-center">
      <p class="text-gray-700 font-medium">Saldo</p>
      <p id="infoCustomerSaldo" class="text-right text-green-600 font-bold"></p>
    </div>
    <div class="flex justify-between items-center">
      <p class="text-gray-700 font-medium">Total Tagihan</p>
      <p id="infoCustomerTagihan" class="text-right text-blue-600 font-bold"></p>
    </div>
    <div class="flex justify-between items-center">
      <p class="text-gray-700 font-medium">Sisa Saldo</p>
      <p id="infoCustomerSisa" class="text-right text-orange-600 font-bold"></p>
    </div>
  </div>

    {{-- Total --}}
    <div class="mt-6 flex justify-between items-center border-t pt-4 text-xl font-bold">
      <span>Total</span>
      <span id="checkoutTotal">Rp 0</span>
    </div>
  </div>

  {{-- Tombol --}}
  <div class="mt-6 grid grid-cols-2 gap-3">
    <button
      id="cancelBtn"
      type="button"
      class="w-full py-3 text-lg font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition"
    >
      Kosongkan
    </button>

    <button
      id="payBtn"
      type="button"
      class="w-full py-3 text-lg font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition"
    >
      Bayar
    </button>
  </div>
</section>

<!-- Fingerprint Modal -->
<div id="fingerprintModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
  <div class="bg-white w-full max-w-md rounded-xl shadow-lg overflow-hidden animate-fadeInUp">
    <div class="p-5 space-y-4">
      <h2 class="text-xl font-bold text-center text-gray-800">Scan Fingerprint</h2>
      <div id="fingerprintLoader" class="flex justify-center py-8">
        <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
      </div>

      <div id="fingerprintResult" class="hidden space-y-3 text-center">
        <img id="fpPhoto" src="" alt="Foto" class="w-20 h-20 rounded-full mx-auto border object-cover">
        <h3 id="fpName" class="text-lg font-semibold text-gray-800"></h3>
        <p id="fpNis" class="text-sm text-gray-500"></p>
        <p id="fpStatus" class="text-sm text-blue-600 font-medium"></p>
        <p id="fpSaldo" class="text-lg font-bold text-green-600"></p>

        <div class="flex justify-center gap-4 mt-4">
          <button onclick="closeFingerprintModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
            Batal
          </button>
          <button onclick="useFingerprintCustomer()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Gunakan
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div id="paymentModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
  <div class="bg-white w-full max-w-md rounded-xl shadow-xl animate-fadeInUp overflow-hidden">
    <div class="p-6 space-y-4 text-center">
      <h2 class="text-2xl font-bold text-gray-800">Konfirmasi Pembayaran</h2>
      <p class="text-gray-600">Total tagihan:</p>
      <p id="modalTotal" class="text-2xl font-extrabold text-blue-600"></p>
      <p id="modalMetode" class="text-sm text-gray-500"></p>

      <div class="flex justify-center gap-4 mt-4">
        <button onclick="closePaymentModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">Batal</button>
        <button onclick="confirmPayment()" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">Bayar</button>
      </div>
    </div>
  </div>
</div>

<style>
@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeInUp {
  animation: fadeInUp 0.3s ease-out;
}
</style>


<script>
  let cart = [];

  const paymentMethods = {
    santri: ['Saldo Fingerprint', 'Tunai', 'QRIS', 'Debit'],
    wali: ['Saldo Wali', 'Tunai', 'QRIS', 'Debit'],
    staff: ['Saldo Staff', 'Tunai', 'QRIS', 'Debit'],
    umum: ['Tunai', 'QRIS', 'Debit']
  };

  function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
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

  function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
  }

  function resetCart() {
    cart = [];
    renderCart();
  }

  function renderCart() {
    const list = document.getElementById('checkoutList');
    const totalEl = document.getElementById('checkoutTotal');
    list.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
      total += item.total;

      const card = document.createElement('div');
      card.className = "flex justify-between items-center bg-gray-50 border rounded-lg p-3";

      card.innerHTML = `
        <div>
          <p class="text-lg font-semibold text-gray-900">${item.name}</p>
          <p class="text-sm text-gray-600">Qty: ${item.qty} × ${formatRupiah(item.price)}</p>
        </div>
        <div class="text-right">
          <p class="text-lg font-bold text-blue-600">${formatRupiah(item.total)}</p>
          <button onclick="removeFromCart(${index})"
                  class="mt-2 px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
            Hapus
          </button>
        </div>
      `;

      list.appendChild(card);
    });

    totalEl.textContent = formatRupiah(total);
  }

  function scanFingerprint() {
    alert('📲 Simulasi scan fingerprint...');
    // Integrasikan di sini logika AJAX ke backend fingerprint bila perlu
  }

  function getSelectedCustomerType() {
    const radios = document.querySelectorAll('input[name="customer_type"]');
    for (const radio of radios) {
      if (radio.checked) return radio.value;
    }
    return '';
  }

  function handleCustomerType(selected) {
  const paymentOptions = document.getElementById('paymentOptions');
  const scanSection = document.getElementById('scanSection');
  const newCustomerForm = document.getElementById('newCustomerForm');
  const methodSelect = document.getElementById('paymentMethod');

  paymentOptions.classList.remove('hidden');
  scanSection.classList.add('hidden');
  newCustomerForm.classList.add('hidden');
  methodSelect.innerHTML = '';

  if (!selected) {
    paymentOptions.classList.add('hidden');
    return;
  }

  paymentMethods[selected].forEach(metode => {
    const opt = document.createElement('option');
    opt.value = metode;
    opt.textContent = metode;
    methodSelect.appendChild(opt);
  });

  if (['santri', 'wali', 'staff'].includes(selected)) {
    scanSection.classList.remove('hidden');
  }

  if (selected === 'umum') {
    newCustomerForm.classList.remove('hidden');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('cancelBtn')?.addEventListener('click', () => {
    if (confirm('Kosongkan keranjang?')) resetCart();
  });

  document.getElementById('payBtn')?.addEventListener('click', () => {
    const type = getSelectedCustomerType();
    const method = document.getElementById('paymentMethod')?.value;
    const name = document.getElementById('customerName')?.value ?? '';

    if (cart.length === 0) {
      alert('Keranjang masih kosong.');
      return;
    }

    if (!type || !method) {
      alert('Pilih tipe customer dan metode pembayaran terlebih dahulu.');
      return;
    }

    if (type === 'umum' && name.trim() === '') {
      alert('Isi nama customer umum.');
      return;
    }

    const total = cart.reduce((sum, item) => sum + item.total, 0);

    // Panggil modal konfirmasi modern
    showPaymentModal(total, method);
  });
});


  function scanFingerprint() {
  // Tampilkan modal dan loader
  const modal = document.getElementById('fingerprintModal');
  const loader = document.getElementById('fingerprintLoader');
  const result = document.getElementById('fingerprintResult');
  modal.classList.remove('hidden');
  loader.classList.remove('hidden');
  result.classList.add('hidden');

  // Simulasi proses fingerprint (3 detik)
  setTimeout(() => {
    // Simulasi data ditemukan
    const dummy = {
      photo: "{{ asset('images/santri.png') }}", // ganti sesuai path
      name: "Ahmad Fauzan",
      nis: "SAN123456",
      status: "Santri - Kelas 9A",
      saldo: 150000
    };

    loader.classList.add('hidden');
    result.classList.remove('hidden');

    // Set data ke modal
    document.getElementById('fpPhoto').src = dummy.photo;
    document.getElementById('fpName').textContent = dummy.name;
    document.getElementById('fpNis').textContent = dummy.nis;
    document.getElementById('fpStatus').textContent = dummy.status;
    document.getElementById('fpSaldo').textContent = formatRupiah(dummy.saldo);

    // Simpan sementara (jika mau dikirim backend)
    window.currentCustomer = {
      type: 'santri',
      id: dummy.nis,
      name: dummy.name,
      saldo: dummy.saldo
    };
  }, 3000);
}

function closeFingerprintModal() {
  document.getElementById('fingerprintModal').classList.add('hidden');
}

function useFingerprintCustomer() {
  const data = window.currentCustomer;
  if (!data) return alert('Data tidak valid.');

  // Update tampilan informasi customer
  document.getElementById('selectedCustomerInfo').classList.remove('hidden');
  document.getElementById('infoCustomerName').textContent = data.name;
  document.getElementById('infoCustomerSaldo').textContent = formatRupiah(data.saldo);

  const total = cart.reduce((sum, item) => sum + item.total, 0);
  const sisa = data.saldo - total;
  document.getElementById('infoCustomerTagihan').textContent = formatRupiah(total);
  document.getElementById('infoCustomerSisa').textContent = formatRupiah(sisa);

  closeFingerprintModal();
}
</script>
