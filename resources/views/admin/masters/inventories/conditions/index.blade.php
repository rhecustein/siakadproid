@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Kondisi Inventaris
            </h1>
            <p class="text-gray-600 text-base">Daftar semua kondisi inventaris yang terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Kembali ke Inventaris --}}
            <a href="{{ route('facility.inventories.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold shadow-md hover:bg-gray-300 transition-colors duration-200 min-w-max">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Inventaris
            </a>
            {{-- Tombol Tambah Kondisi --}}
            <a href="{{ route('facility.inventory-conditions.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-yellow-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-yellow-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Kondisi
            </a>
            {{-- Tombol Info Menu (Membuka Modal Informasi Umum Menu) --}}
            <button type="button" id="openMenuInfoModal" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
            <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Count Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card Total Kondisi --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kondisi</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalConditions }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-list-alt fa-lg"></i>
            </div>
        </div>

        {{-- Card Kondisi Baik --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Kondisi 'Baik'</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $goodConditions }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-thumbs-up fa-lg"></i>
            </div>
        </div>

        {{-- Card Kondisi Rusak --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Kondisi 'Rusak'</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $damagedConditions }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-full text-red-600">
                <i class="fas fa-times-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Kondisi Perbaikan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Kondisi 'Perbaikan'</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $inRepairConditions }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-tools fa-lg"></i>
            </div>
        </div>
    </div>


    <form method="GET" action="{{ route('facility.inventory-conditions.index') }}" class="mb-4 flex flex-wrap items-center gap-2 bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama kondisi..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
        <a href="{{ route('facility.inventory-conditions.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
            Reset
        </a>
    </form>


    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Deskripsi</th>
                        <th class="px-6 py-3 text-center border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($conditions as $index => $condition)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $conditions->firstItem() + $index }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $condition->name }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $condition->description ?? '—' }}</td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $condition->name }}"
                                            data-description="{{ $condition->description ?? 'N/A' }}"
                                            title="Lihat Detail Kondisi">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('facility.inventory-conditions.edit', $condition->id) }}" title="Edit Kondisi Inventaris"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('facility.inventory-conditions.destroy', $condition->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kondisi inventaris ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus Kondisi Inventaris"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada kondisi inventaris ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $conditions->links() }}
    </div>

    {{-- Alert box untuk Economic Life (Dipindahkan ke dalam modal info atau terpisah jika ingin terus terlihat) --}}
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 text-sm text-yellow-800 rounded-lg shadow-md">
        <p class="font-bold mb-1">Apa itu Kondisi Inventaris (Inventory Condition)?</p>
        <p>
            <strong>Kondisi Inventaris</strong> adalah status fisik atau operasional suatu barang atau aset dalam sistem inventaris.
            Penentuan kondisi membantu lembaga untuk:
        </p>
        <ul class="mt-2 list-disc pl-5 space-y-1">
            <li>Mengetahui apakah suatu barang masih layak digunakan atau perlu diganti.</li>
            <li>Menjadi dasar penjadwalan perbaikan atau penghapusan aset.</li>
            <li>Menyusun laporan kondisi aset secara akurat dan transparan.</li>
        </ul>
        <p class="mt-2">Kategori umum mencakup kondisi <strong>baik</strong>, <strong>rusak ringan</strong>, <strong>rusak berat</strong>, dan <strong>hilang</strong>. Penyesuaian dapat dilakukan sesuai kebutuhan institusi.</p>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Kondisi Inventaris</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **kondisi fisik atau operasional** dari setiap item inventaris yang terdaftar.</p>
                <p>Pendefinisian kondisi inventaris sangat penting untuk pelacakan aset dan pengambilan keputusan terkait pemeliharaan atau penggantian.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama kondisi (misal: Baik, Rusak Ringan, Perbaikan, Hilang).</li>
                    <li><strong class="font-semibold">Deskripsi:</strong> Penjelasan lebih lanjut tentang kondisi tersebut.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Kondisi Inventaris → Inventaris:** Setiap item inventaris akan memiliki kondisi yang ditugaskan dari daftar ini.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Pastikan daftar kondisi inventaris komprehensif untuk mencerminkan status aset secara akurat.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Kondisi Inventaris --}}
    <div id="inventoryConditionDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Kondisi Inventaris: <span id="detailConditionName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Kondisi:</strong> <span id="detailName"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detailDescription"></span></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Control Functions ---
        function openModal(modalElement, contentElement) {
            modalElement.classList.remove('hidden');
            setTimeout(() => {
                contentElement.classList.remove('scale-95', 'opacity-0');
                contentElement.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeModal(modalElement, contentElement) {
            contentElement.classList.remove('scale-100', 'opacity-100');
            contentElement.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modalElement.classList.add('hidden');
            }, 300);
        }

        // --- Modal Informasi Umum Menu ---
        const menuInfoModal = document.getElementById('menuInfoModal');
        const openMenuInfoModalBtn = document.getElementById('openMenuInfoModal');
        const closeMenuInfoModalBtn = document.getElementById('closeMenuInfoModal');
        const menuModalContent = menuInfoModal.querySelector('.transform');

        openMenuInfoModalBtn.addEventListener('click', () => openModal(menuInfoModal, menuModalContent));
        closeMenuInfoModalBtn.addEventListener('click', () => closeModal(menuInfoModal, menuModalContent));
        menuInfoModal.addEventListener('click', function(event) {
            if (event.target === menuInfoModal) {
                closeModal(menuInfoModal, menuModalContent);
            }
        });

        // --- Modal Detail Kondisi Inventaris ---
        const inventoryConditionDetailModal = document.getElementById('inventoryConditionDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailConditionName = document.getElementById('detailConditionName');
        const detailName = document.getElementById('detailName');
        const detailDescription = document.getElementById('detailDescription');
        const detailModalContent = inventoryConditionDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailConditionName.textContent = this.dataset.name;
                detailName.textContent = this.dataset.name;
                detailDescription.textContent = this.dataset.description;

                openModal(inventoryConditionDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(inventoryConditionDetailModal, detailModalContent));
        inventoryConditionDetailModal.addEventListener('click', function(event) {
            if (event.target === inventoryConditionDetailModal) {
                closeModal(inventoryConditionDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush