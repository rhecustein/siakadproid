<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'POS Canteen • Al-Bahjah' }}</title>
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
  @stack('styles')
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased font-sans">
  @php
    $user = Auth::user();
    $role = $user?->role?->name;
  @endphp

  <div class="min-h-screen flex overflow-hidden">

    {{-- POS SIDEBAR --}}
    @include('canteen.partials.sidebar')

    {{-- POS MAIN --}}
    <div class="flex-1 flex flex-col min-h-screen">

      {{-- POS HEADER --}}
      <header class="h-16 flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-white/30 shadow-md px-4 lg:px-6 relative z-40">
        <div class="flex items-center gap-4">
          <button onclick="toggleSidebar()" class="lg:hidden text-blue-600 hover:text-blue-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-lg font-extrabold tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 uppercase">
            {{ $title ?? 'POS Canteen' }}
          </h1>
        </div>
        <div class="hidden md:flex flex-col items-center">
          <span id="todayDate" class="text-xs text-gray-600"></span>
          <span id="liveClock" class="text-sm font-semibold text-blue-600"></span>
        </div>
        <div class="flex items-center gap-4">
          <button onclick="toggleDarkMode()" class="text-yellow-600 hover:text-yellow-800 transition text-xl">
            <span id="themeIcon">🌙</span>
          </button>
          <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center gap-2 focus:outline-none group" id="userBtn">
              <img src="{{ $user->avatar_url ?? asset('images/avatar.png') }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-blue-500 shadow-sm group-hover:ring-2 ring-blue-300 transition">
              <div class="hidden md:flex flex-col text-right">
                <span class="text-sm font-semibold text-gray-800">{{ $user->name ?? 'Kasir' }}</span>
                <span class="text-xs text-gray-500">{{ ucfirst($user->role->name ?? '-') }}</span>
              </div>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">👤 Profil</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">🚪 Keluar</button>
              </form>
            </div>
          </div>
        </div>
      </header>

      {{-- MAIN POS GRID --}}
      <main class="flex-1 grid grid-cols-[2fr_1.3fr] min-h-[calc(100vh-4rem)]">
        <section class="p-4 border-r overflow-y-auto">
          @include('canteen.partials.header')
          @include('canteen.partials.product')
        </section>
        @include('canteen.partials.checkout')
      </main>

      @include('canteen.partials.modal')

      <footer class="py-2 text-center text-xs text-neutral-400 border-t">
        &copy; {{ date('Y') }} Yayasan Al-Bahjah • POS Canteen
      </footer>
    </div>
  </div>

  <script>
    function toggleDropdown() {
      const menu = document.getElementById('dropdownMenu');
      menu.classList.toggle('hidden');
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('hidden-mobile');
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

    window.onload = () => {
      const theme = localStorage.getItem('theme');
      if (theme === 'dark') {
        document.body.classList.add('dark');
        document.getElementById('themeIcon').textContent = '☀️';
      }
    };

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
