<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Dashboard • SIAKAD Al-Bahjah' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .hidden-mobile { display: none; }
    @media (min-width: 1024px) {
      .hidden-mobile { display: flex; }
    }
    .menu-active {
      @apply bg-blue-800 font-semibold;
    }
  </style>
</head>

<body class="bg-neutral-50 text-neutral-800 antialiased font-sans">
@php
  $user = Auth::user();
  $role = $user?->role?->name;
@endphp

<div class="min-h-screen flex flex-col lg:flex-row overflow-hidden">

  {{-- SIDEBAR --}}
  @include('layouts.sidebar')

  {{-- MAIN --}}
  <div class="flex-1 flex flex-col min-h-screen">

{{-- HEADER --}}
<header class="h-16 flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-white/30 shadow-md px-4 lg:px-6 relative z-40">

  {{-- Left: Logo & Sidebar Toggle --}}
  <div class="flex items-center gap-4">
    <button onclick="toggleSidebar()" class="lg:hidden text-blue-600 hover:text-blue-800 transition">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <h1 class="text-lg font-extrabold tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 uppercase">
      {{ $title ?? 'SIAKAD Al-Bahjah' }}
    </h1>
  </div>

  {{-- Center: Tanggal & Jam --}}
  <div class="hidden md:flex flex-col items-center">
    <span id="todayDate" class="text-xs text-gray-600"></span>
    <span id="liveClock" class="text-sm font-semibold text-blue-600"></span>
  </div>

  {{-- Right: Controls --}}
  <div class="flex items-center gap-4">

    {{-- Notifikasi --}}
    <div class="relative">
      <button onclick="toggleNotif()" class="relative text-blue-600 hover:text-blue-800 transition">
        🔔
        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">3</span>
      </button>
      <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-xl z-50 p-4 text-sm space-y-2">
        <div>🧾 Tagihan baru untuk kelas 9A</div>
        <div>📢 Pengumuman jadwal ujian besok</div>
        <div>💬 Konsultasi siswa 7B menunggu</div>
      </div>
    </div>

    {{-- Dark Mode Toggle --}}
    <button onclick="toggleDarkMode()" class="text-yellow-600 hover:text-yellow-800 transition text-xl">
      <span id="themeIcon">🌙</span>
    </button>

    {{-- User Info --}}
    <div class="relative">
      <button onclick="toggleDropdown()" class="flex items-center gap-2 focus:outline-none group">
        <img src="{{ $user->avatar_url ?? asset('images/avatar.png') }}"
             alt="Avatar"
             class="w-9 h-9 rounded-full object-cover border-2 border-blue-500 shadow-sm group-hover:ring-2 ring-blue-300 transition">
        <div class="hidden md:flex flex-col text-right">
          <span class="text-sm font-semibold text-gray-800">{{ $user->name ?? 'Pengguna' }}</span>
          <span class="text-xs text-gray-500">{{ ucfirst($user->role->name ?? '-') }}</span>
        </div>
      </button>

      {{-- Dropdown --}}
      <div id="dropdownMenu"
           class="hidden absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">👤 Profil Saya</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">🔒 Ganti Password</a>
        <div class="border-t border-gray-100"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">🚪 Keluar</button>
        </form>
      </div>
    </div>
  </div>
</header>

{{-- ALERT STRIP (Opsional) --}}
<div class="w-full bg-yellow-100 text-yellow-800 text-sm px-4 py-2 overflow-hidden whitespace-nowrap">
  <marquee behavior="scroll" direction="left" scrollamount="5">
    🚨 Perhatian! Pengumpulan nilai akhir maksimal hari Jumat | 🕒 Ujian Tengah Semester dimulai Senin depan
  </marquee>
</div>

{{-- Scripts --}}
<script>
  function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
  }

  function toggleNotif() {
    document.getElementById('notifDropdown').classList.toggle('hidden');
  }

  function toggleDarkMode() {
    const body = document.body;
    const icon = document.getElementById('themeIcon');
    body.classList.toggle('dark');
    icon.innerText = body.classList.contains('dark') ? '☀️' : '🌙';
    localStorage.setItem('theme', body.classList.contains('dark') ? 'dark' : 'light');
  }

  function updateClock() {
    const now = new Date();
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const dayName = days[now.getDay()];
    const dateStr = `${dayName}, ${now.getDate().toString().padStart(2,'0')}-${(now.getMonth()+1).toString().padStart(2,'0')}-${now.getFullYear()}`;
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('todayDate').textContent = dateStr;
    document.getElementById('liveClock').textContent = timeStr;
  }

  setInterval(updateClock, 1000);
  updateClock();

  // Load theme from localStorage
  window.onload = () => {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
      document.body.classList.add('dark');
      document.getElementById('themeIcon').textContent = '☀️';
    }
  };
</script>


<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hidden');
  }

  // Optional: auto-close dropdown when clicking outside
  window.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownMenu');
    const button = document.getElementById('userBtn');
    if (!dropdown.contains(e.target) && !e.target.closest('button')) {
      dropdown.classList.add('hidden');
    }
  });
</script>


    {{-- CONTENT --}}
    <main class="flex-1 px-6 py-8">
      @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('layouts.alert')
    @include('layouts.broadcast')
    <footer class="py-4 text-center text-xs text-neutral-400 border-t">
      &copy; {{ date('Y') }} Yayasan Al-Bahjah • All rights reserved.
    </footer>
  </div>
</div>

{{-- JS --}}
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hidden-mobile');
  }

  function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.classList.toggle('hidden');
  }

  document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdownMenu');
    const button = document.getElementById('userBtn');
    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
      dropdown.classList.add('hidden');
    }
  });
</script>
@stack('scripts')
</body>
</html>
