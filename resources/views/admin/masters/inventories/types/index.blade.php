@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Tipe Inventaris
            </h1>
            <p class="text-gray-600 text-base">Daftar semua jenis inventaris yang terdaftar dalam sistem.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Kembali ke Inventaris --}}
            <a href="{{ route('facility.inventories.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold shadow-md hover:bg-gray-300 transition-colors duration-200 min-w-max">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Inventaris
            </a>
            {{-- Tombol Tambah Tipe --}}
            <a href="{{ route('facility.inventory-types.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Tipe
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
        {{-- Card Total Tipe Inventaris --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Tipe</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTypes }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-boxes fa-lg"></i>
            </div>
        </div>

        {{-- Card Tipe Elektronik --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tipe Elektronik</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $electronicTypes }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <i class="fas fa-microchip fa-lg"></i>
            </div>
        </div>

        {{-- Card Tipe Habis Pakai --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tipe Habis Pakai</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $consumableTypes }}</p>
            </div>
            <div class="p-3 bg-pink-100 rounded-full text-pink-600">
                <i class="fas fa-hand-sparkles fa-lg"></i>
            </div>
        </div>

        {{-- Card Total Umur Ekonomis Rata-rata --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Umur Ekonomis Rata-rata</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ round($avgEconomicLife) }} <span class="text-lg">Thn</span></p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-hourglass-half fa-lg"></i>
            </div>
        </div>
    </div>


    <form method="GET" action="{{ route('facility.inventory-types.index') }}" class="mb-4 flex flex-wrap items-center gap-2 bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama tipe..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

        <select name="electronic" class="rounded-lg px-3 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
            <option value="">Semua Tipe</option>
            <option value="1" {{ request('electronic') === '1' ? 'selected' : '' }}>Elektronik</option>
            <option value="0" {{ request('electronic') === '0' ? 'selected' : '' }}>Non-Elektronik</option>
        </select>

        <select name="consumable" class="rounded-lg px-3 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
            <option value="">Semua Habis Pakai</option>
            <option value="1" {{ request('consumable') === '1' ? 'selected' : '' }}>Habis Pakai</option>
            <option value="0" {{ request('consumable') === '0' ? 'selected' : '' }}>Tidak Habis Pakai</option>
        </select>

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
        <a href="{{ route('facility.inventory-types.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
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
                        <th class="px-6 py-3 border-b-2 border-gray-200">Elektronik</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Habis Pakai</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Umur Ekonomis (Thn)</th>
                        <th class="px-6 py-3 text-center border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($types as $index => $type)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $types->firstItem() + $index }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $type->name }}</td>
                            <td class="px-6 py-3 text-center">
                                @if($type->is_electronic)
                                    <i class="fas fa-check-circle text-green-500">YA</i>
                                @else
                                    <i class="fas fa-times-circle text-red-500">TIDAK</i>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if($type->is_consumable)
                                    <i class="fas fa-check-circle text-green-500">YA</i>
                                @else
                                    <i class="fas fa-times-circle text-red-500">TIDAK</i>
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $type->economic_life ?? '—' }}</td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $type->name }}"
                                            data-is-electronic="{{ $type->is_electronic ? 'Ya' : 'Tidak' }}"
                                            data-is-consumable="{{ $type->is_consumable ? 'Ya' : 'Tidak' }}"
                                            data-economic-life="{{ $type->economic_life ?? 'N/A' }}"
                                            title="Lihat Detail Tipe Inventaris">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('facility.inventory-types.edit', $type->id) }}" title="Edit Tipe Inventaris"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('facility.inventory-types.destroy', $type->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus tipe inventaris ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus Tipe Inventaris"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada tipe inventaris ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $types->links() }}
    </div>

    {{-- Alert box untuk Economic Life (Dipindahkan ke dalam modal info atau terpisah jika ingin terus terlihat) --}}
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 text-sm text-yellow-800 rounded-lg shadow-md">
        <p class="font-bold mb-1">Apa itu Umur Ekonomis (Economic Life)?</p>
        <p>
            <strong>Umur Ekonomis</strong> atau estimasi lamanya suatu aset atau barang dapat digunakan secara produktif dan ekonomis.
        </p>
        <ul class="mt-2 list-disc pl-5 space-y-1">
            <li>Digunakan untuk perhitungan penyusutan aset tiap tahun.</li>
            <li>Menjadi indikator kapan barang perlu diganti atau dihapus dari daftar aset aktif.</li>
            <li>Membantu perencanaan anggaran jangka panjang untuk pengadaan kembali.</li>
            <li>Barang elektronik biasanya memiliki umur lebih pendek (3–5 tahun), sedangkan furniture bisa mencapai 10 tahun atau lebih.</li>
        </ul>
        <p class="mt-2">Semakin akurat nilai economic life yang dimasukkan, semakin baik data inventaris dalam mencerminkan kondisi nyata aset yang dimiliki lembaga.</p>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Tipe Inventaris</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **kategori atau jenis-jenis inventaris** yang berbeda, seperti elektronik, furnitur, buku, bahan habis pakai, dll.</p>
                <p>Setiap tipe inventaris dapat memiliki karakteristik unik, seperti apakah itu barang elektronik atau habis pakai, dan perkiraan umur ekonomisnya.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama tipe inventaris (misal: Komputer, Meja, Spidol).</li>
                    <li><strong class="font-semibold">Elektronik:</strong> Menunjukkan apakah ini adalah barang elektronik.</li>
                    <li><strong class="font-semibold">Habis Pakai:</strong> Menunjukkan apakah ini adalah barang habis pakai.</li>
                    <li><strong class="font-semibold">Umur Ekonomis:</strong> Perkiraan lama penggunaan aset (dalam tahun).</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Tipe Inventaris → Inventaris:** Setiap item inventaris akan dikategorikan ke dalam tipe ini.</li>
                    <li>**Tipe Inventaris → Kondisi Inventaris:** Seringkali terkait dengan kondisi umum.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Kategorisasi inventaris yang tepat membantu dalam pelacakan aset dan manajemen sumber daya yang lebih baik.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Tipe Inventaris --}}
    <div id="inventoryTypeDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Tipe Inventaris: <span id="detailTypeName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Tipe:</strong> <span id="detailName"></span></p>
                <p><strong>Elektronik:</strong> <span id="detailIsElectronic"></span></p>
                <p><strong>Habis Pakai:</strong> <span id="detailIsConsumable"></span></p>
                <p><strong>Umur Ekonomis (Tahun):</strong> <span id="detailEconomicLife"></span></p>
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

        // --- Modal Detail Tipe Inventaris ---
        const inventoryTypeDetailModal = document.getElementById('inventoryTypeDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailTypeName = document.getElementById('detailTypeName');
        const detailName = document.getElementById('detailName');
        const detailIsElectronic = document.getElementById('detailIsElectronic');
        const detailIsConsumable = document.getElementById('detailIsConsumable');
        const detailEconomicLife = document.getElementById('detailEconomicLife');
        const detailModalContent = inventoryTypeDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailTypeName.textContent = this.dataset.name;
                detailName.textContent = this.dataset.name;
                detailIsElectronic.textContent = this.dataset.isElectronic;
                detailIsConsumable.textContent = this.dataset.isConsumable;
                detailEconomicLife.textContent = this.dataset.economicLife;

                openModal(inventoryTypeDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(inventoryTypeDetailModal, detailModalContent));
        inventoryTypeDetailModal.addEventListener('click', function(event) {
            if (event.target === inventoryTypeDetailModal) {
                closeModal(inventoryTypeDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush