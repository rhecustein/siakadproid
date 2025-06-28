@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 mb-4">
  📊 Dashboard
</h1>
<p class="text-gray-700 mb-6">Selamat datang di sistem <strong>SIAKAD Al-Bahjah</strong>.</p>

@php
  $user = Auth::user();
  $role = $user?->role?->name;
@endphp

@if ($role === 'admin')

  <!-- Quick Actions -->
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
    @php
      $quickActions = [
        ['label' => 'Input Nilai', 'icon' => '📝'],
        ['label' => 'Absensi', 'icon' => '📋'],
        ['label' => 'Kelas', 'icon' => '🏫'],
        ['label' => 'Pembayaran', 'icon' => '💳'],
        ['label' => 'PPDB', 'icon' => '📄'],
        ['label' => 'AI Konsultasi', 'icon' => '🤖']
      ];
    @endphp
    @foreach ($quickActions as $action)
      <div class="bg-white/40 backdrop-blur-md border border-white/10 shadow-xl rounded-xl p-4 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="text-3xl">{{ $action['icon'] }}</div>
        <div class="text-sm mt-2 text-center font-semibold text-gray-800">{{ $action['label'] }}</div>
      </div>
    @endforeach
    
  </div>

  <!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
  <div class="bg-white/40 backdrop-blur-md border border-white/10 shadow-lg rounded-xl p-4">
    <h2 class="text-xs text-gray-500 uppercase mb-1">Jumlah Siswa</h2>
    <p class="text-2xl font-bold text-blue-600">1200</p>
  </div>
  <div class="bg-white/40 backdrop-blur-md border border-white/10 shadow-lg rounded-xl p-4">
    <h2 class="text-xs text-gray-500 uppercase mb-1">Guru & Wali Kelas</h2>
    <p class="text-2xl font-bold text-green-600">85</p>
  </div>
  <div class="bg-white/40 backdrop-blur-md border border-white/10 shadow-lg rounded-xl p-4">
    <h2 class="text-xs text-gray-500 uppercase mb-1">Kelas Aktif</h2>
    <p class="text-2xl font-bold text-indigo-600">42</p>
  </div>
  <div class="bg-white/40 backdrop-blur-md border border-white/10 shadow-lg rounded-xl p-4">
    <h2 class="text-xs text-gray-500 uppercase mb-1">Tagihan Belum Dibayar</h2>
    <p class="text-2xl font-bold text-red-600">Rp 27jt</p>
  </div>
</div>

<!-- Alert Singkat -->
<!-- <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
  <button onclick="triggerAlert('emergency')" class="bg-red-600 text-white px-4 py-2 rounded shadow">🚨 Simulasi Gempa</button>
  <button onclick="triggerAlert('violation')" class="bg-orange-500 text-white px-4 py-2 rounded shadow">❗ Pelanggaran Siswa</button>
  <button onclick="triggerAlert('reminder')" class="bg-blue-600 text-white px-4 py-2 rounded shadow">🕌 Waktu Sholat</button>
  <button onclick="triggerAlert('event')" class="bg-purple-600 text-white px-4 py-2 rounded shadow">📢 Umum / Event</button>
</div> -->

