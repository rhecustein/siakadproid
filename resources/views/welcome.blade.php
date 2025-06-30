<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selamat Datang • SIAKAD Al-Bahjah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased leading-relaxed font-sans overflow-x-hidden">

<header class="bg-gradient-to-r from-blue-700 to-indigo-700 shadow-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="h-8 opacity-90 filter drop-shadow-md animate-logo-glow" alt="Logo">
            <h1 class="text-2xl font-extrabold text-white tracking-wide animate-logo-glow"> {{-- Applied glow here too --}}
                SIAKAD Al-Bahjah
            </h1>
        </div>
        <a href="{{ route('login') }}"
           class="text-sm font-semibold text-blue-700 bg-white hover:bg-blue-50 px-6 py-2.5 rounded-full shadow-lg transition-all duration-300 transform hover:-translate-y-1 gradient-border-running"> {{-- Added gradient border running --}}
            Masuk
        </a>
    </div>
</header>


<section class="relative overflow-hidden bg-gradient-to-br from-neutral-50 to-blue-50 text-neutral-800 py-32 lg:py-48 flex items-center justify-center min-h-[70vh]">
    {{-- Animasi Latar Belakang Bergelombang/Mengalir --}}
    <div class="hero-background-animation"></div>

    <img src="{{ asset('images/banner-soft-bg.png') }}"
         alt="Background Waves"
         class="absolute inset-0 w-full h-full object-cover opacity-30 pointer-events-none select-none z-10" />

    <div class="relative z-20 max-w-5xl mx-auto text-center px-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIAKAD Al-Bahjah" class="w-40 mx-auto mb-6 drop-shadow-lg animate-logo-glow animate-fade-in"> {{-- Larger logo, AI glow --}}
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-6 text-gray-900 leading-tight animate-fade-in animate-delay-100">
            Sistem Informasi Akademik Terpadu<br class="hidden sm:inline">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Al-Bahjah</span>
        </h2>
        <p class="text-lg sm:text-xl font-light max-w-3xl mx-auto text-gray-700 mb-10 animate-fade-in animate-delay-200">
            Menghubungkan puluhan cabang, ratusan sekolah, guru, orang tua, dan siswa dalam satu ekosistem digital yang efisien dan cerdas.
        </p>

        <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 mb-12 text-lg text-gray-700 font-semibold">
            <div class="staggered-metric-item animate-fade-in-up">50+ <span class="font-normal text-gray-500">Cabang Terintegrasi</span></div>
            <div class="staggered-metric-item animate-fade-in-up">200+ <span class="font-normal text-gray-500">Sekolah Terpusat</span></div>
            <div class="staggered-metric-item animate-fade-in-up">12.000+ <span class="font-normal text-gray-500">Pengguna Aktif</span></div>
            <div class="staggered-metric-item animate-fade-in-up">AI Memproses <span class="font-normal text-gray-500">1 Juta+ Data/Hari</span></div>
        </div>


        <a href="{{ route('login') }}"
           class="inline-block bg-blue-600 text-white font-semibold px-8 py-4 rounded-full shadow-xl transition-all duration-300
                  hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 animate-pulse-grow gradient-border-btn"> {{-- Added gradient border --}}
            Mulai Sekarang
            <span class="ml-2 inline-block transform -rotate-45">🚀</span>
        </a>
    </div>
</section>


