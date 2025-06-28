<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Admin Canteen • Al-Bahjah' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .menu-active {
      @apply bg-blue-100 font-bold text-blue-700;
    }
  </style>

  @stack('styles')
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased font-sans">

  <div class="min-h-screen flex">
    {{-- Sidebar --}}
    @include('canteen.partials.sidebar')

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-h-screen">
      <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-lg font-semibold text-blue-700">{{ $title ?? 'Dashboard' }}</h1>
        <div class="text-sm text-gray-500">
          {{ now()->translatedFormat('l, d F Y') }}
        </div>
      </header>

      <main class="p-6 flex-1">
        @yield('content')
      </main>

      <footer class="text-center text-xs text-gray-400 py-4 border-t">
        &copy; {{ date('Y') }} Yayasan Al-Bahjah • Canteen System
      </footer>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
