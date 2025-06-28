@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Daftar Tahun Ajaran
    </h1>
    <p class="text-gray-600 text-base">Semua tahun ajaran yang terdaftar dalam sistem.</p>
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

<div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
    <form method="GET" class="flex flex-col md:flex-row md:items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari tahun ajaran..."
               class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

        <select name="status" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
            <option value="">Semua Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
        <a href="{{ route('academic.academic-years.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
            Reset
        </a>
    </form>
</div>

<div class="flex justify-end mb-8">
    <div class="relative flex items-center gap-2 group"> {{-- Wrapper for button and info pop-up --}}
        <a href="{{ route('academic.academic-years.create') }}"
           class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Tahun Ajaran
        </a>
        <button type="button" id="infoButton" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>

        {{-- Pop-up Info --}}
        <div id="infoModal" class="absolute right-0 top-full mt-2 w-64 p-4 bg-white rounded-xl shadow-lg border border-gray-100 text-gray-700 text-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 origin-top-right z-50">
            <h4 class="font-bold text-gray-800 mb-2">Tentang Menu Tahun Ajaran</h4>
            <p>Menu ini digunakan untuk mengelola **periode tahunan** kegiatan akademik dan administrasi sistem.</p>
            <p class="mt-3 font-semibold text-gray-800">Relasi & Hubungan:</p>
            <ul class="list-disc list-inside text-xs space-y-1 mt-1">
                <li>**Tahun Ajaran → Semester:** Setiap tahun ajaran akan memiliki semester (ganjil/genap) di dalamnya.</li>
                <li>**Tahun Ajaran → Kelas:** Kelas-kelas (grade levels) akan terkait dengan tahun ajaran tertentu.</li>
                <li>**Tahun Ajaran → Penilaian & Laporan:** Semua data nilai, absensi, dan laporan akan terdata berdasarkan tahun ajaran aktif.</li>
                <li>**Penting:** Hanya satu tahun ajaran yang bisa aktif pada satu waktu. Pastikan untuk mengaktifkan tahun ajaran yang sedang berjalan.</li>
            </ul>
        </div>
    </div>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Tahun Ajaran</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($years as $index => $year)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4">{{ $years->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $year->name }}</td>
                        <td class="px-6 py-4">
                            @if ($year->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="inline-flex space-x-2">
                                @if (!$year->is_active)
                                    <form action="{{ route('academic.academic-years.activate', $year->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengaktifkan tahun ajaran ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="Aktifkan"
                                                class="p-2 text-xs font-semibold text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('academic.academic-years.edit', $year->id) }}" title="Edit Tahun Ajaran"
                                   class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('academic.academic-years.destroy', $year->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Tahun Ajaran"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data tahun ajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
        Menampilkan <span class="font-semibold">{{ $years->firstItem() }}</span> – <span class="font-semibold">{{ $years->lastItem() }}</span> dari total <span class="font-semibold">{{ $years->total() }}</span> tahun ajaran
    </p>
    <div>
        {{ $years->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const infoButton = document.getElementById('infoButton');
        const infoModal = document.getElementById('infoModal');
        const closeModal = document.getElementById('closeModal');

        // Function to show modal with animation
        function showModal() {
            infoModal.classList.remove('hidden');
            setTimeout(() => {
                infoModal.classList.add('opacity-100');
                infoModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
                infoModal.querySelector('div').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Function to hide modal with animation
        function hideModal() {
            infoModal.classList.remove('opacity-100');
            infoModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
            infoModal.querySelector('div').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                infoModal.classList.add('hidden');
            }, 300);
        }

        infoButton.addEventListener('click', showModal);
        closeModal.addEventListener('click', hideModal);

        // Hide modal when clicking outside of the content
        infoModal.addEventListener('click', function(event) {
            if (event.target === infoModal) {
                hideModal();
            }
        });
    });
</script>
@endsection