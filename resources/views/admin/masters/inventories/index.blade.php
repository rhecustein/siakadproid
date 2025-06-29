@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Inventaris
            </h1>
            <p class="text-gray-600 text-base">Semua inventaris yang terdaftar dalam sistem.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Inventaris --}}
            <a href="{{ route('facility.inventories.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Inventaris
            </a>
            {{-- Tombol Tipe Inventaris --}}
            <a href="{{ route('facility.inventory-types.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 min-w-max">
                <i class="fas fa-boxes mr-2"></i> Tipe Inventaris
            </a>
            {{-- Tombol Kondisi Inventaris --}}
            <a href="{{ route('facility.inventory-conditions.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-yellow-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-yellow-700 transition-colors duration-200 min-w-max">
                <i class="fas fa-hand-holding-box mr-2"></i> Kondisi Inventaris
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
        {{-- Card Total Inventaris --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Inventaris</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalInventories }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-warehouse fa-lg"></i>
            </div>
        </div>

        {{-- Card Inventaris di Ruangan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Inventaris di Ruangan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $inventoriesInRooms }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <i class="fas fa-door-open fa-lg"></i>
            </div>
        </div>

        {{-- Card Inventaris Kondisi Baik --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Kondisi Baik</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $goodConditionInventories }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-thumbs-up fa-lg"></i>
            </div>
        </div>

        {{-- Card Total Quantity Inventaris --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kuantitas</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalQuantity }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-boxes fa-lg"></i>
            </div>
        </div>
    </div>


    <!-- Filter/Search -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('facility.inventories.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau kode..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            {{-- Asumsi $types dilewatkan dari controller --}}
            <select name="type_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Tipe</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>

            {{-- Asumsi $conditions dilewatkan dari controller --}}
            <select name="condition_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Kondisi</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ request('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                @endforeach
            </select>

            {{-- Asumsi $rooms dilewatkan dari controller --}}
            <select name="room_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Ruangan</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('facility.inventories.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kode</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Ruangan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tipe</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kondisi</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kuantitas</th>
                        <th class="px-6 py-3 text-center border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($inventories as $index => $inv)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $inventories->firstItem() + $index }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $inv->name }}</td>
                            <td class="px-6 py-3">{{ $inv->code }}</td>
                            <td class="px-6 py-3">{{ $inv->room->name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $inv->type->name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $inv->condition->name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $inv->quantity }}</td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $inv->name }}"
                                            data-code="{{ $inv->code }}"
                                            data-description="{{ $inv->description ?? 'N/A' }}"
                                            data-room="{{ $inv->room->name ?? 'N/A' }}"
                                            data-type="{{ $inv->type->name ?? 'N/A' }}"
                                            data-condition="{{ $inv->condition->name ?? 'N/A' }}"
                                            data-quantity="{{ $inv->quantity }}"
                                            data-purchase-date="{{ $inv->purchase_date ? \Carbon\Carbon::parse($inv->purchase_date)->translatedFormat('d M Y') : 'N/A' }}"
                                            data-notes="{{ $inv->notes ?? 'N/A' }}"
                                            title="Lihat Detail Inventaris">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('facility.inventories.edit', $inv->id) }}" title="Edit Inventaris"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('facility.inventories.destroy', $inv->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus item inventaris ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus Inventaris"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data inventaris ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $inventories->links() }}
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Inventaris</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **daftar aset atau barang inventaris** yang dimiliki oleh sekolah, serta lokasinya di ruangan tertentu.</p>
                <p>Setiap item inventaris memiliki tipe, kondisi, kuantitas, dan informasi lainnya.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama inventaris (misal: Meja Guru, Proyektor).</li>
                    <li><strong class="font-semibold">Kode:</strong> Kode unik inventaris.</li>
                    <li><strong class="font-semibold">Ruangan:</strong> Lokasi ruangan tempat inventaris berada.</li>
                    <li><strong class="font-semibold">Tipe:</strong> Kategori inventaris (misal: Elektronik, Furnitur, Buku).</li>
                    <li><strong class="font-semibold">Kondisi:</strong> Status kondisi inventaris (misal: Baik, Rusak Ringan, Rusak Berat).</li>
                    <li><strong class="font-semibold">Kuantitas:</strong> Jumlah unit inventaris yang tersedia.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Inventaris → Ruangan:** Setiap inventaris terhubung dengan satu ruangan fisik.</li>
                    <li>**Inventaris → Tipe Inventaris:** Terkategorikan berdasarkan jenisnya.</li>
                    <li>**Inventaris → Kondisi Inventaris:** Terkategorikan berdasarkan status fisiknya.</li>
                    <li>**Inventaris → Pemeliharaan:** Dapat terkait dengan jadwal pemeliharaan atau perbaikan.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Manajemen inventaris yang efektif membantu dalam pengawasan aset dan perencanaan kebutuhan sekolah.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Inventaris --}}
    <div id="inventoryDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Inventaris: <span id="detailInventoryName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Inventaris:</strong> <span id="detailName"></span></p>
                <p><strong>Kode:</strong> <span id="detailCode"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detailDescription"></span></p>
                <p><strong>Ruangan:</strong> <span id="detailRoom"></span></p>
                <p><strong>Tipe:</strong> <span id="detailType"></span></p>
                <p><strong>Kondisi:</strong> <span id="detailCondition"></span></p>
                <p><strong>Kuantitas:</strong> <span id="detailQuantity"></span></p>
                <p><strong>Tanggal Pembelian:</strong> <span id="detailPurchaseDate"></span></p>
                <p><strong>Catatan:</strong> <span id="detailNotes"></span></p>
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

        // --- Modal Detail Inventaris ---
        const inventoryDetailModal = document.getElementById('inventoryDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailInventoryName = document.getElementById('detailInventoryName');
        const detailName = document.getElementById('detailName');
        const detailCode = document.getElementById('detailCode');
        const detailDescription = document.getElementById('detailDescription');
        const detailRoom = document.getElementById('detailRoom');
        const detailType = document.getElementById('detailType');
        const detailCondition = document.getElementById('detailCondition');
        const detailQuantity = document.getElementById('detailQuantity');
        const detailPurchaseDate = document.getElementById('detailPurchaseDate');
        const detailNotes = document.getElementById('detailNotes');
        const detailModalContent = inventoryDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailInventoryName.textContent = this.dataset.name;
                detailName.textContent = this.dataset.name;
                detailCode.textContent = this.dataset.code;
                detailDescription.textContent = this.dataset.description;
                detailRoom.textContent = this.dataset.room;
                detailType.textContent = this.dataset.type;
                detailCondition.textContent = this.dataset.condition;
                detailQuantity.textContent = this.dataset.quantity;
                detailPurchaseDate.textContent = this.dataset.purchaseDate;
                detailNotes.textContent = this.dataset.notes;

                openModal(inventoryDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(inventoryDetailModal, detailModalContent));
        inventoryDetailModal.addEventListener('click', function(event) {
            if (event.target === inventoryDetailModal) {
                closeModal(inventoryDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush