<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if(Session::has('sanctum_token'))
        <meta name="sanctum-token" content="{{ Session::get('sanctum_token') }}">
    @endif
    {{-- Meta tag untuk CSRF token, penting untuk request POST/PUT/DELETE --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard • SIAKAD Al-Bahjah' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS kustom yang dipertahankan */
        .hidden-mobile { display: none; }
        @media (min-width: 1024px) {
            .hidden-mobile { display: flex; }
        }
        /* Kelas menu-active dipindahkan ke app.css dan disesuaikan */


        /* --- GLOBAL COLOR VARIABLES --- */
        :root {
            /* Warna utama aplikasi (dapat disesuaikan agar lebih harmonis dengan logo) */
            --color-primary: 30 58 138; /* Blue-800, sebagai warna dasar yang kuat */

            /* Warna aksen dari logo: Hijau dan Kuning */
            --color-accent-start: 46 125 50; /* Green dari logo: #2e7d32 */
            --color-accent-end: 253 216 53; /* Yellow dari logo: #fdd835 */

            /* Warna khusus Sidebar */
            --sidebar-bg: 17 24 39;
            --sidebar-text: 209 213 219;
            --sidebar-border: 55 65 81;
            --sidebar-hover-bg: 31 41 55;
            --sidebar-active-bg: 37 99 235;
            --sidebar-active-text: 255 255 255;

            /* Warna khusus Welcome Page */
            --welcome-blue-dark: 23 37 84;
            --welcome-blue-light: 37 99 235;
            --welcome-indigo: 79 70 229;
            --welcome-gray-text: 75 85 99;
            --ai-glow-color: 0 204 255; /* Cyan, untuk glow AI yang futuristik dan kontras */
            --data-stream-blue: 59 130 246;
            --data-stream-green: 16 185 129;
            --data-stream-red: 239 68 68;

            /* Warna khusus Login Page */
            --login-bg-start: 229 231 235;
            --login-bg-end: 209 213 219;
            --login-primary-blue: 59 130 246;
            --login-visual-dark: 23 37 84;
            --login-visual-light: 59 130 246;
            --login-visual-accent: 139 92 246;
        }

        /* Animasi Border RGB untuk Alert Strip */
        .border-animation { position: relative; overflow: hidden; border-radius: 0.5rem; }
        .border-animation::before { content: ''; position: absolute; top: -100%; left: -100%; width: 300%; height: 300%; background: conic-gradient(from 0deg, rgb(var(--color-accent-start)) 0%, rgb(var(--color-accent-end)) 33%, rgb(var(--color-primary)) 66%, rgb(var(--color-accent-start)) 100%); animation: rotateBorder 8s ease-in-out infinite; z-index: -1; }
        @keyframes rotateBorder { to { transform: rotate(1turn); } }

        /* --- Sidebar Specific Styles --- */
        .sidebar-link-active-indicator { position: relative; background-color: rgba(var(--sidebar-active-bg), 0.2); color: rgb(var(--sidebar-active-text)); }
        .sidebar-link-active-indicator::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, rgb(var(--color-accent-start)), rgb(var(--color-accent-end))); animation: pulseVerticalBorder 1.5s infinite alternate; border-radius: 0 4px 4px 0; z-index: 1; }
        @keyframes pulseVerticalBorder { from { opacity: 0.6; transform: scaleY(0.5); } to { opacity: 1; transform: scaleY(1); } }
        .sidebar-chevron { transition: transform 0.3s ease-in-out; }
        .sidebar-details[open] .sidebar-chevron { transform: rotate(90deg); }
        .logo-glow-text { text-shadow: 0 0 5px rgba(var(--color-accent-start), 0.5), 0 0 10px rgba(var(--color-accent-end), 0.3); }
        .transition-sidebar-item { transition: all 0.2s ease-in-out; }

        /* Welcome Page Specific Styles */
        .hero-background-animation { position: absolute; inset: 0; overflow: hidden; z-index: 0; background: radial-gradient(circle at center, rgba(var(--welcome-blue-dark), 0.05) 0%, rgba(var(--welcome-blue-dark), 0.1) 30%, transparent 70%); }
        .hero-background-animation::before, .hero-background-animation::after { content: ''; position: absolute; border-radius: 50%; opacity: 0; pointer-events: none; z-index: 1; }
        .hero-background-animation::before { width: 100vw; height: 100vw; top: 50%; left: 50%; background: radial-gradient(circle, rgba(var(--welcome-blue-light), 0.1), rgba(var(--welcome-indigo), 0.05) 50%, transparent 70%); animation: convergeNetwork 20s linear infinite; transform: translate(-50%, -50%) scale(0); }
        .hero-background-animation::after { width: 50vw; height: 50vw; top: 50%; left: 50%; background: radial-gradient(circle, rgba(var(--welcome-blue-light), 0.15), rgba(var(--welcome-indigo), 0.08) 50%, transparent 70%); animation: convergeNetwork 15s linear infinite 5s; transform: translate(-50%, -50%) scale(0); }
        @keyframes convergeNetwork { 0% { transform: translate(-50%, -50%) scale(0); opacity: 0; } 20% { opacity: 1; } 80% { opacity: 1; } 100% { transform: translate(-50%, -50%) scale(1); opacity: 0; } }
        .ai-logo-glow { animation: aiPulse 3s infinite alternate ease-in-out; filter: drop-shadow(0 0 5px rgba(var(--ai-glow-color), 0.5)) drop-shadow(0 0 10px rgba(var(--ai-glow-color), 0.3)); }
        @keyframes aiPulse { 0% { filter: drop-shadow(0 0 5px rgba(var(--ai-glow-color), 0.5)) drop-shadow(0 0 10px rgba(var(--ai-glow-color), 0.3)); } 100% { filter: drop-shadow(0 0 10px rgba(var(--ai-glow-color), 0.7)) drop-shadow(0 0 20px rgba(var(--ai-glow-color), 0.5)); } }
        .feature-card { position: relative; overflow: hidden; cursor: pointer; background-color: white; }
        .feature-card-shimmer { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transform: translateX(-100%); transition: none; pointer-events: none; z-index: 2; }
        .feature-icon-pulse { animation: iconPulse 2s infinite ease-in-out; }
        @keyframes iconPulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        .data-stream-line { position: absolute; background: linear-gradient(to right, transparent, rgba(var(--data-stream-blue), 0.8), transparent); height: 2px; animation: flowData 3s linear infinite; transform-origin: left center; }
        .data-stream-line.vertical { background: linear-gradient(to bottom, transparent, rgba(var(--data-stream-green), 0.8), transparent); width: 2px; height: 100%; animation: flowDataVertical 3s linear infinite; transform-origin: top center; }
        @keyframes flowData { 0% { transform: translateX(-100%); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { transform: translateX(100%); opacity: 0; } }
        @keyframes flowDataVertical { 0% { transform: translateY(-100%); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { transform: translateY(100%); opacity: 0; } }
        .ai-core-glow-pulse { animation: aiCorePulse 2s infinite alternate ease-in-out; }
        @keyframes aiCorePulse { 0% { filter: drop-shadow(0 0 5px rgba(var(--ai-glow-color), 0.5)); transform: scale(1); } 100% { filter: drop-shadow(0 0 15px rgba(var(--ai-glow-color), 0.8)); transform: scale(1.05); } }
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; opacity: 0; }
        .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; opacity: 0; transform: translateY(20px); }
        .animate-delay-100 { animation-delay: 0.1s; } .animate-delay-200 { animation-delay: 0.2s; } .animate-delay-300 { animation-delay: 0.3s; } .animate-delay-400 { animation-delay: 0.4s; } .animate-delay-500 { animation-delay: 0.5s; } .animate-delay-600 { animation-delay: 0.6s; } .animate-delay-700 { animation-delay: 0.7s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { transform: translateY(0); } }
        .animate-pulse-grow { animation: pulseGrow 2s infinite ease-in-out; }
        @keyframes pulseGrow { 0% { transform: scale(1); box-shadow: 0 4px 12px rgba(var(--welcome-blue-light), 0.2); } 50% { transform: scale(1.03); box-shadow: 0 6px 16px rgba(var(--welcome-blue-light), 0.4); } 100% { transform: scale(1); box-shadow: 0 4px 12px rgba(var(--welcome-blue-light), 0.2); } }
        .staggered-metric-item { opacity: 0; transform: translateY(20px); }

        /* --- Login Page Specific Styles --- */
        .login-bg-animation { position: absolute; inset: 0; overflow: hidden; z-index: 0; }
        .login-bg-animation::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at center, rgba(var(--login-primary-blue), 0.05) 0%, transparent 70%); animation: rotateAndScale 30s linear infinite; pointer-events: none; }
        @keyframes rotateAndScale { 0% { transform: translate(-50%, -50%) rotate(0deg) scale(0.8); opacity: 0.6; } 50% { transform: translate(-50%, -50%) rotate(180deg) scale(1.2); opacity: 0.8; } 100% { transform: translate(-50%, -50%) rotate(360deg) scale(0.8); opacity: 0.6; } }
        .tab-active-underline { position: relative; padding-bottom: 0.5rem; }
        .tab-active-underline::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60%; height: 3px; background-color: rgb(var(--login-primary-blue)); border-radius: 9999px; transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out; }
        .form-radio-checkbox { border-radius: 0.25rem; border-color: rgb(156 163 175); color: rgb(var(--login-primary-blue)); transition: all 0.2s ease-in-out; }
        .form-radio-checkbox:checked { background-color: rgb(var(--login-primary-blue)); border-color: rgb(var(--login-primary-blue)); }
        .form-radio-checkbox:focus { box-shadow: 0 0 0 3px rgba(var(--login-primary-blue), 0.3); border-color: rgb(var(--login-primary-blue)); }
        .login-visual-panel { position: relative; overflow: hidden; background: linear-gradient(135deg, rgb(var(--login-visual-dark)), rgb(var(--welcome-indigo))); }
        .login-visual-panel::before { content: ''; position: absolute; top: -20%; left: -20%; width: 120%; height: 120%; background: radial-gradient(circle at center, rgba(255, 255, 255, 0.08) 0%, transparent 50%); animation: moveAndFade1 25s linear infinite alternate; border-radius: 50%; pointer-events: none; z-index: 1; }
        .login-visual-panel::after { content: ''; position: absolute; bottom: -15%; right: -15%; width: 100%; height: 100%; background: radial-gradient(circle at center, rgba(var(--login-visual-accent), 0.08) 0%, transparent 60%); animation: moveAndFade2 20s linear infinite; border-radius: 50%; pointer-events: none; z-index: 1; }
        @keyframes moveAndFade1 { 0% { transform: translate(0, 0) scale(0.8); opacity: 0.6; } 25% { transform: translate(10%, 20%) scale(0.9); opacity: 0.7; } 50% { transform: translate(0, 40%) scale(1.1); opacity: 0.8; } 75% { transform: translate(-10%, 20%) scale(1); opacity: 0.7; } 100% { transform: translate(0, 0) scale(0.8); opacity: 0.6; } }
        @keyframes moveAndFade2 { 0% { transform: translate(0, 0) scale(0.9); opacity: 0.7; } 25% { transform: translate(-15%, -25%) scale(1); opacity: 0.8; } 50% { transform: translate(-30%, 0) scale(0.8); opacity: 0.7; } 75% { transform: translate(-15%, 25%) scale(1.1); opacity: 0.9; } 100% { transform: translate(0, 0) scale(0.9); opacity: 0.7; } }
        .login-visual-panel .digital-lines-overlay { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
        .login-visual-panel .digital-lines-overlay::before, .login-visual-panel .digital-lines-overlay::after { content: ''; position: absolute; background: rgba(255, 255, 255, 0.03); pointer-events: none; }
        .login-visual-panel .digital-lines-overlay::before { top: 0; left: 0; width: 100%; height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.03), transparent); animation: slideLineHorizontal 20s linear infinite; transform-origin: left center; }
        .login-visual-panel .digital-lines-overlay::after { top: 0; left: 0; height: 100%; width: 1px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.03), transparent); animation: slideLineVertical 25s linear infinite; transform-origin: top center; }
        @keyframes slideLineHorizontal { 0% { transform: translateX(0); } to { transform: translateX(100%); } }
        @keyframes slideLineVertical { 0% { transform: translateY(0); } to { transform: translateY(100%); } }

        /* --- Animasi Robot AI Widget --- */
        .animate-robot-float { animation: robotFloat 4s ease-in-out infinite; }
        @keyframes robotFloat { 0% { transform: translateY(0); } 50% { transform: translateY(-5px); } 100% { transform: translateY(0); } }

        .animate-robot-wave { animation: robotWave 1s ease-in-out forwards; transform-origin: bottom center; }
        @keyframes robotWave { 0%, 100% { transform: rotate(0deg); } 25% { transform: rotate(15deg); } 75% { transform: rotate(-15deg); } }

        .animate-eye-blink { animation: eyeBlink 4s infinite; }
        @keyframes eyeBlink { 0%, 20%, 22%, 40%, 100% { transform: scaleY(1); } 21%, 41% { transform: scaleY(0.1); } }

        .robot-eye-gaze { transition: transform 0.3s ease-out; }
        .group:hover .robot-eye-gaze { transform: translate(0.5px, 0.5px); }

        .robot-mouth-smile { transition: all 0.3s ease-in-out; }
        .group:hover .robot-mouth-smile { border-radius: 0 0 0.5rem 0.5rem; height: 0.75rem; }

        /* Animasi mengangguk lembut */
        .animate-nodding { animation: nodding 3s ease-in-out infinite; transform-origin: top center; }
        @keyframes nodding { 0%, 100% { transform: rotateX(-2deg); } 50% { transform: rotateX(2deg); } }

        /* Animasi fadeIn/Out untuk bubble chat */
        .animate-bubble-in-out { animation: fadeInOutBubble 5s ease-in-out forwards; }
        @keyframes fadeInOutBubble { 0%, 10% { opacity: 0; transform: translateY(10px); } 20%, 80% { opacity: 1; transform: translateY(0); } 90%, 100% { opacity: 0; transform: translateY(-5px); } }

        /* Animasi ping saat klik */
        .animate-ping-once { animation: ping 0.5s cubic-bezier(0, 0, 0.2, 1); }
        @keyframes ping { 75%, 100% { transform: scale(2); opacity: 0; } }

        /* Untuk efek transformasi ikon (buku, pulpen, laptop) */
        .transform-icon-area { /* Changed from transform-icon to transform-icon-area */
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 3;
            border-radius: inherit; /* Inherit border-radius from parent button */
            background: linear-gradient(45deg, rgba(var(--ai-glow-color), 0.2), transparent); /* Base for glow */
        }

        .group:hover .transform-icon-area {
            opacity: 1;
        }

        /* Gradient animasi untuk ikon */
        .animated-gradient-icon {
            background-size: 200% 200%;
            animation: moveGradient 3s linear infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes moveGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Warna gradient untuk ikon transformasi */
        .gradient-book { background-image: linear-gradient(45deg, #FFD700, #FFA500, #FFD700); } /* Emas */
        .gradient-pen { background-image: linear-gradient(45deg, #00BFFF, #1E90FF, #00BFFF); } /* Biru Cerah */
        .gradient-laptop { background-image: linear-gradient(45deg, #A9A9A9, #D3D3D3, #A9A9A9); } /* Perak/Abu-abu */

        /* Sembunyikan wajah robot saat hover */
        .group:hover .robot-face {
            opacity: 0;
        }

        /* Untuk simulasi bentuk transform */
        .ai-button-shape-transform {
            transition: border-radius 0.3s ease-in-out;
        }
        .group:hover .ai-button-shape-transform {
            border-radius: 0.75rem; /* rounded-xl for slight square */
        }
    </style>
@stack('styles')
</head>

<body class="bg-white text-neutral-800 antialiased font-sans">
@php
    $user = Auth::user();
    $role = $user?->role?->name;
@endphp

<div class="min-h-screen flex flex-col lg:flex-row overflow-hidden">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 flex flex-col min-h-screen relative z-10">

        {{-- HEADER --}}
        <header class="h-16 flex items-center justify-between bg-white border-b border-gray-200 shadow-sm px-4 lg:px-6 relative z-40">

            {{-- Left: Logo & Sidebar Toggle --}}
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
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
                    <button onclick="toggleNotif()" class="relative text-blue-600 hover:text-blue-800 transition-colors duration-200">
                        🔔
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center animate-pulse">3</span>
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-md z-50 p-4 text-sm space-y-2 transform origin-top-right transition-all duration-300 scale-95 opacity-0">
                        <div class="text-gray-700 hover:bg-blue-50 p-2 rounded-md transition-colors duration-150 cursor-pointer">🧾 Tagihan baru untuk kelas 9A</div>
                        <div class="text-gray-700 hover:bg-blue-50 p-2 rounded-md transition-colors duration-150 cursor-pointer">📢 Pengumuman jadwal ujian besok</div>
                        <div class="text-gray-700 hover:bg-blue-50 p-2 rounded-md transition-colors duration-150 cursor-pointer">💬 Konsultasi siswa 7B menunggu</div>
                    </div>
                </div>

                {{-- Dark Mode Toggle --}}
                <button onclick="toggleDarkMode()" class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200 text-xl">
                    <span id="themeIcon">🌙</span>
                </button>

                {{-- User Info --}}
                <div class="relative">
                    <button id="userBtn" onclick="toggleDropdown()" class="flex items-center gap-2 focus:outline-none group">
                        <img src="{{ $user->avatar_url ?? asset('images/avatar.png') }}"
                             alt="Avatar"
                             class="w-9 h-9 rounded-full object-cover border-2 border-blue-500 shadow-sm group-hover:ring-2 ring-blue-300 transition transform group-hover:scale-105 duration-200">
                        <div class="hidden md:flex flex-col text-right">
                            <span class="text-sm font-semibold text-gray-800">{{ $user->name ?? 'Pengguna' }}</span>
                            <span class="text-xs text-gray-500">{{ ucfirst($user->role->name ?? '-') }}</span>
                        </div>
                    </button>

                    {{-- Dropdown --}}
                    <div id="dropdownMenu"
                         class="hidden absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-xl shadow-md z-50 overflow-hidden transform origin-top-right transition-all duration-300 scale-95 opacity-0">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">👤 Profil Saya</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">🔒 Ganti Password</a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">🚪 Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- ALERT STRIP (Dengan Animasi Border RGB) --}}
        <div class="w-full bg-yellow-50 text-yellow-800 text-sm px-4 py-2 overflow-hidden whitespace-nowrap relative z-30 border-t-2 border-b-2 border-transparent rounded-md">
            {{-- Marquee text yang lebih lembut --}}
            <marquee direction="left" scrollamount="3" class="py-1">
                🚨 Perhatian! Pengumpulan nilai akhir maksimal hari Jumat | 🕒 Ujian Tengah Semester dimulai Senin depan
            </marquee>
        </div>

        {{-- CONTENT --}}
        <main class="flex-1 px-6 py-8 bg-white">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('layouts.alert')
        @include('layouts.broadcast')
        <footer class="py-4 text-center text-xs text-neutral-400 border-t border-gray-200">
            &copy; {{ date('Y') }} Yayasan Al-Bahjah • All rights reserved.
        </footer>
    </div>
</div>

{{-- Widget Button untuk Chat AI (Fixed di Kanan Bawah) --}}
@if(Auth::check()) {{-- Tampilkan hanya jika pengguna login --}}
    <div class="fixed bottom-10 right-6 z-50 group cursor-pointer" id="aiChatContainer">
        {{-- Bubble Chat Pesan Positif --}}
        <div id="aiChatBubble" class="absolute bottom-full mb-2 right-0 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-md p-2 text-sm opacity-0 invisible">
            </div>

        <a href="{{ route('core.ai.index') }}"
           id="aiChatButton"
           class="bg-green-400 text-white w-24 h-24 rounded-full shadow-lg ai-button-shape-transform {{-- Tambahkan class untuk shape transform --}}
                  hover:bg-green-500 transition-all duration-300 transform hover:scale-110 hover:shadow-xl
                  flex flex-col items-center justify-center relative overflow-hidden
                  animate-robot-float animate-nodding">

            {{-- Kepala Robot (Bagian Utama) --}}
            <div class="robot-face absolute inset-0 flex flex-col items-center justify-center pt-3 transition-opacity duration-300">
                {{-- Mata --}}
                <div class="flex space-x-1.5 mb-1">
                    <div class="w-3 h-3 bg-white rounded-full flex items-center justify-center overflow-hidden animate-eye-blink">
                        <div class="w-1.5 h-1.5 bg-gray-900 rounded-full robot-eye-gaze"></div>
                    </div>
                    <div class="w-3 h-3 bg-white rounded-full flex items-center justify-center overflow-hidden animate-eye-blink">
                        <div class="w-1.5 h-1.5 bg-gray-900 rounded-full robot-eye-gaze"></div>
                    </div>
                </div>
                {{-- Senyum --}}
                <div class="w-6 h-1.5 bg-gray-900 rounded-b-full robot-mouth-smile"
                     style="border-top-left-radius: 0; border-top-right-radius: 0;"></div>
            </div>

            {{-- Tangan Kiri (melambai) --}}
            <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 -rotate-12 w-8 h-8 bg-green-500 rounded-full origin-right animate-waving-left opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            {{-- Tangan Kanan (diam atau sedikit bergerak) --}}
            <div class="absolute -right-2 top-1/2 transform -translate-y-1/2 rotate-12 w-8 h-8 bg-green-500 rounded-full origin-left opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>


            {{-- Area Transformasi Ikon (Akan muncul saat hover, menggantikan wajah) --}}
            <div id="transformIconArea" class="transform-icon-area absolute inset-0 opacity-0 transition-opacity duration-300">
                {{-- Ikon akan diisi oleh JS --}}
            </div>

            {{-- Label "Chat AI" --}}
            <span class="absolute bottom-2 text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">Chat AI</span>
        </a>
    </div>
@endif
{{-- JAVASCRIPT --}}
<script>
     document.addEventListener('DOMContentLoaded', function() {
        // --- Ambil dan Simpan Sanctum Token ---
        const sanctumTokenMeta = document.querySelector('meta[name="sanctum-token"]');
        if (sanctumTokenMeta) {
            const token = sanctumTokenMeta.getAttribute('content');
            localStorage.setItem('sanctum_api_token', token);
            console.log('Sanctum Token disimpan ke localStorage.');
            sanctumTokenMeta.remove(); // Hapus meta tag setelah token diambil
        } else {
            console.log('Tidak ada sanctum token di meta tag. Mungkin sudah ada di localStorage atau belum login.');
            // Jika token tidak ada di meta tag saat ini, bisa jadi sudah ada di localStorage
            // atau user belum login via sesi web.
        }
    });

    // --- Animasi CSS (Inline untuk self-containment) ---
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes robotFloat {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }
        .animate-robot-float { animation: robotFloat 4s ease-in-out infinite; }

        @keyframes robotWave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-15deg); }
        }
        .animate-robot-wave { animation: robotWave 1s ease-in-out forwards; transform-origin: bottom center; }

        @keyframes eyeBlink {
            0%, 20%, 22%, 40%, 100% { transform: scaleY(1); }
            21%, 41% { transform: scaleY(0.1); }
        }
        .animate-eye-blink { animation: eyeBlink 4s infinite; }

        .robot-eye-gaze { transition: transform 0.3s ease-out; }
        .group:hover .robot-eye-gaze { transform: translate(0.5px, 0.5px); }

        .robot-mouth-smile { transition: all 0.3s ease-in-out; }
        .group:hover .robot-mouth-smile { border-radius: 0 0 0.5rem 0.5rem; height: 0.75rem; }

        /* Animasi mengangguk lembut */
        @keyframes nodding {
            0%, 100% { transform: rotateX(-2deg); }
            50% { transform: rotateX(2deg); }
        }
        .animate-nodding { animation: nodding 3s ease-in-out infinite; transform-origin: top center; }

        /* Animasi fadeIn/Out untuk bubble chat */
        @keyframes fadeInOutBubble {
            0%, 10% { opacity: 0; transform: translateY(10px); }
            20%, 80% { opacity: 1; transform: translateY(0); }
            90%, 100% { opacity: 0; transform: translateY(-5px); }
        }
        .animate-bubble-in-out { animation: fadeInOutBubble 5s ease-in-out forwards; }

        /* Animasi ping saat klik */
        @keyframes ping-once {
            75%, 100% { transform: scale(2); opacity: 0; }
        }
        .animate-ping-once { animation: ping-once 0.5s cubic-bezier(0, 0, 0.2, 1); }

        /* Untuk efek transformasi ikon (buku, pulpen, laptop) */
        .transform-icon-area {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 3;
            /* Tambahan untuk background gradient yang bergerak pada tombol */
            background: linear-gradient(45deg, rgba(var(--color-accent-start), 0.8), rgba(var(--color-accent-end), 0.8));
            background-size: 200% 200%;
            animation: moveButtonGradient 5s linear infinite; /* Animasi gradien tombol */
            border-radius: inherit; /* Pastikan bentuknya sesuai tombol utama */
        }
        @keyframes moveButtonGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .group:hover .transform-icon-area {
            opacity: 1;
        }

        /* Gradient animasi untuk ikon (di dalam transform-icon-area) */
        .animated-gradient-icon {
            background-size: 200% 200%;
            animation: moveIconGradient 3s linear infinite; /* Animasi gradien ikon */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes moveIconGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Warna gradient untuk ikon transformasi */
        .gradient-book { background-image: linear-gradient(45deg, #FFD700, #FFA500, #FFD700); } /* Emas */
        .gradient-pen { background-image: linear-gradient(45deg, #00BFFF, #1E90FF, #00BFFF); } /* Biru Cerah */
        .gradient-laptop { background-image: linear-gradient(45deg, #A9A9A9, #D3D3D3, #A9A9A9); } /* Perak/Abu-abu */

        /* Sembunyikan wajah robot saat hover */
        .group:hover .robot-face {
            opacity: 0;
        }

        /* Untuk simulasi bentuk transform pada tombol utama */
        .ai-button-shape-transform {
            transition: border-radius 0.3s ease-in-out;
        }
        .group:hover .ai-button-shape-transform {
            border-radius: 0.75rem; /* rounded-xl for slight square */
        }
    `;
    document.head.appendChild(style);

    document.addEventListener('DOMContentLoaded', function() {
        const aiChatButton = document.getElementById('aiChatButton');
        const aiChatBubble = document.getElementById('aiChatBubble');
        const aiChatContainer = document.getElementById('aiChatContainer');
        const robotFace = aiChatButton.querySelector('.robot-face');
        const transformIconArea = document.getElementById('transformIconArea');
        const leftHand = aiChatButton.querySelector('.left-hand');
        const rightHand = aiChatButton.querySelector('.right-hand');

        // Daftar ikon dan kelas gradientnya
        const transformIcons = [
            { svg_path: `<path d="M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2zm8-11v4m-2-2h4"></path>`, class: 'gradient-book' }, // Buku
            { svg_path: `<path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path>`, class: 'gradient-pen' }, // Pulpen
            { svg_path: `<path d="M5 12h14M2 10a2 2 0 012-2h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8z"></path>`, class: 'gradient-laptop' } // Laptop
        ];
        let currentTransformIconIndex = 0;

        // Fungsi untuk mengupdate ikon transformasi
        function updateTransformIcon() {
            const iconData = transformIcons[currentTransformIconIndex % transformIcons.length];
            transformIconArea.innerHTML = `<svg class="w-12 h-12 text-white animated-gradient-icon ${iconData.class}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">${iconData.svg_path}</svg>`;
            currentTransformIconIndex++;
        }

        // Logic Bubble Chat
        const positiveMessages = [
            "Assalamualaikum, semoga hari ini berkah.",
            "Bismillah, mari mulai dengan semangat!",
            "Semoga Allah mudahkan urusan Anda.",
            "Ada yang bisa saya bantu?",
            "Senantiasa berikhtiar dan bertawakal.",
            "Jadikan setiap langkah ibadah.",
            "Tanya AI: Bagaimana cara mencari data siswa?",
            "Tanya AI: Bagaimana cara membuat laporan nilai?",
            "Tanya AI: Saya butuh bantuan untuk jadwal pelajaran."
        ];
        let messageIndex = 0;
        let messageInterval;
        let initialBubbleTimer; // Untuk 20 detik pertama

        function showPositiveMessage() {
            aiChatBubble.textContent = positiveMessages[Math.floor(Math.random() * positiveMessages.length)]; // Pesan acak
            aiChatBubble.classList.remove('opacity-0', 'invisible');
            aiChatBubble.classList.add('animate-bubble-in-out');
            
            aiChatBubble.addEventListener('animationend', function handler() {
                aiChatBubble.classList.remove('animate-bubble-in-out');
                aiChatBubble.classList.add('opacity-0', 'invisible');
                aiChatBubble.removeEventListener('animationend', handler);
            });
        }

        // Durasi acak untuk munculnya bubble chat setelah 20 detik pertama
        function startRandomBubbleInterval() {
            clearInterval(messageInterval); // Hentikan interval lama jika ada
            const randomDelay = Math.random() * (60000 - 20000) + 20000; // Antara 20-60 detik
            messageInterval = setInterval(showPositiveMessage, randomDelay);
        }

        // Logic Awal: Tampilkan bubble chat selama 20 detik pertama
        if (aiChatContainer) {
            // Tampilkan pesan pertama segera, lalu mulai interval acak setelah 20 detik
            initialBubbleTimer = setTimeout(() => {
                showPositiveMessage();
                startRandomBubbleInterval();
            }, 20000); // Tunggu 20 detik sebelum pesan pertama muncul, lalu acak
        }

        // Interaksi Tombol AI Chat
        if (aiChatButton) {
            aiChatButton.addEventListener('click', function(event) {
                // event.preventDefault(); // Uncomment jika tidak ingin navigasi langsung untuk demo

                clearInterval(messageInterval); // Hentikan bubble chat
                clearTimeout(initialBubbleTimer); // Hentikan timer awal juga
                aiChatBubble.classList.remove('animate-bubble-in-out', 'opacity-100');
                aiChatBubble.classList.add('opacity-0', 'invisible');

                this.classList.add('animate-ping-once');
                if (leftHand) leftHand.classList.add('animate-robot-wave');
                if (rightHand) rightHand.classList.add('animate-robot-wave');

                setTimeout(() => {
                    this.classList.remove('animate-ping-once');
                    if (leftHand) leftHand.classList.remove('animate-robot-wave');
                    if (rightHand) rightHand.classList.remove('animate-robot-wave');
                    // window.location.href = this.href; // Aktifkan ini untuk navigasi
                }, 500);
            });

            aiChatButton.addEventListener('mouseover', function() {
                robotFace.style.opacity = '0'; // Sembunyikan wajah robot
                transformIconArea.style.opacity = '1'; // Tampilkan ikon transformasi
                updateTransformIcon(); // Update ikon saat hover

                if (leftHand) leftHand.classList.add('animate-robot-wave');
                if (rightHand) rightHand.classList.add('animate-robot-wave');

                clearInterval(messageInterval); // Hentikan bubble chat saat hover
                clearTimeout(initialBubbleTimer); // Hentikan timer awal
                aiChatBubble.classList.remove('animate-bubble-in-out', 'opacity-100');
                aiChatBubble.classList.add('opacity-0', 'invisible');
            });

            aiChatButton.addEventListener('mouseout', function() {
                robotFace.style.opacity = '1'; // Tampilkan kembali wajah robot
                transformIconArea.style.opacity = '0'; // Sembunyikan ikon transformasi
                if (leftHand) leftHand.classList.remove('animate-robot-wave');
                if (rightHand) rightHand.classList.remove('animate-robot-wave');

                // Lanjutkan bubble chat setelah mouse out
                if (aiChatContainer) {
                    startRandomBubbleInterval(); // Mulai interval acak setelah mouse out
                    showPositiveMessage(); // Tampilkan pesan segera setelah mouse out
                }
            });
        }
    });

    // Existing JavaScript functions:
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('scale-95');
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('scale-100');
        menu.classList.toggle('opacity-100');
    }

    function toggleNotif() {
        const notif = document.getElementById('notifDropdown');
        notif.classList.toggle('hidden');
        notif.classList.toggle('scale-95');
        notif.classList.toggle('opacity-0');
        notif.classList.toggle('scale-100');
        notif.classList.toggle('opacity-100');
    }

    function toggleDarkMode() {
        const icon = document.getElementById('themeIcon');
        icon.innerText = (icon.innerText === '🌙') ? '☀️' : '🌙';
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
        document.getElementById('themeIcon').textContent = '🌙';
    };

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden-mobile');
        sidebar.classList.toggle('translate-x-full');
    }

    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdownMenu');
        const userBtn = document.getElementById('userBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const notifBtn = document.querySelector('button[onclick="toggleNotif()"]');

        if (dropdown && userBtn && !dropdown.contains(event.target) && !userBtn.contains(event.target)) {
            dropdown.classList.add('hidden', 'scale-95', 'opacity-0');
            dropdown.classList.remove('scale-100', 'opacity-100');
        }

        if (notifDropdown && notifBtn && !notifDropdown.contains(event.target) && !notifBtn.contains(event.target)) {
            notifDropdown.classList.add('hidden', 'scale-95', 'opacity-0');
            notifDropdown.classList.remove('scale-100', 'opacity-100');
        }
    });
</script>
@stack('scripts')
</body>
</html>