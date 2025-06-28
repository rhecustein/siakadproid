<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Selamat Datang • SIAKAD Al-Bahjah</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased leading-relaxed font-sans">

<!-- HEADER -->
<header class="bg-blue-700 shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-white tracking-tight">SIAKAD Al-Bahjah</h1>
    <a href="{{ route('login') }}"
       class="text-sm font-semibold text-blue-700 bg-white hover:bg-neutral-100 px-5 py-2 rounded-xl shadow transition">
      Masuk
    </a>
  </div>
</header>


<!-- HERO SECTION -->
<section class="relative overflow-hidden bg-neutral-100 text-neutral-800 py-32">
  <!-- Background Image -->
  <img src="{{ asset('images/banner-soft-bg.png') }}" 
       alt="" 
       class="absolute inset-0 w-full h-full object-cover opacity-60 pointer-events-none select-none z-0" />

  <!-- Overlay Gradient (optional for color balance) -->
  <div class="absolute inset-0 bg-gradient-to-br from-white/70 via-white/50 to-white/30 z-10"></div>

  <!-- Content -->
  <div class="relative z-20 max-w-4xl mx-auto text-center px-6">
    <img src="{{ asset('images/logo.png') }}" alt="Logo SIAKAD Al-Bahjah" class="w-32 mx-auto mb-6">
    <h2 class="text-5xl font-extrabold mb-6 text-primary-700 drop-shadow-md">Selamat Datang di<br> SIAKAD Al-Bahjah</h2>
    <p class="text-xl font-light max-w-2xl mx-auto text-neutral-700">Sistem Informasi Akademik Terpadu untuk Pondok Pesantren, SD, SMP, dan SMA</p>
   <a href="{{ route('login') }}"
     class="inline-block mt-10 bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-lg transition 
            hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
    Mulai Sekarang
  </a>
  </div>
</section>


<!-- FITUR -->
<section class="py-24 bg-neutral-100">
  <div class="max-w-6xl mx-auto px-6">
    <h3 class="text-3xl font-bold text-center mb-12 text-neutral-800">Fitur Unggulan</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

      <!-- 1. Raport Digital -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-blue-500 to-green-400">
          <img src="{{ asset('images/icons/raport.png') }}" alt="Raport Digital" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Raport Digital</h4>
          <p class="text-sm text-neutral-500 mt-1">Akses nilai dan cetak raport secara online.</p>
        </div>
      </div>

      <!-- 2. Absensi Real-Time -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-cyan-400">
          <img src="{{ asset('images/icons/absensi.png') }}" alt="Absensi Real-Time" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Absensi Real-Time</h4>
          <p class="text-sm text-neutral-500 mt-1">Monitoring kehadiran dengan fingerprint & notifikasi wali.</p>
        </div>
      </div>

      <!-- 3. Pembayaran Cashless -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-pink-500 to-yellow-400">
          <img src="{{ asset('images/icons/cashless.png') }}" alt="Pembayaran Cashless" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Pembayaran Cashless</h4>
          <p class="text-sm text-neutral-500 mt-1">SPP & kantin pakai sistem saldo wali santri.</p>
        </div>
      </div>

      <!-- 4. AI Konsultasi -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-purple-600 to-pink-400">
          <img src="{{ asset('images/icons/ai.png') }}" alt="AI Konsultasi" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">AI Konsultasi</h4>
          <p class="text-sm text-neutral-500 mt-1">Orang tua dan guru bisa berkonsultasi via AI.</p>
        </div>
      </div>

      <!-- 5. Monitoring Akademik -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-orange-500 to-yellow-400">
          <img src="{{ asset('images/icons/monitor.png') }}" alt="Monitoring Akademik" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Monitoring Akademik</h4>
          <p class="text-sm text-neutral-500 mt-1">Pantau progres belajar, pelanggaran, dan grafik nilai.</p>
        </div>
      </div>

      <!-- 6. Portal Wali Santri -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-sky-400 to-indigo-500">
          <img src="{{ asset('images/icons/portal.png') }}" alt="Portal Wali Santri" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Portal Wali Santri</h4>
          <p class="text-sm text-neutral-500 mt-1">Laporan real-time, jadwal, dan pengumuman ke wali.</p>
        </div>
      </div>

      <!-- 7. Manajemen Kantin -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-green-300 to-lime-400">
          <img src="{{ asset('images/icons/kantin.png') }}" alt="Manajemen Kantin" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Manajemen Kantin</h4>
          <p class="text-sm text-neutral-500 mt-1">Pembelian snack & makan siang dengan saldo digital.</p>
        </div>
      </div>

      <!-- 8. Sistem Parkir -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-red-400 to-yellow-300">
          <img src="{{ asset('images/icons/parkir.png') }}" alt="Sistem Parkir" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Sistem Parkir</h4>
          <p class="text-sm text-neutral-500 mt-1">RFID & CCTV parkir otomatis terintegrasi sistem.</p>
        </div>
      </div>

      <!-- 9. Arsip Digital -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-blue-600 to-gray-400">
          <img src="{{ asset('images/icons/arsip.png') }}" alt="Arsip Digital" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Arsip Digital</h4>
          <p class="text-sm text-neutral-500 mt-1">Semua dokumen dan berkas siswa tersimpan aman.</p>
        </div>
      </div>

      <!-- 10. Pengumuman Otomatis -->
      <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition border border-neutral-200">
        <div class="h-50 flex items-center justify-center bg-gradient-to-br from-yellow-400 to-orange-500">
          <img src="{{ asset('images/icons/pengumuman.png') }}" alt="Pengumuman Otomatis" class="h-30 drop-shadow-xl">
        </div>
        <div class="bg-white text-center py-4 px-2">
          <h4 class="text-base font-semibold text-neutral-800">Pengumuman Otomatis</h4>
          <p class="text-sm text-neutral-500 mt-1">Notifikasi via portal, aplikasi & SMS gateway.</p>
        </div>
      </div>

    </div>
  </div>
</section>


  <!-- FOOTER -->
  <footer class="text-center text-sm text-neutral-500 py-8 border-t border-neutral-200">
    &copy; {{ date('Y') }} Yayasan Al-Bahjah • All Rights Reserved.
  </footer>

</body>
</html>
