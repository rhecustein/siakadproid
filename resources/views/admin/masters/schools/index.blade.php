@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Sekolah & Cabang
    </h1>
    <p class="text-gray-600 text-base">Daftar semua sekolah dan unit cabang yang terdaftar dalam sistem.</p>
</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-blue-500 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Total Cabang</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $branches->total() }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
        <div class="text-emerald-500 text-4xl">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-2a7 7 0 00-14 0v2h14z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Total Sekolah</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $schools->total() }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama sekolah atau cabang..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="type" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Tipe</option>
                <option value="formal" {{ request('type') == 'formal' ? 'selected' : '' }}>Formal</option>
                <option value="informal" {{ request('type') == 'informal' ? 'selected' : '' }}>Informal</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('shared.schools.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>

        <div class="relative flex items-center gap-2 mt-4 md:mt-0 group"> {{-- Wrapper for buttons and info pop-up --}}
            <a href="{{ route('shared.branches.create') }}"
               class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Cabang
            </a>
            <a href="{{ route('shared.schools.create') }}"
               class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Sekolah
            </a>
            <button type="button" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"> {{-- Info button --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>

            {{-- Pop-up Info --}}
            <div class="absolute right-0 top-full mt-2 w-64 p-4 bg-white rounded-xl shadow-lg border border-gray-100 text-gray-700 text-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 origin-top-right z-50">
                <h4 class="font-bold text-gray-800 mb-2">Tentang Menu Sekolah & Cabang</h4>
                <p>Menu ini digunakan untuk mengelola daftar **cabang utama** dan **sekolah** yang berada di bawah naungan Yayasan Al-Bahjah.</p>
                <p class="mt-3 font-semibold text-gray-800">Relasi & Hubungan:</p>
                <ul class="list-disc list-inside text-xs space-y-1 mt-1">
                    <li>**Cabang → Sekolah:** Setiap sekolah terhubung ke satu cabang induk.</li>
                    <li>**Sekolah → Ruangan, Kelas, Guru, Siswa:** Setiap sekolah akan memiliki data detail terkait ruangan, kelas, guru, dan siswanya.</li>
                    <li>**Manajemen Terpusat:** Data cabang dan sekolah menjadi dasar struktur organisasi sistem.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="mb-10">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Cabang</h3>
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Cabang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Alamat</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($branches as $index => $branch)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $branches->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $branch->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $branch->address ?? '-' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    <a href="{{ route('shared.branches.edit', $branch->id) }}" title="Edit Cabang"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('shared.branches.destroy', $branch->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data cabang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Cabang"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data cabang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
        <p>
            Menampilkan <span class="font-semibold">{{ $branches->firstItem() }}</span> – <span class="font-semibold">{{ $branches->lastItem() }}</span> dari <span class="font-semibold">{{ $branches->total() }}</span> cabang
        </p>
        <div>
            {{ $branches->appends(request()->query())->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<div class="mb-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Sekolah</h3>
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Sekolah</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Cabang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">NPSN</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tipe</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Telepon</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($schools as $index => $school)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $schools->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $school->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $school->branch->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $school->npsn ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($school->type == 'formal') bg-blue-100 text-blue-800
                                    @elseif($school->type == 'informal') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($school->type ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $school->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $school->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    <a href="{{ route('shared.schools.edit', $school->id) }}" title="Edit Sekolah"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('shared.schools.destroy', $school->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data sekolah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Sekolah"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data sekolah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
        <p>
            Menampilkan <span class="font-semibold">{{ $schools->firstItem() }}</span> – <span class="font-semibold">{{ $schools->lastItem() }}</span> dari <span class="font-semibold">{{ $schools->total() }}</span> sekolah
        </p>
        <div>
            {{ $schools->appends(request()->query())->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection