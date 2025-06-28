@extends('layouts.app')

@section('content')
<div class="min-h-screen max-w-screen-2xl mx-auto flex flex-col lg:flex-row gap-6 items-start justify-start py-10 px-4 lg:px-8 text-gray-900">
  <!-- Left: Chat Area -->
  <div class="w-full lg:basis-1/2">
    <!-- AI Circle Animation -->
    <div class="mb-6 flex justify-center">
      <div class="ai">
        <div class="container">
          <div class="c c4"></div>
          <div class="c c1"></div>
          <div class="c c2"></div>
          <div class="c c3"></div>
          <div class="rings"></div>
        </div>
        <div class="glass"></div>
      </div>
    </div>

    <!-- Chat Box -->
    <div class="bg-white border border-gray-200 shadow-md rounded-xl flex flex-col h-[60vh] overflow-hidden">
      <div id="chatLog" class="flex-1 p-4 overflow-y-auto space-y-4 text-sm">
        <div class="chat-bubble bg-blue-100 text-black p-3 rounded-lg max-w-sm">Halo 👋, saya Asisten AI. Ada yang bisa saya bantu?</div>
      </div>
      <form onsubmit="sendMessage(event)" class="border-t border-gray-200 p-3 flex gap-2 bg-gray-50">
        <input type="text" id="inputMsg" class="flex-1 px-4 py-2 rounded-md border border-gray-300 text-black placeholder-gray-400 focus:outline-none" placeholder="Tanyakan sesuatu..." required>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim</button>
      </form>
    </div>

    <!-- Quick Topic Suggestions -->
    <div class="mt-4 flex flex-wrap gap-2 text-xs">
      <button onclick="quickFill('Bagaimana perkembangan nilai anak saya?')" class="bg-blue-100 text-black px-3 py-1 rounded-full hover:bg-blue-200">📊 Nilai Anak</button>
      <button onclick="quickFill('Kapan waktu ujian selanjutnya?')" class="bg-blue-100 text-black px-3 py-1 rounded-full hover:bg-blue-200">📆 Jadwal Ujian</button>
      <button onclick="quickFill('Apakah ada tagihan SPP bulan ini?')" class="bg-green-100 text-black px-3 py-1 rounded-full hover:bg-green-200">💸 Tagihan SPP</button>
      <button onclick="quickFill('Bagaimana kondisi kesehatan anak saya?')" class="bg-red-100 text-black px-3 py-1 rounded-full hover:bg-red-200">❤️ Kesehatan Anak</button>
    </div>
  </div>

  <!-- Right: Visual Result -->
  <div class="w-full lg:basis-1/2 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
    <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Ringkasan Visual</h3>
    <div class="bg-gray-100 p-4 rounded-xl shadow mb-4">
      <h4 class="text-sm font-semibold text-gray-700 mb-2">Status Kesehatan</h4>
      <ul class="text-sm text-gray-700 space-y-1">
        <li>✅ Tidak ada laporan sakit minggu ini</li>
        <li>🩺 Terakhir diperiksa: 2 hari lalu</li>
        <li>💊 Obat rutin: Vitamin C</li>
      </ul>
    </div>
    <div class="bg-gray-100 p-4 rounded-xl shadow mb-4">
      <h4 class="text-sm font-semibold text-gray-700 mb-2">Rangkuman Nilai</h4>
      <canvas id="chartNilai" class="w-full h-40"></canvas>
    </div>
    <div class="bg-gray-100 p-4 rounded-xl shadow">
      <h4 class="text-sm font-semibold text-gray-700 mb-2">Absensi Bulanan</h4>
      <canvas id="chartAbsen" class="w-full h-40"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('inputMsg');
    const msg = input.value.trim();
    if (!msg) return;
    const chatLog = document.getElementById('chatLog');

    const userBubble = document.createElement('div');
    userBubble.className = 'chat-bubble bg-blue-200 text-black p-3 rounded-lg max-w-sm self-end';
    userBubble.innerText = msg;
    chatLog.appendChild(userBubble);

    input.value = '';
    setTimeout(() => {
      const aiBubble = document.createElement('div');
      aiBubble.className = 'chat-bubble bg-purple-200 text-black p-3 rounded-lg max-w-sm';
      aiBubble.innerText = 'Terima kasih, saya sedang memproses pertanyaan Anda...';
      chatLog.appendChild(aiBubble);
      chatLog.scrollTop = chatLog.scrollHeight;
    }, 800);
  }

  function quickFill(text) {
    document.getElementById('inputMsg').value = text;
    document.getElementById('inputMsg').focus();
  }

  // Chart dummy
  new Chart(document.getElementById('chartNilai'), {
    type: 'bar',
    data: {
      labels: ['Math', 'IPA', 'Bahasa', 'Aqidah'],
      datasets: [{
        label: 'Nilai',
        data: [85, 90, 88, 92],
        backgroundColor: '#3b82f6'
      }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });

  new Chart(document.getElementById('chartAbsen'), {
    type: 'doughnut',
    data: {
      labels: ['Hadir', 'Izin', 'Sakit'],
      datasets: [{
        data: [22, 2, 1],
        backgroundColor: ['#10b981', '#facc15', '#f87171']
      }]
    },
    options: { responsive: true }
  });
</script>
@endsection
