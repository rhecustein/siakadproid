@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-gray-900 mb-6 tracking-tight">
    {{-- Mengganti gradien teks agar lebih minimalis dan elegan, atau bisa tetap gradien --}}
    👋 Selamat Datang, Superadmin!
</h1>
<p class="text-gray-600 mb-8 max-w-2xl">
    Ringkasan sistem SIAKAD Al-Bahjah secara menyeluruh. Kelola dan pantau semua aspek dengan efisien.
</p>

@php
    $user = Auth::user();
    $role = $user?->role?->name;
@endphp

@if ($role === 'admin') {{-- Asumsi 'admin' adalah role superadmin Anda --}}

    <!-- OVERVIEW CARDS (Metrik Kunci) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transition-transform hover:scale-[1.02] duration-300">
            <h2 class="text-sm text-gray-500 uppercase font-semibold mb-2">Total Pengguna Aktif</h2>
            <p class="text-3xl font-bold text-blue-600">
                <span class="font-mono">2500</span>
            </p>
            <p class="text-xs text-gray-400 mt-2">Termasuk Siswa, Guru, & Staf</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transition-transform hover:scale-[1.02] duration-300">
            <h2 class="text-sm text-gray-500 uppercase font-semibold mb-2">Jumlah Siswa</h2>
            <p class="text-3xl font-bold text-green-600">
                <span class="font-mono">1200</span>
            </p>
            <p class="text-xs text-gray-400 mt-2">({{ date('Y') }}/{{ date('Y') + 1 }})</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transition-transform hover:scale-[1.02] duration-300">
            <h2 class="text-sm text-gray-500 uppercase font-semibold mb-2">Pendapatan Bulan Ini</h2>
            <p class="text-3xl font-bold text-purple-600">
                <span class="font-mono">Rp 35M</span>
            </p>
            <p class="text-xs text-gray-400 mt-2">Target Rp 50M</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transition-transform hover:scale-[1.02] duration-300">
            <h2 class="text-sm text-gray-500 uppercase font-semibold mb-2">Tagihan Belum Lunas</h2>
            <p class="text-3xl font-bold text-red-600">
                <span class="font-mono">185</span>
            </p>
            <p class="text-xs text-gray-400 mt-2">Total Rp 27jt</p>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
        @php
            $quickActions = [
                ['label' => 'Kelola Pengguna', 'icon' => '👥', 'route' => 'core.users.index'],
                ['label' => 'Buat Pengumuman', 'icon' => '📢', 'route' => 'communication.announcements.create'],
                ['label' => 'Verifikasi PPDB', 'icon' => '✅', 'route' => 'admission.verifications.index'],
                ['label' => 'Input Transaksi', 'icon' => '💸', 'route' => 'finance.incoming-transactions.create'],
                ['label' => 'Atur Jadwal', 'icon' => '🗓️', 'route' => 'academic.timetables.index'],
                ['label' => 'Laporan Keuangan', 'icon' => '📈', 'route' => 'finance.financial-reports.index'],
            ];
        @endphp
        @foreach ($quickActions as $action)
            <a href="{{ route($action['route']) }}" class="bg-white rounded-xl p-4 flex flex-col items-center justify-center
               hover:scale-105 transition-transform duration-300 shadow-md border border-gray-100
               hover:border-blue-300 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <div class="text-4xl mb-2">{{ $action['icon'] }}</div>
                <div class="text-sm font-semibold text-gray-800 text-center">{{ $action['label'] }}</div>
            </a>
        @endforeach
    </div>

    <!-- DATA VISUALIZATION (Grafik) -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Analisis Data</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Pemasukan & Pengeluaran (Tahun Ini)</h3>
            <div class="flex-1">
                <canvas id="chartKeuangan"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Kehadiran Siswa (Bulan Ini)</h3>
            <div class="flex-1 flex items-center justify-center">
                <canvas id="chartAbsensi" class="max-h-64"></canvas>
            </div>
        </div>
    </div>

    <!-- AI INSIGHT & RECENT ACTIVITY -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </span>
                Insight & Rekomendasi AI
            </h3>
            <ul class="text-sm space-y-3 text-gray-700">
                <li class="flex items-start">
                    <span class="mr-2 text-green-500">•</span>
                    <p>
                        **Analisis Tren PPDB:** Peningkatan 15% pendaftar di bulan ini dibandingkan tahun lalu.
                        <a href="#" class="text-blue-600 hover:underline text-xs block mt-1">Detail Laporan PPDB</a>
                    </p>
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-red-500">•</span>
                    <p>
                        **Perhatian Keuangan:** 27% tagihan bulanan masih belum lunas. Disarankan mengirim notifikasi massal.
                        <a href="#" class="text-blue-600 hover:underline text-xs block mt-1">Kirim Notifikasi Sekarang</a>
                    </p>
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-yellow-500">•</span>
                    <p>
                        **Efisiensi Absensi:** Waktu input absensi guru rata-rata meningkat 5 menit.
                        <a href="#" class="text-blue-600 hover:underline text-xs block mt-1">Tinjau Proses Absensi</a>
                    </p>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Sistem Terbaru</h3>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="mr-2 text-gray-400">🕒</span>
                    <p>
                        <strong class="font-semibold">2 jam lalu:</strong> Guru Budi (Matematika) mengunggah materi baru untuk kelas 8A.
                    </p>
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-gray-400">🕒</span>
                    <p>
                        <strong class="font-semibold">5 jam lalu:</strong> Wali Santri Siti melakukan pembayaran SPP via Virtual Account.
                    </p>
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-gray-400">🕒</span>
                    <p>
                        <strong class="font-semibold">Kemarin:</strong> Admin X menambahkan 3 siswa baru ke sistem.
                    </p>
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-gray-400">🕒</span>
                    <p>
                        <strong class="font-semibold">Kemarin:</strong> Sistem mendeteksi 12 karyawan belum melakukan check-in.
                    </p>
                </li>
            </ul>
        </div>
    </div>

    <!-- PENDING APPROVALS / TASKS -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Persetujuan & Tugas Menunggu</h2>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-10">
        <ul class="space-y-4 text-gray-700">
            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <span class="flex items-center gap-2">
                    <span class="text-yellow-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    Permintaan Cuti Karyawan: 3 Permintaan Baru
                </span>
                <button class="bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">Tinjau</button>
            </li>
            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <span class="flex items-center gap-2">
                    <span class="text-orange-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span>
                    Verifikasi Dokumen PPDB: 5 Berkas Baru
                </span>
                <button class="bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">Verifikasi</button>
            </li>
            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <span class="flex items-center gap-2">
                    <span class="text-teal-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M17 11h.01M7 16h.01M17 16h.01M7 21h.01M17 21h.01M3 15V9a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                    </span>
                    Jadwal Kosong Ruangan: 2 Ruangan Perlu Penyesuaian
                </span>
                <button class="bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">Atur</button>
            </li>
        </ul>
    </div>

    <!-- USER REVIEWS / FEEDBACK (Komponen Baru) -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Umpan Balik Terbaru</h2>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-10">
        <ul class="space-y-4 text-gray-700">
            <li class="border-b border-gray-200 pb-3 last:border-b-0">
                <div class="flex justify-between items-center text-sm mb-1">
                    <span class="font-semibold text-gray-800">Orang Tua Murid (Kelas 7B)</span>
                    <span class="text-gray-500 text-xs">2 hari lalu</span>
                </div>
                <p class="text-gray-600 text-sm italic">"Fitur absensi harian sangat membantu, terima kasih!"</p>
            </li>
            <li class="border-b border-gray-200 pb-3 last:border-b-0">
                <div class="flex justify-between items-center text-sm mb-1">
                    <span class="font-semibold text-gray-800">Guru Kimia (Kelas 11A)</span>
                    <span class="text-gray-500 text-xs">4 hari lalu</span>
                </div>
                <p class="text-gray-600 text-sm italic">"Ada sedikit bug saat upload materi di jam sibuk, bisa dicek?"</p>
                <button class="text-blue-500 text-xs mt-1 hover:underline">Tinjau Bug</button>
            </li>
        </ul>
        <button class="mt-6 w-full text-center py-2 border border-blue-200 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">Lihat Semua Umpan Balik</button>
    </div>

    <!-- SYSTEM HEALTH MONITOR (Komponen Baru) -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Status Sistem</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4">
            <div class="text-green-500 text-4xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.92 12c0 3.072 1.47 5.86 3.813 7.755L12 22l5.267-2.91C20.627 18.257 22 15.176 22 12c0-3.328-1.58-6.398-4.004-8.016z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Server Utama</h3>
                <p class="text-gray-600 text-sm">Status: <span class="font-bold text-green-600">Online</span></p>
                <p class="text-gray-500 text-xs">Latensi: 25ms</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4">
            <div class="text-orange-500 text-4xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Antrian Pekerjaan</h3>
                <p class="text-gray-600 text-sm">Status: <span class="font-bold text-orange-600">Normal</span></p>
                <p class="text-gray-500 text-xs">Pekerjaan Tertunda: 2</p>
            </div>
        </div>
    </div>

    <!-- USER LOCATION MAP (Komponen Baru - Konseptual) -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Distribusi Pengguna Global</h2>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-10 h-96 flex items-center justify-center">
        <p class="text-gray-500 text-lg">Peta interaktif (mis. dengan Leaflet/Google Maps API) akan ditampilkan di sini.</p>
        <p class="text-center text-sm text-gray-400 mt-2">
            <br>
            <span class="text-blue-500">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </span>
            Lokasi Pengguna Aktif & Cabang Sekolah
        </p>
    </div>

