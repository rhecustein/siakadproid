<div id="modal-bayar" class="modal fixed inset-0 z-50 bg-black/50 hidden items-end md:items-center justify-center px-4 py-6">
  <div class="modal-content bg-white w-full max-w-md rounded-lg shadow-lg p-6 space-y-4 relative">
    
    <h3 class="text-lg font-bold mb-2">Pembayaran</h3>

    {{-- Metode Pembayaran --}}
    <div>
      <label for="paymentMethod" class="block text-sm font-medium mb-1">Metode:</label>
      <select id="paymentMethod" class="select select-bordered w-full">
        <option value="cash">Tunai</option>
        <option value="wallet">Saldo Santri/Wali</option>
        <option value="card">Kartu RFID</option>
      </select>
    </div>

    {{-- Nominal Pembayaran --}}
    <div>
      <label for="payAmount" class="block text-sm font-medium mb-1">Jumlah Dibayar:</label>
      <input type="number" id="payAmount" class="input input-bordered w-full" placeholder="0" />
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end gap-2 pt-4 border-t">
      <button type="button" class="btn btn-gray" data-action="close-modal">Batal</button>
      <button type="button" class="btn btn-green" id="confirmPaymentBtn">Bayar Sekarang</button>
    </div>
  </div>
</div>

<!-- Modal Fingerprint -->
<div id="fingerprintModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-8 relative">
    
    <!-- Loading state -->
    <div id="fingerprintLoader" class="text-center space-y-6">
      <p class="text-2xl font-semibold text-gray-800">Menunggu fingerprint...</p>
      <img src="{{ asset('images/finger.png') }}" alt="Loading" class="w-24 mx-auto animate-pulse">
      <button onclick="closeFingerprintModal()" class="mt-4 px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
    </div>

    <!-- Result state -->
    <div id="fingerprintResult" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-10 items-center mt-6">
      <!-- Left: Foto & Info -->
      <div class="text-center space-y-4">
        <img id="fpPhoto" src="" class="w-40 h-40 mx-auto object-cover rounded-full border shadow">
        <p id="fpName" class="text-2xl font-bold text-gray-800"></p>
        <p id="fpNis" class="text-base text-gray-600"></p>
        <p id="fpStatus" class="text-base text-blue-600 font-medium"></p>
      </div>
      <!-- Right: Saldo & Action -->
      <div class="space-y-4">
        <div class="bg-gray-100 rounded p-6 text-center shadow-sm">
          <p class="text-sm text-gray-500">Saldo</p>
          <p id="fpSaldo" class="text-3xl font-bold text-green-600">Rp 0</p>
        </div>
        <button onclick="useFingerprintCustomer()" id="fpUseButton" class="w-full py-3 bg-green-600 text-white text-lg rounded hover:bg-green-700">Gunakan Data Ini</button>
        <button onclick="closeFingerprintModal()" class="w-full py-3 bg-gray-200 text-gray-800 text-lg rounded hover:bg-gray-300">Batal</button>
      </div>
    </div>

  </div>
</div>

