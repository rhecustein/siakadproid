<nav class="flex-1 px-4 py-6 space-y-1 text-sm font-medium">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Dashboard</a>

        @if ($role === 'admin')
        <!-- Dashboard & Inti -->
        <a href="{{ route('core.users.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Manajemen Pengguna</a>
        <a href="{{ route('academic.classrooms-schedule.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kelas & Jadwal</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Raport Digital</a>
        <a href="{{ route('absences.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Absensi</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pembayaran</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kantin & Parkir</a>
        <a href="{{ route('announcements.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pengumuman</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Arsip</a>

        <!-- Master Data -->
        <div class="mt-4 text-xs uppercase tracking-wide text-blue-200 px-4">Master Data</div>
        <a href="{{ route('master.schools.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Sekolah & Cabang</a>
        <a href="{{ route('master.academic_years.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Tahun Ajaran</a>
        <a href="{{ route('master.subjects.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Mata Pelajaran</a>
        <a href="{{ route('master.classrooms.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kelas</a>
        <a href="{{ route('master.curriculums.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kurikulum</a>
        <a href="{{ route('master.majors.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Jurusan</a>
        <a href="{{ route('master.teachers.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Guru & Wali Kelas</a>
        <a href="{{ route('master.parents.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Orang Tua</a>
        <a href="{{ route('master.students.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Siswa</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kategori Tagihan</a>

        <!-- Transaksi & Keuangan -->
        <div class="mt-4 text-xs uppercase tracking-wide text-blue-200 px-4">Keuangan</div>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Transaksi Masuk</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Transaksi Keluar</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pembayaran Manual</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Jurnal Umum</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Rekap Bulanan</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Laporan Keuangan</a>

        <!-- Sistem -->
        <div class="mt-4 text-xs uppercase tracking-wide text-blue-200 px-4">Sistem</div>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Role & Akses</a>
        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pengaturan Sistem</a>


        @elseif ($role === 'guru')
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Kelas Saya</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Input Nilai</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Absensi</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Konsultasi</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Arsip Kelas</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pengumuman</a>

        @elseif ($role === 'orang_tua')
          <a href="{{ route('parent.students.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Data Anak</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Prestasi Akademik</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Nilai & Raport</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Absensi</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Tagihan & Pembayaran</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Transaksi Kantin</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Monitoring Parkir</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pengumuman</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">AI Konsultasi</a>

        @elseif ($role === 'siswa')
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Raport</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Absensi</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Arsip Saya</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Saldo Kantin</a>
          <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Pengumuman</a>
        @endif

        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition">Akun Saya</a>
      </nav>