@else
    <div class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200 shadow-sm">
        <p class="font-semibold">Akses Ditolak:</p>
        <p class="text-sm">Anda tidak memiliki izin untuk melihat dashboard ini. Silakan hubungi administrator sistem jika ini adalah kesalahan.</p>
    </div>
@endif

<!-- Chart.js dan Javascript Dashboard -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Notifikasi Pop-up (Tetap dipertahankan)
    setTimeout(() => {
        const notifBox = document.getElementById('notifBox');
        if (notifBox) { // Pastikan elemen ada sebelum memanipulasinya
            notifBox.classList.remove('translate-x-full');
            notifBox.classList.add('translate-x-0');
        }
    }, 1000);

    // Chart Keuangan
    const chartKeuanganCtx = document.getElementById('chartKeuangan');
    if (chartKeuanganCtx) {
        new Chart(chartKeuanganCtx, {
            type: 'line', // Mengganti bar menjadi line chart untuk tren
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: [15, 22, 18, 26, 32, 28, 35, 30, 40, 38, 45, 50],
                        borderColor: '#3b82f6', // blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.2)', // blue-500 dengan transparansi
                        fill: true,
                        tension: 0.3 // Sedikit lengkungan pada garis
                    },
                    {
                        label: 'Pengeluaran',
                        data: [8, 17, 12, 21, 25, 20, 28, 24, 30, 28, 35, 40],
                        borderColor: '#ef4444', // red-500
                        backgroundColor: 'rgba(239, 68, 68, 0.2)', // red-500 dengan transparansi
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e7eb' // gray-200
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Poppins' // Menggunakan font Poppins
                            }
                        }
                    }
                }
            }
        });
    }


    // Chart Absensi
    const chartAbsensiCtx = document.getElementById('chartAbsensi');
    if (chartAbsensiCtx) {
        new Chart(chartAbsensiCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alfa'],
                datasets: [{
                    data: [75, 10, 8, 7],
                    backgroundColor: ['#10b981', '#facc15', '#60a5fa', '#ef4444'], // green, yellow, blue, red
                    hoverOffset: 10 // Efek sedikit "pop" saat di-hover
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right', // Posisi legend di kanan
                        labels: {
                            font: {
                                family: 'Poppins' // Menggunakan font Poppins
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection