@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Tipe Tagihan
            </h1>
            <p class="text-gray-600 text-base">Kelola jenis-jenis tagihan pembayaran sekolah.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah --}}
            <a href="{{ route('finance.bill-types.create') }}"
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
        {{-- Card Total Tipe Tagihan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Tipe Tagihan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBillTypes }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-file-invoice fa-lg"></i>
            </div>
        </div>

        {{-- Card Tipe Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tipe Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeBillTypes }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Tipe Tagihan Pembayaran Online --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tipe Pembayaran Online</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $onlinePaymentBillTypes }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-wallet fa-lg"></i>
            </div>
        </div>

        {{-- Card Tipe Tagihan Bulanan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tipe Bulanan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $monthlyBillTypes }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('finance.bill-types.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau kode..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="status" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <select name="is_online_payment" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Pembayaran Online</option>
                <option value="1" {{ request('is_online_payment') === '1' ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ request('is_online_payment') === '0' ? 'selected' : '' }}>Tidak</option>
            </select>

            <select name="is_monthly" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Tipe Bulanan</option>
                <option value="1" {{ request('is_monthly') === '1' ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ request('is_monthly') === '0' ? 'selected' : '' }}>Tidak</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('finance.bill-types.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
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
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kode</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Deskripsi</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Online</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Bulanan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Aktif</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($billTypes as $type)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $type->name }}</td>
                            <td class="px-6 py-3">{{ $type->code }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $type->description ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @if($type->is_online_payment == 1)
                                    <span class="text-center inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ya</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Tidak</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($type->is_monthly == 1)
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ya</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Tidak</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($type->is_active == 1)
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $type->name }}"
                                            data-code="{{ $type->code }}"
                                            data-description="{{ $type->description ?? 'N/A' }}"
                                            data-is-active="{{ $type->is_active ? 'Aktif' : 'Nonaktif' }}"
                                            data-is-online-payment="{{ $type->is_online_payment ? 'Ya' : 'Tidak' }}"
                                            data-is-monthly="{{ $type->is_monthly ? 'Ya' : 'Tidak' }}"
                                            title="Lihat Detail Tipe Tagihan">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('finance.bill-types.edit', $type->id) }}" title="Edit Tipe Tagihan"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('finance.bill-types.destroy', $type->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus tipe tagihan ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus Tipe Tagihan"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">Belum ada tipe tagihan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $billTypes->links() }}
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Tipe Tagihan</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **jenis-jenis tagihan** yang berbeda di sekolah, seperti SPP bulanan, uang gedung, biaya ekstrakurikuler, dll.</p>
                <p>Setiap tipe tagihan memiliki kode dan deskripsi unik, serta status aktif/nonaktif.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama tipe tagihan (misal: SPP Bulanan, Uang Gedung).</li>
                    <li><strong class="font-semibold">Kode:</strong> Kode singkat tipe tagihan (misal: SPP, UG).</li>
                    <li><strong class="font-semibold">Deskripsi:</strong> Penjelasan singkat tentang tipe tagihan.</li>
                    <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah tipe tagihan aktif dan bisa digunakan.</li>
                    <li><strong class="font-semibold">Digunakan Untuk:</strong> Indikator penggunaan spesifik (misal: Pembayaran Online, Pembayaran Tagihan, dll.).</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Tipe Tagihan → Tagihan (Bills):** Setiap tagihan dibuat berdasarkan tipe yang sudah ada.</li>
                    <li>**Tipe Tagihan → Pembayaran:** Mempengaruhi proses dan jenis pembayaran yang masuk.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Manajemen tipe tagihan yang baik adalah kunci untuk akurasi dan efisiensi sistem keuangan sekolah.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Tipe Tagihan --}}
    <div id="billTypeDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Tipe Tagihan: <span id="detailTypeName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Tipe:</strong> <span id="detailName"></span></p>
                <p><strong>Kode:</strong> <span id="detailCode"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detailDescription"></span></p>
                <p><strong>Status Aktif:</strong> <span id="detailIsActive"></span></p>
                <p><strong>Tipe Pembayaran Online:</strong> <span id="detailIsOnlinePayment"></span></p>
                <p><strong>Tipe Bulanan:</strong> <span id="detailIsMonthly"></span></p>
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

        // --- Modal Detail Tipe Tagihan ---
        const billTypeDetailModal = document.getElementById('billTypeDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailTypeName = document.getElementById('detailTypeName');
        const detailName = document.getElementById('detailName');
        const detailCode = document.getElementById('detailCode');
        const detailDescription = document.getElementById('detailDescription');
        const detailIsActive = document.getElementById('detailIsActive');
        const detailIsOnlinePayment = document.getElementById('detailIsOnlinePayment');
        const detailIsMonthly = document.getElementById('detailIsMonthly');
        const detailModalContent = billTypeDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailTypeName.textContent = this.dataset.name;
                detailName.textContent = this.dataset.name;
                detailCode.textContent = this.dataset.code;
                detailDescription.textContent = this.dataset.description;
                detailIsActive.textContent = this.dataset.isActive;
                detailIsOnlinePayment.textContent = this.dataset.isOnlinePayment;
                detailIsMonthly.textContent = this.dataset.isMonthly;

                openModal(billTypeDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(billTypeDetailModal, detailModalContent));
        billTypeDetailModal.addEventListener('click', function(event) {
            if (event.target === billTypeDetailModal) {
                closeModal(billTypeDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush