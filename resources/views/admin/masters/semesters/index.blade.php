@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Daftar Semester
    </h1>
    <p class="text-gray-600 text-base">Kelola daftar semester untuk setiap tahun ajaran yang tersedia dalam sistem.</p>
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

<div class="flex justify-end mb-8">
    <div class="relative flex items-center gap-2 group"> {{-- Wrapper for button and info pop-up --}}
        <a href="{{ route('shared.semesters.create') }}"
           class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Semester
        </a>
        <button type="button" id="infoButton" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>

        {{-- Pop-up Info --}}
        <div id="infoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Semester</h3>
                    <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                        &times;
                    </button>
                </div>

                <div class="text-gray-700 space-y-4">
                    <p>Menu ini digunakan untuk mengelola daftar **semester** yang ada di setiap tahun ajaran.</p>
                    <p>Anda dapat melihat semester aktif dan tidak aktif, serta menambahkan atau mengedit detailnya.</p>

                    <h4 class="font-bold text-gray-800">Detail Kolom:</h4>
                    <ul class="list-disc list-inside text-sm space-y-2">
                        <li><strong class="font-semibold">Semester:</strong> Nama semester (misalnya: Ganjil, Genap).</li>
                        <li><strong class="font-semibold">Tahun Ajaran:</strong> Tahun ajaran tempat semester ini berlangsung (misalnya: 2024/2025).</li>
                        <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah semester tersebut aktif atau tidak aktif. Biasanya hanya satu semester yang aktif pada satu waktu dalam satu tahun ajaran.</li>
                    </ul>

                    <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                    <ul class="list-disc list-inside text-sm space-y-2">
                        <li>**Semester → Tahun Ajaran:** Setiap semester terhubung erat dengan satu tahun ajaran.</li>
                        <li>**Semester → Penilaian & Laporan:** Semua data akademik seperti nilai, absensi, dan jadwal akan dicatat per semester aktif.</li>
                        <li>**Penting:** Hanya satu semester yang bisa aktif dalam satu tahun ajaran untuk menghindari kebingungan data. Mengaktifkan satu semester akan menonaktifkan yang lain dalam tahun ajaran yang sama.</li>
                    </ul>

                    <p class="mt-4 text-sm italic text-gray-600">Pastikan status semester selalu diperbarui sesuai periode akademik yang sedang berjalan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Semester</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Tahun Ajaran</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($semesters as $index => $semester)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4">{{ $semesters->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $semester->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $semester->schoolYear->name }}</td>
                        <td class="px-6 py-4">
                            @if ($semester->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="inline-flex space-x-2">
                                <a href="{{ route('shared.semesters.edit', $semester->id) }}" title="Edit Semester"
                                   class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('shared.semesters.destroy', $semester->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Semester"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data semester.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
        Menampilkan <span class="font-semibold">{{ $semesters->firstItem() }}</span> – <span class="font-semibold">{{ $semesters->lastItem() }}</span> dari total <span class="font-semibold">{{ $semesters->total() }}</span> semester
    </p>
    <div>
        {{ $semesters->appends(request()->query())->onEachSide(1)->links() }}
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