<aside id="sidebar"
    class="w-64 bg-blue-700 text-white flex flex-col hidden-mobile fixed lg:relative inset-y-0 left-0 z-40 transition-all duration-300 ease-in-out">
    <div class="h-16 px-6 flex items-center border-b border-blue-600">
        <img src="{{ asset('images/logo.png') }}" class="h-8 mr-2" alt="Logo">
        <span class="font-bold text-lg tracking-wide">SIAKAD ALBAHJAH</span>
    </div>

    @php $role = Auth::user()?->role?->name; @endphp

    <nav class="flex-1 px-4 py-6 overflow-y-auto text-sm space-y-2 font-medium">
        <a href="{{ route('core.dashboard.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition {{ Route::is('dashboard') ? 'bg-blue-800 font-semibold' : '' }}">Dashboard</a>

    @if ($role === 'admin')
    {{-- Agenda --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Agenda & Kalender AK</summary>
        <div class="mt-1">
            <a href="{{ route('core.users.index') }}" class="block px-4 py-2 hover:bg-blue-600">Kalender Kegiatan Sekolah</a>
            <a href="{{ route('communication.announcements.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pengingat Jadwal & Event</a>
            <a href="{{ route('facility.rooms.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pengumuman</a>
            <a href="{{ route('facility.inventories.index') }}" class="block px-4 py-2 hover:bg-blue-600">Lini Masa</a>
        </div>
    </details>
    {{-- Manajemen --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Manajemen</summary>
        <div class="mt-1">
            <a href="{{ route('core.users.index') }}" class="block px-4 py-2 hover:bg-blue-600">Manajemen Pengguna</a>
            <a href="{{ route('communication.announcements.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pengumuman</a>
        </div>
    </details>

    {{-- Akademik --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Akademik</summary>
        <div class="mt-1">
            <a href="{{ route('academic.daily-assessments.index') }}" class="block px-4 py-2 hover:bg-blue-600">Penilaian Harian</a>
            <a href="{{ route('academic.grade-exams.index') }}" class="block px-4 py-2 hover:bg-blue-600">Ujian Tengah / Akhir</a>
            <a href="{{ route('academic.grade-extracurriculars.index') }}" class="block px-4 py-2 hover:bg-blue-600">Nilai Ekstrakurikuler</a>
            <a href="{{ route('academic.report-cards.index') }}" class="block px-4 py-2 hover:bg-blue-600">Rapor Siswa</a>
            <a href="{{ route('academic.grade-promotions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Proses Kenaikan Kelas</a>
            <a href="{{ route('academic.grade-graduations.index') }}" class="block px-4 py-2 hover:bg-blue-600">Proses Kelulusan</a>
            <a href="{{ route('academic.subjects-teachers.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pengampu Mata Pelajaran</a>
            <a href="{{ route('academic.timetables.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jadwal Pelajaran</a>
            <a href="{{ route('academic.classroom-assignments.index') }}" class="block px-4 py-2 hover:bg-blue-600">Paralel & Wali Kelas</a>
            <a href="{{ route('academic.student-notes.index') }}" class="block px-4 py-2 hover:bg-blue-600">Catatan Siswa</a>
            <a href="{{ route('academic.memorization-reports.index') }}" class="block px-4 py-2 hover:bg-blue-600">Laporan Storan Hafalan</a>
            <a href="{{ route('academic.grade-reports.index') }}" class="block px-4 py-2 hover:bg-blue-600">Laporan Nilai</a>
            <a href="{{ route('academic.grade-promotions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Laporan Kenaikan Kelas</a>
            <a href="{{ route('academic.online-exams.index') }}" class="block px-4 py-2 hover:bg-blue-600">Ujian Online</a>
            <!-- <a href="{{ route('academic.print-reports.index') }}" class="block px-4 py-2 hover:bg-blue-600">Cetak Raport</a> -->
            <a href="{{ route('academic.class-enrollments.index') }}" class="block px-4 py-2 hover:bg-blue-600">Penempatan Kelas Siswa</a>
            
        </div>
    </details> 

    {{-- Kurikulum Keislaman --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kurikulum Keislaman</summary>
        <div class="mt-1">
            <a href="{{ route('religion.monthly-tahfidz-targets.index') }}" class="block px-4 py-2 hover:bg-blue-600">Tahfidz Bulanan</a>
            <a href="{{ route('religion.tahfidz-progresses.index') }}" class="block px-4 py-2 hover:bg-blue-600">Progress Tahfidz</a>
            <a href="{{ route('religion.memorization-submissions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Storan Hafalan</a>
            <a href="{{ route('religion.quran-readings.index') }}" class="block px-4 py-2 hover:bg-blue-600">Mengaji</a>
            <a href="{{ route('religion.quran-review-schedules.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jadwal Murojaah</a>
        </div>
    </details>

    {{-- Kepegawaian --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kepegawaian</summary>
        <div class="mt-1">
            <a href="{{ route('employee.employees.index') }}" class="block px-4 py-2 hover:bg-blue-600">Data Pegawai</a>
             <a href="{{ route('employee.staffs.index') }}" class="block px-4 py-2 hover:bg-blue-600">Data Pejuang</a>
            <a href="" class="block px-4 py-2 hover:bg-blue-600">Absensi Pegawai</a>
            <a href="" class="block px-4 py-2 hover:bg-blue-600">Absensi Pejuang</a>
            <a href="" class="block px-4 py-2 hover:bg-blue-600">Penilaian Kinerja</a>
            <a href="" class="block px-4 py-2 hover:bg-blue-600">Gaji & Tunjangan</a>
        </div>
    </details>

    {{-- Kehadiran --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kehadiran</summary>
        <div class="mt-1">
            <a href="{{ route('core.attendances.index') }}" class="block px-4 py-2 hover:bg-blue-600">Absensi</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Rekap Absensi</a>
        </div>
    </details>

    {{-- Kesiswaan & Dokumen --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kesiswaan & Dokumen</summary>
        <div class="mt-1">
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Mutasi Siswa</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Surat Aktif</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Surat Izin</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Surat Rujukan</a>
        </div>
    </details>

    {{-- PPDB --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">PPDB</summary>
        <div class="mt-1">
            <a href="{{ route('admission.admissions.create') }}" class="block px-4 py-2 hover:bg-blue-600">Formulir Pendaftaran</a>
            <a href="{{ route('admission.admissions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Daftar Pendaftar</a>
            <a href="{{ route('admission.verifications.index') }}" class="block px-4 py-2 hover:bg-blue-600">Verifikasi & Seleksi</a>
            <a href="{{ route('admission.schedules.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jadwal Pendaftaran</a>
            <a href="{{ route('admission.payments.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pembayaran Formulir</a>
        </div>
    </details>

    {{-- Kesehatan --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kesehatan</summary>
        <div class="mt-1">
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Rekam Medis</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Data Sakit</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Stok Obat</a>
        </div>
    </details>

    {{-- BK & Konseling --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">BK & Konseling</summary>
        <div class="mt-1">
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laporan Kasus</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Jadwal Konseling</a>
        </div>
    </details>

    {{-- Master Data --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Master Data</summary>
        <div class="mt-1">
            <a href="{{ route('shared.schools.index') }}" class="block px-4 py-2 hover:bg-blue-600">Sekolah & Cabang</a>
            <a href="{{ route('academic.academic-years.index') }}" class="block px-4 py-2 hover:bg-blue-600">Tahun Ajaran</a>
            <a href="{{ route('shared.semesters.index') }}" class="block px-4 py-2 hover:bg-blue-600">Semester</a>
            <a href="{{ route('academic.subjects.index') }}" class="block px-4 py-2 hover:bg-blue-600">Mata Pelajaran</a>
            <a href="{{ route('academic.levels.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jenjang</a>
            <a href="{{ route('academic.grade-levels.index') }}" class="block px-4 py-2 hover:bg-blue-600">Kelas</a>
            <a href="{{ route('facility.rooms.index') }}" class="block px-4 py-2 hover:bg-blue-600">Ruangan</a>
            <a href="{{ route('academic.classrooms.index') }}" class="block px-4 py-2 hover:bg-blue-600">Ruangan Kelas</a>
            <a href="{{ route('academic.curriculums.index') }}" class="block px-4 py-2 hover:bg-blue-600">Kurikulum</a>
            <a href="{{ route('academic.majors.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jurusan</a>
            <a href="{{ route('academic.teachers.index') }}" class="block px-4 py-2 hover:bg-blue-600">Guru & Wali Kelas</a>
            <a href="{{ route('core.parents.index') }}" class="block px-4 py-2 hover:bg-blue-600">Orang Tua</a>
            <a href="{{ route('core.students.index') }}" class="block px-4 py-2 hover:bg-blue-600">Siswa</a>
            <a href="{{ route('finance.bank-accounts.index') }}" class="block px-4 py-2 hover:bg-blue-600">Rekening Bank</a>
            <a href="{{ route('finance.bill-types.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jenis Tagihan</a>
            <a href="{{ route('facility.inventories.index') }}" class="block px-4 py-2 hover:bg-blue-600">Inventaris</a>
        </div>
    </details>

    {{-- Keuangan --}}
    <details class="mt-4">
    <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded text-white font-semibold">
        Keuangan
    </summary>
    <div class="mt-1 text-sm text-white">
        <!-- Tagihan dan Pembayaran -->
        <a href="{{ route('finance.bills.index') }}" class="block px-4 py-2 hover:bg-blue-600">Tagihan & Pembayaran</a>
        <a href="{{ route('finance.bill-groups.index') }}" class="block px-4 py-2 hover:bg-blue-600">Group Tagihan</a>
        <a href="{{ route('finance.bill-types.index') }}" class="block px-4 py-2 hover:bg-blue-600">Tipe Tagihan</a>
        <a href="{{ route('finance.bill-manuals.index') }}" class="block px-4 py-2 hover:bg-blue-600">Pembayaran Manual</a>
        <a href="{{ route('finance.unpaid-bills.index') }}" class="block px-4 py-2 hover:bg-blue-600">Tagihan Belum Lunas</a>

        <!-- Wallet Management -->
        <a href="{{ route('finance.topups.index') }}" class="block px-4 py-2 hover:bg-blue-600">Top-Up Management</a>
        <a href="{{ route('finance.wallets.index') }}" class="block px-4 py-2 hover:bg-blue-600">Wallet Overview</a>
        <a href="{{ route('finance.wallet-transfers.index') }}" class="block px-4 py-2 hover:bg-blue-600">Wallet Transfers</a>
        <a href="{{ route('finance.wallet-logs.index') }}" class="block px-4 py-2 hover:bg-blue-600">Wallet Logs</a>

        <!-- Transaksi dan Jurnal -->
        <a href="{{ route('finance.incoming-transactions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Transaksi Masuk</a>
        <a href="{{ Route('finance.outgoing-transactions.index') }}" class="block px-4 py-2 hover:bg-blue-600">Transaksi Keluar</a>
        <a href="{{ Route('finance.journal-entries.index') }}" class="block px-4 py-2 hover:bg-blue-600">Jurnal Umum</a>
 
        <!-- Laporan -->
        <a href="{{ Route('finance.monthly-recaps.index') }}" class="block px-4 py-2 hover:bg-blue-600">Rekap Bulanan</a>
        <a href="{{ Route('finance.financial-reports.index') }}" class="block px-4 py-2 hover:bg-blue-600">Laporan Keuangan</a>
        <!-- <a href="#" class="block px-4 py-2 hover:bg-blue-600">Audit Transaksi Sistem</a> -->
        </div>
    </details>


    {{-- Fasilitas --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Fasilitas</summary>
        <div class="mt-1">
            <a href="{{ route('canteen.pos.index') }}" class="block px-4 py-2 hover:bg-blue-600">AB Store</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Parkir</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laundry</a>
            <a href="{{ route('facility.document-archives.index') }}" class="block px-4 py-2 hover:bg-blue-600">Arsip</a>
        </div>
    </details>

    {{-- Sistem --}}
    <details class="mt-4">
        <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Sistem</summary>
        <div class="mt-1">
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Role & Akses</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pengaturan Sistem</a>
            <a href="#" class="block px-4 py-2 hover:bg-blue-600">Log Aktivitas</a>
        </div>
    </details>

@endif


        @if ($role === 'guru')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Guru</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Kelas Saya</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Input Nilai</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Absensi Kelas</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Konseling Siswa</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Rekap Penilaian</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Arsip Kelas</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pengumuman</a>
            </div>
        </details>
        @endif

      @if ($role === 'orang_tua')
        <details class="mt-4">
          <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Orang Tua</summary>
          <div class="mt-1 space-y-2">

            {{-- Grup 1: Informasi Akademik --}}
            <details>
              <summary class="cursor-pointer px-4 py-2 bg-blue-700 rounded">Akademik</summary>
              <div class="mt-1">
                <a href="{{ route('parent.students.index') }}" class="block px-4 py-2 hover:bg-blue-600">Data Anak</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Prestasi Akademik</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Nilai & Raport</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Absensi Anak</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Aktivitas Harian</a>
              </div>
            </details>

            {{-- Grup 2: Kesehatan --}}
            <details>
              <summary class="cursor-pointer px-4 py-2 bg-blue-700 rounded">Kesehatan Anak</summary>
              <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Riwayat Kesehatan</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laporan Sakit</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Rekam Medis & Obat</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Permintaan Rujukan</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Status Klinik Terbaru</a>
              </div>
            </details>

            {{-- Grup 3: Konsumsi --}}
            <details>
              <summary class="cursor-pointer px-4 py-2 bg-blue-700 rounded">Konsumsi & Kantin</summary>
              <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Konsumsi & Jadwal Makan</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Transaksi Kantin</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Saldo Anak</a>
              </div>
            </details>

            {{-- Grup 4: Administrasi --}}
            <details>
              <summary class="cursor-pointer px-4 py-2 bg-blue-700 rounded">Administrasi & Pembayaran</summary>
              <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Tagihan & Pembayaran</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Status Izin Keluar Pondok</a>
              </div>
            </details>

            {{-- Grup 5: Informasi Tambahan --}}
            <details>
              <summary class="cursor-pointer px-4 py-2 bg-blue-700 rounded">Informasi Lainnya</summary>
              <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Monitoring Parkir</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pengumuman</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">AI Konsultasi Wali</a>
              </div>
            </details>

          </div>
        </details>
        @endif



        @if ($role === 'siswa')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Siswa</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Lihat Raport</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Absensi Saya</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Arsip Nilai</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Transaksi Kantin</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Saldo Kantin</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pengumuman</a>
            </div>
        </details>
        @endif

        @if ($role === 'operator')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Operator Sekolah</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Input Nilai Siswa</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Absensi Harian</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Mutasi & Edit Data Siswa</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Surat Aktif / Izin</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Verifikasi Dokumen</a>
            </div>
        </details>
        @endif

        @if ($role === 'petugas_kesehatan')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kesehatan</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Input Rekam Medis</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laporan Harian Santri Sakit</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Surat Rujukan</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Stok Obat & Inventaris</a>
            </div>
        </details>
        @endif


        @if ($role === 'perpustakaan')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Perpustakaan</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Arsip Nilai & Raport</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Kelola Dokumen Cetak</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Riwayat Permintaan Surat</a>
            </div>
        </details>
        @endif


        @if ($role === 'ppdb')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">PPDB</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Lihat Data Pendaftar</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Verifikasi Berkas</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Proses Seleksi</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pengumuman Kelulusan</a>
            </div>
        </details>
        @endif


        @if ($role === 'bk')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Bimbingan Konseling</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Catatan Kasus Siswa</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Jadwal Konseling</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Riwayat Konseling</a>
            </div>
        </details>
        @endif


        @if ($role === 'kantin')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Kantin</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Transaksi Harian</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Top Up Saldo</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laporan Penjualan</a>
            </div>
        </details>
        @endif


        @if ($role === 'laundry')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Laundry</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Input Laundry Masuk</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Status Pakaian</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Laporan Harian</a>
            </div>
        </details>
        @endif


        @if ($role === 'visitor')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Tamu / Visitor</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Lihat Informasi Sekolah</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Agenda & Pengumuman</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Kontak & Lokasi</a>
            </div>
        </details>
        @endif


        @if ($role === 'mitra')
        <details class="mt-4">
            <summary class="cursor-pointer px-4 py-2 bg-blue-800 rounded">Mitra</summary>
            <div class="mt-1">
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Dashboard Mitra</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Riwayat Transaksi</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Upload Penawaran</a>
            </div>
        </details>
        @endif


        <a href="#" class="block mt-6 px-4 py-2 rounded-lg hover:bg-blue-600 transition">Akun Saya</a>
    </nav>

    <div class="border-t border-blue-600 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left px-4 py-2 bg-blue-800 hover:bg-red-600 text-white rounded transition">Keluar</button>
        </form>
    </div>
</aside>