<!-- Broadcast Simulasi -->



  <!-- AI Insight -->
  <div class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white p-6 rounded-xl shadow-xl mb-10 mt-4">
    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
      🤖 Insight AI Sistem
      <span class="bg-white/20 text-xs px-2 py-1 rounded-full">Realtime</span>
    </h3>
    <ul class="text-sm space-y-2 list-disc ml-5">
      <li>📊 3 Guru belum input nilai minggu ini</li>
      <li>💡 Saran: Kirim pengingat ke wali kelas 7C</li>
      <li>⚠️ 27 siswa belum lunasi SPP bulan ini</li>
    </ul>
  </div>

  <!-- Grafik -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
    <div class="bg-white p-4 rounded-xl shadow-md h-[260px]">
      <h3 class="text-sm font-semibold mb-2 text-gray-700">Grafik Keuangan</h3>
      <canvas id="chartKeuangan" width="400" height="180"></canvas>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-md h-[260px]">
      <h3 class="text-sm font-semibold mb-2 text-gray-700">Grafik Kehadiran</h3>
      <canvas id="chartAbsensi" width="400" height="180"></canvas>
    </div>
  </div>

  <!-- Timeline Harian -->
  <div class="bg-white p-6 rounded-xl shadow-md mb-10">
    <h3 class="text-lg font-semibold mb-4">⏱ Jadwal Hari Ini</h3>
    <ul class="border-l-2 border-blue-600 pl-4 space-y-4 text-sm text-gray-700">
      <li><span class="font-bold">04.30</span> — Sholat Subuh & Tadarus</li>
      <li><span class="font-bold">06.30</span> — Kelas Dimulai</li>
      <li><span class="font-bold">10.00</span> — Istirahat & Makan Pagi</li>
      <li><span class="font-bold">13.00</span> — Dzuhur & Istirahat</li>
      <li><span class="font-bold">14.00</span> — Kelas Sore</li>
      <li><span class="font-bold">18.00</span> — Maghrib & Hafalan</li>
      <li><span class="font-bold">20.00</span> — Tidur</li>
    </ul>
  </div>

  <!-- Aktivitas & Tagihan -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h3 class="text-lg font-semibold mb-4">📋 Aktivitas Terbaru</h3>
      <ul class="space-y-3 text-sm text-gray-600">
        <li>📝 Guru A menginput nilai kelas 9A</li>
        <li>💳 Wali santri membayar SPP via QRIS</li>
        <li>👤 Admin menambahkan pengguna baru</li>
        <li>📥 Pemasukan Rp 5.000.000 ditambahkan</li>
        <li>📤 Pengeluaran koperasi Rp 1.000.000</li>
      </ul>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h3 class="text-lg font-semibold mb-4">💰 Tagihan Tertinggi</h3>
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left text-gray-500 border-b">
            <th>Nama</th><th>Kelas</th><th>Tagihan</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b">
            <td>A. Rahman</td><td>9A</td><td>Rp 2.500.000</td>
          </tr>
          <tr class="border-b">
            <td>B. Salma</td><td>8B</td><td>Rp 2.000.000</td>
          </tr>
          <tr class="border-b">
            <td>C. Laila</td><td>10C</td><td>Rp 1.750.000</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Notifikasi Pop-up -->
  <div id="notifBox" class="fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-3 rounded-xl shadow-lg translate-x-full transition-all duration-700">
    <p><strong>🔔 Notifikasi:</strong> 18 siswa absen hari ini. <a href="#" class="underline">Lihat Detail</a></p>
    <button onclick="document.getElementById('notifBox').style.display='none'" class="absolute top-1 right-2 text-white font-bold">×</button>
  </div>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    setTimeout(() => {
      document.getElementById('notifBox').classList.remove('translate-x-full');
      document.getElementById('notifBox').classList.add('translate-x-0');
    }, 1000);

    new Chart(document.getElementById('chartKeuangan'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
        datasets: [
          { label: 'Pemasukan', data: [15, 22, 18, 26, 32], backgroundColor: '#34d399' },
          { label: 'Pengeluaran', data: [8, 17, 12, 21, 25], backgroundColor: '#f87171' }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });

    new Chart(document.getElementById('chartAbsensi'), {
      type: 'doughnut',
      data: {
        labels: ['Hadir', 'Izin', 'Sakit', 'Alfa'],
        datasets: [{
          data: [75, 10, 8, 7],
          backgroundColor: ['#10b981', '#facc15', '#60a5fa', '#ef4444']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>

@else
  <div class="mt-6 p-4 bg-red-100 text-red-700 rounded">Role tidak dikenali. Silakan hubungi administrator.</div>
@endif
@endsection