<section class="py-24 bg-white text-gray-900">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-3xl sm:text-4xl font-extrabold mb-4 tracking-tight animate-fade-in-up">
            Alur Data Terpusat: Jantung Ekosistem Al-Bahjah
        </h3>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-16 animate-fade-in-up animate-delay-100">
            Kami mengubah data yang tersebar dari puluhan cabang dan ratusan sekolah menjadi satu sumber informasi yang cerdas dan terintegrasi AI.
        </p>

        <div class="relative flex flex-col items-center justify-center space-y-12 lg:space-y-0 lg:flex-row lg:space-x-16 min-h-[400px]">
            {{-- Data Streams (Placeholder - with simple animated lines) --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                {{-- Horizontal streams from left --}}
                <div class="absolute top-[10%] left-[calc(10%-100px)] w-[calc(30%+100px)] h-0.5 bg-gray-300 transform -translate-y-1/2 data-stream-line animate-data-stream" style="animation-delay: 0.5s;"></div>
                <div class="absolute top-[30%] left-[calc(10%-100px)] w-[calc(30%+100px)] h-0.5 bg-gray-300 transform -translate-y-1/2 data-stream-line animate-data-stream" style="animation-delay: 1s;"></div>
                
                {{-- Vertical streams to center --}}
                <div class="absolute top-[calc(10%+10px)] left-[39.5%] h-[calc(30%-10px)] w-0.5 bg-gray-300 data-stream-line vertical animate-data-stream-vertical" style="animation-delay: 1.5s;"></div>
                <div class="absolute top-[calc(30%+10px)] left-[39.5%] h-[calc(10%+10px)] w-0.5 bg-gray-300 data-stream-line vertical animate-data-stream-vertical" style="animation-delay: 2s;"></div>

                {{-- Horizontal streams from right --}}
                <div class="absolute top-[10%] right-[calc(10%-100px)] w-[calc(30%+100px)] h-0.5 bg-gray-300 transform -translate-y-1/2 data-stream-line animate-data-stream" style="animation-delay: 0.5s; animation-direction: reverse;"></div>
                <div class="absolute top-[30%] right-[calc(10%-100px)] w-[calc(30%+100px)] h-0.5 bg-gray-300 transform -translate-y-1/2 data-stream-line animate-data-stream" style="animation-delay: 1s; animation-direction: reverse;"></div>

                {{-- Vertical streams from center --}}
                 <div class="absolute top-[calc(10%+10px)] right-[39.5%] h-[calc(30%-10px)] w-0.5 bg-gray-300 data-stream-line vertical animate-data-stream-vertical" style="animation-delay: 1.5s; animation-direction: reverse;"></div>
                <div class="absolute top-[calc(30%+10px)] right-[39.5%] h-[calc(10%+10px)] w-0.5 bg-gray-300 data-stream-line vertical animate-data-stream-vertical" style="animation-delay: 2s; animation-direction: reverse;"></div>
            </div>


            {{-- Source Nodes --}}
            <div class="flex flex-wrap justify-center gap-8 lg:absolute lg:top-0 lg:left-0 lg:w-1/3 lg:flex-col lg:items-end lg:pr-8 lg:space-y-8">
                <div class="bg-gray-50 p-4 rounded-xl shadow-md text-center animate-fade-in-up">
                    <svg class="w-10 h-10 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    <p class="text-sm font-semibold">Cabang & Sekolah</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-md text-center animate-fade-in-up animate-delay-100">
                    <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <p class="text-sm font-semibold">Guru & Staf</p>
                </div>
            </div>

            {{-- Central AI Hub --}}
            <div class="relative z-10 w-48 h-48 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-purple-600 shadow-xl ai-core-glow-pulse animate-fade-in animate-delay-300">
                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                <div class="absolute text-white text-xs font-bold -bottom-6">INTEGRASI AI</div>
            </div>

            {{-- Output Nodes --}}
            <div class="flex flex-wrap justify-center gap-8 lg:absolute lg:top-0 lg:right-0 lg:w-1/3 lg:flex-col lg:items-start lg:pl-8 lg:space-y-8">
                <div class="bg-gray-50 p-4 rounded-xl shadow-md text-center animate-fade-in-up animate-delay-200">
                    <svg class="w-10 h-10 text-orange-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M3 19l9 3 9-3m0 0v-5m0 0H9m12 0L9 9m9 3v5m-1 1H7"></path></svg>
                    <p class="text-sm font-semibold">Dashboard Terpadu</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-md text-center animate-fade-in-up animate-delay-300">
                    <svg class="w-10 h-10 text-purple-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l-3 3m0 0l-3-3m3 3V5m6 2H9a2 2 0 00-2 2v2m2 0h6m-6 0h-2m2 0v2m2 0h2m-2 0V9a2 2 0 012-2h2m4 0h2m-2 4h2m-2 0v2m2 0h2m-2 0V9a2 2 0 00-2-2h-2m0 0V5a2 2 0 01-2-2H9a2 2 0 01-2 2v2"></path></svg>
                    <p class="text-sm font-semibold">Rekomendasi AI</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-3xl sm:text-4xl font-extrabold text-center mb-16 text-gray-900 tracking-tight">
            Fitur Unggulan Ekosistem Digital Al-Bahjah
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @php
                $features = [
                    ['title' => 'Raport Digital Interaktif', 'description' => 'Akses nilai dan cetak raport secara online, didukung visualisasi progres.', 'icon_path' => 'images/icons/raport.png', 'gradient' => 'from-blue-500 to-green-400', 'ai_badge' => false],
                    ['title' => 'Absensi Cerdas & Notifikasi', 'description' => 'Monitoring kehadiran dengan fingerprint & notifikasi real-time ke wali santri.', 'icon_path' => 'images/icons/absensi.png', 'gradient' => 'from-emerald-500 to-cyan-400', 'ai_badge' => true],
                    ['title' => 'Pembayaran Terintegrasi Cashless', 'description' => 'SPP & transaksi kantin menggunakan sistem saldo digital yang aman dan mudah.', 'icon_path' => 'images/icons/cashless.png', 'gradient' => 'from-pink-500 to-yellow-400', 'ai_badge' => false],
                    ['title' => 'AI Konsultasi Pintar', 'description' => 'Orang tua dan guru dapat berkonsultasi seputar akademik dan non-akademik via AI.', 'icon_path' => 'images/icons/ai.png', 'gradient' => 'from-purple-600 to-pink-400', 'ai_badge' => true],
                    ['title' => 'Analisis & Monitoring Akademik', 'description' => 'Pantau progres belajar, riwayat pelanggaran, dan grafik nilai siswa secara mendalam.', 'icon_path' => 'images/icons/monitor.png', 'gradient' => 'from-orange-500 to-yellow-400', 'ai_badge' => true],
                    ['title' => 'Portal Wali Santri Multi-fungsi', 'description' => 'Dapatkan laporan real-time, akses jadwal, dan pengumuman penting langsung di genggaman wali.', 'icon_path' => 'images/icons/portal.png', 'gradient' => 'from-sky-400 to-indigo-500', 'ai_badge' => false],
                    ['title' => 'Manajemen Kantin Digital', 'description' => 'Sistem pembelian snack & makan siang dengan saldo digital, lengkap dengan stok & laporan.', 'icon_path' => 'images/icons/kantin.png', 'gradient' => 'from-green-300 to-lime-400', 'ai_badge' => false],
                    ['title' => 'Sistem Parkir Otomatis', 'description' => 'Integrasi RFID & CCTV untuk manajemen parkir otomatis yang aman dan terdata.', 'icon_path' => 'images/icons/parkir.png', 'gradient' => 'from-red-400 to-yellow-300', 'ai_badge' => false],
                    ['title' => 'Arsip & Dokumen Digital Terpadu', 'description' => 'Semua dokumen dan berkas siswa tersimpan aman, mudah diakses, dan terorganisir rapi.', 'icon_path' => 'images/icons/arsip.png', 'gradient' => 'from-blue-600 to-gray-500', 'ai_badge' => false],
                    ['title' => 'Pengumuman & Notifikasi Otomatis', 'description' => 'Kirim notifikasi penting via portal, aplikasi mobile, dan SMS gateway secara otomatis.', 'icon_path' => 'images/icons/pengumuman.png', 'gradient' => 'from-yellow-400 to-orange-500', 'ai_badge' => true],
                ];
            @endphp

            @foreach ($features as $index => $feature)
                <div class="feature-card rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: {{ 0.1 * $index + 0.2 }}s;">
                    <div class="h-40 flex items-center justify-center {{ $feature['gradient'] }} relative rounded-t-2xl overflow-hidden"> {{-- Added relative for badge positioning, overflow hidden for shimmer --}}
                        <img src="{{ asset($feature['icon_path']) }}" alt="{{ $feature['title'] }}" class="h-28 drop-shadow-xl saturate-150 feature-icon-pulse">
                        <div class="feature-card-shimmer absolute inset-0"></div> {{-- Shimmer overlay --}}

                        @if($feature['ai_badge'])
                            <span class="absolute top-3 right-3 bg-purple-600 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-md animate-pulse">AI-Powered</span>
                        @endif
                    </div>
                    <div class="bg-white text-center py-6 px-4">
                        <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>


<section class="py-24 bg-gradient-to-br from-white to-neutral-100 text-gray-900">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-3xl sm:text-4xl font-extrabold mb-4 tracking-tight animate-fade-in-up">
            Visi Pondok Modern Al-Bahjah: Menerangi Masa Depan dengan AI
        </h3>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-16 animate-fade-in-up animate-delay-100">
            SIAKAD Al-Bahjah adalah fondasi digital kami untuk mewujudkan pendidikan Islami modern yang cerdas dan holistik.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center animate-fade-in-up">
                <svg class="w-16 h-16 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.298.927 3.58.605z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <h4 class="text-xl font-bold mb-2">Efisiensi Operasional</h4>
                <p class="text-sm text-gray-600">Automatisasi tugas administratif untuk fokus lebih pada inti pendidikan.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center animate-fade-in-up animate-delay-100">
                <svg class="w-16 h-16 text-purple-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v11m0 0l-1.558 3.568A1.5 1.5 0 0110.5 20h3a1.5 1.5 0 011.558-1.432L12 14m0 0H9.545C11.332 10.741 13 8 13 8h2m-6 4v5m-4.673 0H5.5c-1.125 0-2.072-.51-2.5-1.353C2.5 14.5 2.5 13.5 2.5 13.5V6.5c0-.923.474-1.727 1.258-2.182M18.455 17H18.5c1.125 0 2.072-.51 2.5-1.353C21.5 14.5 21.5 13.5 21.5 13.5V6.5c0-.923-.474-1.727-1.258-2.182"></path></svg>
                <h4 class="text-xl font-bold mb-2">Pembelajaran Adaptif</h4>
                <p class="text-sm text-gray-600">Kurikulum personalisasi & evaluasi berbasis data untuk santri.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center animate-fade-in-up animate-delay-200">
                <svg class="w-16 h-16 text-emerald-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h4 class="text-xl font-bold mb-2">Pengembangan Santri Holistik</h4>
                <p class="text-sm text-gray-600">Pantau progres spiritual, akademik, dan akhlak santri secara menyeluruh.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center animate-fade-in-up animate-delay-300">
                <svg class="w-16 h-16 text-red-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.943 1.303L14 10l-4 4m6-6l2-2m-2 2a2 2 0 00-2-2h-3.28a2 2 0 00-1.943 1.303L6 10l4 4m-4 0l-2-2m2 2a2 2 0 01-2-2v-3.28a2 2 0 011.303-1.943L10 6l4 4m-4 0l2-2m-2 2a2 2 0 002-2V9.5L14 10l-4-4m6 6v3.28a2 2 0 01-1.303 1.943L14 18l-4-4m6-6l2-2"></path></svg>
                <h4 class="text-xl font-bold mb-2">Konektivitas Tanpa Batas</h4>
                <p class="text-sm text-gray-600">Menghubungkan seluruh stakeholder (wali, guru, santri) secara real-time.</p>
            </div>
        </div>
    </div>
</section>


<section class="py-24 bg-gradient-to-br from-blue-700 to-indigo-800 text-white text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-3xl lg:text-5xl font-extrabold mb-6 leading-tight drop-shadow-md animate-fade-in-up">
            Siap Menjadi Bagian dari Ekosistem Digital Al-Bahjah?
        </h3>
        <p class="text-lg opacity-90 mb-10 max-w-2xl mx-auto animate-fade-in animate-delay-100">
            Jelajahi bagaimana SIAKAD kami dapat merevolusi pengelolaan akademik dan komunikasi di lembaga Anda.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block bg-white text-blue-700 font-bold px-8 py-4 rounded-full shadow-xl transition-all duration-300
                  hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-white/50 animate-pulse-grow group gradient-border-btn"> {{-- Added gradient border --}}
            Gabung Sekarang
            <span class="ml-2 inline-block transform transition-transform duration-300 group-hover:rotate-45">→</span> {{-- Changed to rotate on hover --}}
        </a>
    </div>
</section>


<footer class="text-center text-sm text-neutral-500 py-8 border-t border-neutral-200 bg-white">
    &copy; {{ date('Y') }} Yayasan Al-Bahjah • All Rights Reserved.
</footer>

</body>
</html>