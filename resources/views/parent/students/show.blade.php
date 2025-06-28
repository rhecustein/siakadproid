@extends('layouts.app')

@section('title', 'Profil Lengkap Siswa')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <!-- Button Kembali -->
    <div class="mb-4">
        <a href="{{ route('parent.students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition">
            ← Kembali ke Daftar Anak
        </a>
    </div>

    <!-- Profile Header Card -->
    <div class="bg-white shadow-lg rounded-xl p-6 border-l-8 {{ $student->gender === 'L' ? 'border-blue-500' : 'border-pink-500' }} flex flex-col sm:flex-row gap-6">
        <img src="{{ $student->photo ? asset('storage/' . $student->photo) : asset('images/avatar-' . strtolower($student->gender ?? 'n') . '.png') }}" class="w-28 h-28 rounded-full object-cover" alt="Foto Siswa">
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $student->name }}</h2>
                    <p class="text-sm text-gray-500">NIS: {{ $student->nis ?? '-' }} | NISN: {{ $student->nisn ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $student->grade->name ?? '-' }} - {{ $student->school->name ?? '-' }}</p>
                    <p class="text-sm text-gray-500">Status: <span class="font-semibold {{ $student->student_status === 'aktif' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($student->student_status) }}</span></p>
                    <p class="text-sm text-gray-500">Telp: {{ $student->phone ?? '-' }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-md hover:bg-sky-700 transition">
                        💬 Inbox Wali Kelas
                    </a>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                        📝 Buat Izin Pulang
                    </a>
                    <a href="{{ route('parent.students.edit', $student->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        ✏️ Edit Biodata
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-blue-50 p-4 rounded shadow">
            <div class="text-xs font-medium text-blue-800 uppercase">Kehadiran Semester</div>
            <div class="text-2xl font-bold text-blue-900">{{ $student->attendance_semester_percentage ?? 0 }}%</div>
        </div>
        <div class="bg-green-50 p-4 rounded shadow">
            <div class="text-xs font-medium text-green-800 uppercase">Total Kehadiran</div>
            <div class="text-2xl font-bold text-green-900">{{ $student->attendance_total_percentage ?? 0 }}%</div>
        </div>
        <div class="bg-purple-50 p-4 rounded shadow">
            <div class="text-xs font-medium text-purple-800 uppercase">Rata-rata Nilai</div>
            <div class="text-2xl font-bold text-purple-900">{{ $student->average_score ?? '-' }}</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <div class="text-xs font-medium text-yellow-800 uppercase">Ranking Kelas</div>
            <div class="text-2xl font-bold text-yellow-900">#{{ $student->class_rank ?? '-' }}</div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mt-6">
        <ul class="flex border-b text-sm font-medium space-x-4 mb-4">
            <li><a href="?tab=statistik" class="{{ $activeTab === 'statistik' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">📊 Statistik</a></li>
            <li><a href="?tab=nilai" class="{{ $activeTab === 'nilai' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">📋 Nilai</a></li>
            <li><a href="?tab=absensi" class="{{ $activeTab === 'absensi' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">📆 Absensi</a></li>
            <li><a href="?tab=prestasi" class="{{ $activeTab === 'prestasi' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">🏅 Prestasi</a></li>
            <li><a href="?tab=catatan" class="{{ $activeTab === 'catatan' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">🧠 Catatan Guru</a></li>
            <li><a href="?tab=point" class="{{ $activeTab === 'point' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">⚖️ Poin</a></li>
        </ul>

        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                @switch($activeTab)
                    @case('statistik') 📊 Statistik Siswa @break
                    @case('nilai') 📋 Nilai & Raport @break
                    @case('absensi') 📆 Kehadiran @break
                    @case('prestasi') 🏅 Prestasi @break
                    @case('catatan') 🧠 Catatan Guru @break
                    @case('point') ⚖️ Poin Karakter @break
                    @default 📊 Statistik @break
                @endswitch
            </h3>

            @if ($activeTab === 'statistik')
                @include('parent.students.partials.tab-statistik')
            @elseif ($activeTab === 'nilai')
                @include('parent.students.partials.tab-nilai')
            @elseif ($activeTab === 'absensi')
                @include('parent.students.partials.tab-absensi')
            @elseif ($activeTab === 'prestasi')
                @include('parent.students.partials.tab-prestasi')
            @elseif ($activeTab === 'catatan')
                @include('parent.students.partials.tab-catatan')
            @elseif ($activeTab === 'point')
                @include('parent.students.partials.tab-point')
            @endif
        </div>
    </div>
</div>
@endsection
