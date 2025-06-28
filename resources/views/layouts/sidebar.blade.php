<aside id="sidebar"
    class="w-64 bg-gray-900 text-gray-300 flex flex-col hidden-mobile fixed lg:relative inset-y-0 left-0 z-40 transition-all duration-300 ease-in-out border-r border-gray-800 shadow-xl">
    {{-- Header Sidebar --}}
    <div class="h-16 px-6 flex items-center justify-center border-b border-gray-800">
        <img src="{{ asset('images/logo.png') }}" class="h-8 mr-2 opacity-90" alt="Logo">
        <span class="font-bold text-lg tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-sky-500 logo-glow-text">SIAKAD ALBAHJAH</span>
    </div>

    @php $role = Auth::user()?->role?->name; @endphp

    {{-- Navigasi Sidebar --}}
    <nav class="flex-1 px-4 py-6 overflow-y-auto text-sm space-y-2 font-medium">
        {{-- Dashboard Link --}}
        <a href="{{ route('core.dashboard.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-sidebar-item
            {{ Route::is('dashboard') ? 'sidebar-link-active-indicator' : '' }}">
            Dashboard
        </a>

        {{-- Group Menu items in details for expand/collapse --}}
        @if ($role === 'admin')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Agenda & Kalender AK
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('core.users.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kalender Kegiatan Sekolah</a>
                    <a href="{{ route('communication.announcements.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengingat Jadwal & Event</a>
                    <a href="{{ route('facility.rooms.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman</a>
                    <a href="{{ route('facility.inventories.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Lini Masa</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Manajemen
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('core.users.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Manajemen Pengguna</a>
                    <a href="{{ route('communication.announcements.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Akademik
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('academic.daily-assessments.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Penilaian Harian</a>
                    <a href="{{ route('academic.grade-exams.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Ujian Tengah / Akhir</a>
                    <a href="{{ route('academic.grade-extracurriculars.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Nilai Ekstrakurikuler</a>
                    <a href="{{ route('academic.report-cards.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rapor Siswa</a>
                    <a href="{{ route('academic.grade-promotions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Proses Kenaikan Kelas</a>
                    <a href="{{ route('academic.grade-graduations.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Proses Kelulusan</a>
                    <a href="{{ route('academic.subjects-teachers.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengampu Mata Pelajaran</a>
                    <a href="{{ route('academic.timetables.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jadwal Pelajaran</a>
                    <a href="{{ route('academic.classroom-assignments.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Paralel & Wali Kelas</a>
                    <a href="{{ route('academic.student-notes.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Catatan Siswa</a>
                    <a href="{{ route('academic.memorization-reports.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Storan Hafalan</a>
                    <a href="{{ route('academic.grade-reports.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Nilai</a>
                    <a href="{{ route('academic.grade-promotions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Kenaikan Kelas</a>
                    <a href="{{ route('academic.online-exams.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Ujian Online</a>
                    <a href="{{ route('academic.class-enrollments.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Penempatan Kelas Siswa</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kurikulum Keislaman
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('religion.monthly-tahfidz-targets.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tahfidz Bulanan</a>
                    <a href="{{ route('religion.tahfidz-progresses.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Progress Tahfidz</a>
                    <a href="{{ route('religion.memorization-submissions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Storan Hafalan</a>
                    <a href="{{ route('religion.quran-readings.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Mengaji</a>
                    <a href="{{ route('religion.quran-review-schedules.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jadwal Murojaah</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kepegawaian
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('employee.employees.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Data Pegawai</a>
                    <a href="{{ route('employee.staffs.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Data Pejuang</a>
                    <a href="" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Pegawai</a>
                    <a href="" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Pejuang</a>
                    <a href="" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Penilaian Kinerja</a>
                    <a href="" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Gaji & Tunjangan</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kehadiran
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('core.attendances.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekap Absensi</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kesiswaan & Dokumen
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Mutasi Siswa</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Surat Aktif</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Surat Izin</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Surat Rujukan</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    PPDB
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('admission.admissions.create') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Formulir Pendaftaran</a>
                    <a href="{{ route('admission.admissions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Daftar Pendaftar</a>
                    <a href="{{ route('admission.verifications.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Verifikasi & Seleksi</a>
                    <a href="{{ route('admission.schedules.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jadwal Pendaftaran</a>
                    <a href="{{ route('admission.payments.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pembayaran Formulir</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kesehatan
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekam Medis</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Data Sakit</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Stok Obat</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    BK & Konseling
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Kasus</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jadwal Konseling</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Master Data
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('shared.schools.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Sekolah & Cabang</a>
                    <a href="{{ route('academic.academic-years.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tahun Ajaran</a>
                    <a href="{{ route('shared.semesters.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Semester</a>
                    <a href="{{ route('academic.subjects.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Mata Pelajaran</a>
                    <a href="{{ route('academic.levels.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jenjang</a>
                    <a href="{{ route('academic.grade-levels.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kelas</a>
                    <a href="{{ route('facility.rooms.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Ruangan</a>
                    <a href="{{ route('academic.classrooms.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Ruangan Kelas</a>
                    <a href="{{ route('academic.curriculums.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kurikulum</a>
                    <a href="{{ route('academic.majors.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jurusan</a>
                    <a href="{{ route('academic.teachers.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Guru & Wali Kelas</a>
                    <a href="{{ route('core.parents.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Orang Tua</a>
                    <a href="{{ route('core.students.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Siswa</a>
                    <a href="{{ route('finance.bank-accounts.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekening Bank</a>
                    <a href="{{ route('finance.bill-types.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jenis Tagihan</a>
                    <a href="{{ route('facility.inventories.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Inventaris</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Keuangan
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700 text-sm">
                    <a href="{{ route('finance.bills.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tagihan & Pembayaran</a>
                    <a href="{{ route('finance.bill-groups.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Group Tagihan</a>
                    <a href="{{ route('finance.bill-types.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tipe Tagihan</a>
                    <a href="{{ route('finance.bill-manuals.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pembayaran Manual</a>
                    <a href="{{ route('finance.unpaid-bills.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tagihan Belum Lunas</a>

                    <a href="{{ route('finance.topups.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Top-Up Management</a>
                    <a href="{{ route('finance.wallets.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Wallet Overview</a>
                    <a href="{{ route('finance.wallet-transfers.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Wallet Transfers</a>
                    <a href="{{ route('finance.wallet-logs.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Wallet Logs</a>

                    <a href="{{ route('finance.incoming-transactions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Transaksi Masuk</a>
                    <a href="{{ Route('finance.outgoing-transactions.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Transaksi Keluar</a>
                    <a href="{{ Route('finance.journal-entries.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jurnal Umum</a>

                    <a href="{{ Route('finance.monthly-recaps.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekap Bulanan</a>
                    <a href="{{ Route('finance.financial-reports.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Keuangan</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Fasilitas
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="{{ route('canteen.pos.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">AB Store</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Parkir</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laundry</a>
                    <a href="{{ route('facility.document-archives.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Arsip</a>
                </div>
            </details>

            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Sistem
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Role & Akses</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengaturan Sistem</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Log Aktivitas</a>
                </div>
            </details>
        @endif

        {{-- Role-specific menus --}}
        @if ($role === 'guru')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Guru
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kelas Saya</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Input Nilai</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Kelas</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Konseling Siswa</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekap Penilaian</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Arsip Kelas</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman</a>
                </div>
            </details>
        @endif

        @if ($role === 'orang_tua')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Orang Tua
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 space-y-1 ml-4 border-l border-gray-700">
                    <details class="group sidebar-details">
                        <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                            Akademik
                            <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </summary>
                        <div class="mt-1 ml-4 border-l border-gray-700">
                            <a href="{{ route('parent.students.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Data Anak</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Prestasi Akademik</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Nilai & Raport</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Anak</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Aktivitas Harian</a>
                        </div>
                    </details>

                    <details class="group sidebar-details">
                        <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                            Kesehatan Anak
                            <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </summary>
                        <div class="mt-1 ml-4 border-l border-gray-700">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Riwayat Kesehatan</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Sakit</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Rekam Medis & Obat</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Permintaan Rujukan</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Status Klinik Terbaru</a>
                        </div>
                    </details>

                    <details class="group sidebar-details">
                        <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                            Konsumsi & Kantin
                            <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </summary>
                        <div class="mt-1 ml-4 border-l border-gray-700">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Konsumsi & Jadwal Makan</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Transaksi Kantin</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Saldo Anak</a>
                        </div>
                    </details>

                    <details class="group sidebar-details">
                        <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                            Administrasi & Pembayaran
                            <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </summary>
                        <div class="mt-1 ml-4 border-l border-gray-700">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Tagihan & Pembayaran</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Status Izin Keluar Pondok</a>
                        </div>
                    </details>

                    <details class="group sidebar-details">
                        <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                            Informasi Lainnya
                            <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </summary>
                        <div class="mt-1 ml-4 border-l border-gray-700">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Monitoring Parkir</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">AI Konsultasi Wali</a>
                        </div>
                    </details>
                </div>
            </details>
        @endif

        @if ($role === 'siswa')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Siswa
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Lihat Raport</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Saya</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Arsip Nilai</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Transaksi Kantin</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Saldo Kantin</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman</a>
                </div>
            </details>
        @endif

        @if ($role === 'operator')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Operator Sekolah
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Input Nilai Siswa</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Absensi Harian</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Mutasi & Edit Data Siswa</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Surat Aktif / Izin</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Verifikasi Dokumen</a>
                </div>
            </details>
        @endif

        @if ($role === 'petugas_kesehatan')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kesehatan
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Input Rekam Medis</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Harian Santri Sakit</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Surat Rujukan</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Stok Obat & Inventaris</a>
                </div>
            </details>
        @endif

        @if ($role === 'perpustakaan')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Perpustakaan
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Arsip Nilai & Raport</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kelola Dokumen Cetak</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Riwayat Permintaan Surat</a>
                </div>
            </details>
        @endif

        @if ($role === 'ppdb')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    PPDB
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Lihat Data Pendaftar</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Verifikasi Berkas</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Proses Seleksi</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Pengumuman Kelulusan</a>
                </div>
            </details>
        @endif

        @if ($role === 'bk')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Bimbingan Konseling
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Catatan Kasus Siswa</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Jadwal Konseling</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Riwayat Konseling</a>
                </div>
            </details>
        @endif

        @if ($role === 'kantin')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Kantin
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Transaksi Harian</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Top Up Saldo</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Penjualan</a>
                </div>
            </details>
        @endif

        @if ($role === 'laundry')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Laundry
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Input Laundry Masuk</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Status Pakaian</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Laporan Harian</a>
                </div>
            </details>
        @endif

        @if ($role === 'visitor')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Tamu / Visitor
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Lihat Informasi Sekolah</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Agenda & Pengumuman</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Kontak & Lokasi</a>
                </div>
            </details>
        @endif

        @if ($role === 'mitra')
            <details class="group sidebar-details">
                <summary class="cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center justify-between transition-sidebar-item">
                    Mitra
                    <svg class="w-4 h-4 sidebar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <div class="mt-1 ml-4 border-l border-gray-700">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Dashboard Mitra</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Riwayat Transaksi</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded-r-lg transition-sidebar-item">Upload Penawaran</a>
                </div>
            </details>
        @endif

        {{-- Akun Saya Link --}}
        <a href="#" class="block mt-6 px-4 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-sidebar-item">Akun Saya</a>
    </nav>

    {{-- Footer Sidebar --}}
    <div class="border-t border-gray-800 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left px-4 py-2 bg-red-700 hover:bg-red-600 text-white rounded-lg transition-sidebar-item">
                Keluar
            </button>
        </form>
    </div>
</aside>