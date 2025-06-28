@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Manajemen Pengguna
    </h1>
    <p class="text-gray-600 text-base">Kelola data seluruh pengguna sistem: Admin, Guru, Orang Tua, dan Siswa.</p>
</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    @php
        // Contoh data counts, sesuaikan dengan data aktual dari controller Anda
        $counts = $counts ?? ['admin' => 0, 'guru' => 0, 'orang_tua' => 0, 'siswa' => 0];
        $totalUsers = $users->total() ?? 0; // Mengambil total dari paginator
    @endphp

    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-blue-500 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.134-1.285-.386-1.86M7 20h-3v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.134-1.285.386-1.86m0 0A7.003 7.003 0 0012 11a7.003 7.003 0 00-4.614-1.86M17 20h-2.172a4 4 0 00-5.656 0H7m0 0A4 4 0 0112 15a4 4 0 015.656 0m-5.656 0h.01M12 4a4 4 0 100 8 4 4 0 000-8z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Total Pengguna</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-gray-600 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15.75c-2.793 0-5.487-.41-8.082-1.495z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.56 8.43a.975.975 0 10-1.43 1.43L14 10.5l-.56.56a.975.975 0 101.43 1.43L15 12l.56.56a.975.975 0 10-1.43 1.43L14 13.5l-.56.56a.975.975 0 101.43 1.43L15 15l.56.56a.975.975 0 10-1.43 1.43L14 16.5l-.56.56a.975.975 0 101.43 1.43L15 18l.56.56a.975.975 0 10-1.43 1.43L14 19.5l-.56.56a.975.975 0 101.43 1.43L15 21l.56.56a.975.975 0 10-1.43 1.43L14 22.5l-.56.56a.975.975 0 101.43 1.43L15 24l.56.56zM8 7v.01M12 7v.01M16 7v.01M8 11v.01M12 11v.01M16 11v.01M8 15v.01M12 15v.01M16 15v.01"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v.01"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Admin</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $counts['admin'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-emerald-600 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3v4l3 3"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Guru</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $counts['guru'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-indigo-500 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.206 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.794 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.794 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.206 18 16.5 18s-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Siswa</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $counts['siswa'] ?? 0 }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <form method="GET" action="{{ route('core.users.index') }}" class="flex flex-1 flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email pengguna..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />

            <select name="role" class="rounded-lg px-4 py-2 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <option value="">Semua Role</option>
                <option value="1" {{ request('role') == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ request('role') == 2 ? 'selected' : '' }}>Guru</option>
                <option value="3" {{ request('role') == 3 ? 'selected' : '' }}>Orang Tua</option>
                <option value="4" {{ request('role') == 4 ? 'selected' : '' }}>Siswa</option>
                {{-- Tambahkan role lain jika ada (misal: 'petugas_kesehatan', 'kantin', dll) --}}
                <option value="5" {{ request('role') == 5 ? 'selected' : '' }}>Operator</option>
                <option value="6" {{ request('role') == 6 ? 'selected' : '' }}>Petugas Kesehatan</option>
                <option value="7" {{ request('role') == 7 ? 'selected' : '' }}>Perpustakaan</option>
                <option value="8" {{ request('role') == 8 ? 'selected' : '' }}>PPDB</option>
                <option value="9" {{ request('role') == 9 ? 'selected' : '' }}>BK</option>
                <option value="10" {{ request('role') == 10 ? 'selected' : '' }}>Kantin</option>
                <option value="11" {{ request('role') == 11 ? 'selected' : '' }}>Laundry</option>
                <option value="12" {{ request('role') == 12 ? 'selected' : '' }}>Visitor</option>
                <option value="13" {{ request('role') == 13 ? 'selected' : '' }}>Mitra</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('core.users.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>

        <a href="{{ route('core.users.create') }}"
           class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pengguna
        </a>
    </div>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Email</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">No. HP</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Role</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Sidik Jari</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                            {{ $user->phone_number ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                            @php
                                $rolesMap = [
                                    1 => 'Admin', 2 => 'Guru', 3 => 'Orang Tua', 4 => 'Siswa',
                                    5 => 'Operator', 6 => 'Petugas Kesehatan', 7 => 'Perpustakaan',
                                    8 => 'PPDB', 9 => 'BK', 10 => 'Kantin', 11 => 'Laundry',
                                    12 => 'Visitor', 13 => 'Mitra'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role_id == 1) bg-purple-100 text-purple-800
                                @elseif($user->role_id == 2) bg-blue-100 text-blue-800
                                @elseif($user->role_id == 3) bg-yellow-100 text-yellow-800
                                @elseif($user->role_id == 4) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $rolesMap[$user->role_id] ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($user->fingerprint || $user->fingerprint2 || $user->fingerprint3)
                                <span class="text-green-500 flex items-center justify-center gap-1">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                    Tersedia
                                </span>
                            @else
                                <span class="text-red-500 flex items-center justify-center gap-1">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    Tidak Ada
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap space-x-2">
                            <div class="inline-flex space-x-2">
                                {{-- Tombol Sidik Jari (jika perlu detail lebih lanjut, arahkan ke halaman input) --}}
                                @if (!$user->fingerprint || !$user->fingerprint2 || !$user->fingerprint3)
                                <a href="{{ route('core.fingerprint.create', $user->id) }}"
                                    class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center" title="Tambah Sidik Jari">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </a>
                                @endif

                                @if ($user->is_active)
                                    <form action="{{ route('core.users.deactivate', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menonaktifkan pengguna ini?')">
                                        @csrf
                                        <button type="submit" title="Non Aktifkan"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('core.users.activate', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengaktifkan pengguna ini?')">
                                        @csrf
                                        <button type="submit" title="Aktifkan"
                                                class="p-2 text-xs font-semibold text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('core.users.show', $user->id) }}" title="Lihat Detail"
                                    class="p-2 text-xs font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('core.users.edit', $user->id) }}" title="Edit Pengguna"
                                    class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('core.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Pengguna"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Data pengguna tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
        Menampilkan <span class="font-semibold">{{ $users->firstItem() }}</span> – <span class="font-semibold">{{ $users->lastItem() }}</span> dari <span class="font-semibold">{{ $users->total() }}</span> pengguna
    </p>
    <div>
        {{ $users->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>

<div class="bg-white shadow-xl rounded-2xl p-6 mb-10 mt-10 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Pengguna Berdasarkan Status</h3>
    <div class="h-64 flex items-center justify-center">
        <canvas id="userStatusChart"></canvas>
    </div>
</div>

<div class="bg-white shadow-xl rounded-2xl p-6 mb-10 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Log Aktivitas Pengguna Terbaru</h3>
    <ul class="space-y-3 text-sm text-gray-700">
        <li class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
            <span class="text-blue-500 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            <p><strong class="font-semibold">2 menit lalu:</strong> Admin Utama mengubah status pengguna "Budi Santoso" menjadi Non Aktif.</p>
        </li>
        <li class="flex items-start gap-2 p-2 rounded-lg">
            <span class="text-green-500 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14c-1.49 0-2.873.06-4.2.146M7 19h10a2 2 0 002-2v-2a6 6 0 00-6-6H9a6 6 0 00-6 6v2a2 2 0 002 2z"></path></svg>
            </span>
            <p><strong class="font-semibold">1 jam lalu:</strong> Operator Sekolah menambahkan akun siswa baru "Sinta Dewi" (Kelas 7C).</p>
        </li>
        <li class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
            <span class="text-yellow-500 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
            </span>
            <p><strong class="font-semibold">Kemarin:</strong> Guru Fitri memperbarui data nomor HP di profilnya.</p>
        </li>
    </ul>
    <button class="mt-6 w-full text-center py-2 border border-blue-200 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">Lihat Semua Log Aktivitas</button>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inisialisasi Chart.js untuk distribusi pengguna
    document.addEventListener('DOMContentLoaded', function() {
        const userStatusCtx = document.getElementById('userStatusChart');
        if (userStatusCtx) {
            new Chart(userStatusCtx, {
                type: 'pie', // Atau 'doughnut'
                data: {
                    labels: ['Aktif', 'Tidak Aktif'],
                    datasets: [{
                        data: [
                            {{ $users->where('is_active', 1)->count() }},
                            {{ $users->where('is_active', 0)->count() }}
                        ],
                        backgroundColor: ['#10B981', '#EF4444'], // Green for Active, Red for Inactive
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Poppins'
                                }
                            }
                        }
                    }
                }
            });
        }

        // Script untuk pop-up notifikasi (diambil dari layout app)
        const notifBox = document.getElementById('notifBox');
        if (notifBox) {
            setTimeout(() => {
                notifBox.classList.remove('translate-x-full');
                notifBox.classList.add('translate-x-0');
            }, 1000);
        }
    });
</script>
@endpush
@endsection