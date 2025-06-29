@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Tagihan Siswa
            </h1>
            <p class="text-gray-600 text-base">Kelola daftar tagihan pembayaran siswa.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Buat Tagihan --}}
            <a href="{{ route('finance.bills.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Buat Tagihan
            </a>
            {{-- Tombol Generate Tagihan Masal --}}
            <a href="{{ route('finance.bill-generates.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 min-w-max">
                <i class="fas fa-magic mr-2"></i> Generate Tagihan Masal
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
    @elseif(session('error'))
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
            <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Count Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card Total Tagihan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Tagihan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalBillsAmount, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-file-invoice-dollar fa-lg"></i>
            </div>
        </div>

        {{-- Card Tagihan Belum Lunas --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Belum Lunas</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($unpaidBillsAmount, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-full text-red-600">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
            </div>
        </div>

        {{-- Card Tagihan Lunas --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Lunas</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($paidBillsAmount, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Jumlah Tagihan Siswa --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Tagihan Siswa</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStudentsWithBills }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-users fa-lg"></i>
            </div>
        </div>
    </div>


    {{-- Filter Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('finance.bills.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama siswa atau judul tagihan..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="student_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Siswa</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->nis ?? 'N/A' }})
                    </option>
                @endforeach
            </select>

            <select name="bill_group_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Grup Tagihan</option>
                @foreach($billGroups as $group)
                    <option value="{{ $group->id }}" {{ request('bill_group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Sebagian Lunas</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('finance.bills.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>
    </div>

    {{-- Tabel Tagihan --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Siswa</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tagihan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Grup Tagihan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Progress Pembayaran</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Pembayaran Terakhir</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-right">Total Tagihan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-right">Sisa Tagihan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Dibuat</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bills as $bill)
                        @php
                            $items = $bill->items ?? collect();
                            $totalItems = $items->count();
                            $paidItems = $items->where('status', 'paid')->count();
                            $lastPaymentDate = $items->whereNotNull('paid_at')->sortByDesc('paid_at')->first()?->paid_at;
                            $paidAmount = $items->where('status', 'paid')->sum('amount');
                            $remaining = $bill->total_amount - $paidAmount;
                        @endphp
                        <tr class="border-t hover:bg-blue-50 transition-colors duration-150">
                            <td class="p-3">{{ $loop->iteration + ($bills->currentPage() - 1) * $bills->perPage() }}</td>
                            <td class="p-3 text-gray-800 font-medium">{{ $bill->student->name ?? '-' }}</td>
                            <td class="p-3 text-gray-700">{{ $bill->title ?? '-' }}</td>
                            <td class="p-3 text-gray-700">{{ $bill->billGroup->name ?? '-' }}</td>
                            <td class="p-3 text-gray-700">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $totalItems > 0 ? ($paidItems / $totalItems) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">{{ $paidItems }} / {{ $totalItems }} Item Lunas</span>
                            </td>
                            <td class="p-3 text-gray-600">
                                {{ $lastPaymentDate ? \Carbon\Carbon::parse($lastPaymentDate)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="p-3 text-right text-gray-700">
                                Rp {{ number_format($bill->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="p-3 text-right text-gray-700">
                                Rp {{ number_format($remaining, 0, ',', '.') }}
                            </td>
                            <td class="p-3">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if($bill->status === 'paid') bg-green-100 text-green-700
                                    @elseif($bill->status === 'partial') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-600">
                                {{ $bill->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-3 text-right whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-bill-id="{{ $bill->id }}"
                                            data-student-name="{{ $bill->student->name ?? 'N/A' }}"
                                            data-title="{{ $bill->title ?? 'N/A' }}"
                                            data-bill-group="{{ $bill->billGroup->name ?? 'N/A' }}"
                                            data-total-amount="Rp {{ number_format($bill->total_amount, 0, ',', '.') }}"
                                            data-paid-amount="Rp {{ number_format($paidAmount, 0, ',', '.') }}"
                                            data-remaining-amount="Rp {{ number_format($remaining, 0, ',', '.') }}"
                                            data-status="{{ ucfirst($bill->status) }}"
                                            data-created-at="{{ $bill->created_at->translatedFormat('d M Y H:i') }}"
                                            data-due-date="{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d M Y') : 'N/A' }}"
                                            title="Lihat Detail Tagihan">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    {{-- Tidak ada edit di sini, karena tagihan siswa biasanya kompleks (via BillItem) --}}

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('finance.bills.destroy', $bill->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tagihan ini? Ini juga akan menghapus semua item tagihan terkait. Tindakan ini tidak dapat dibatalkan.')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <i class="fas fa-trash-alt w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="p-4 text-center text-gray-500">Tidak ada tagihan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $bills->withQueryString()->links() }}
        </div>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Tagihan Siswa</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **tagihan pembayaran** yang dikeluarkan kepada setiap siswa.</p>
                <p>Setiap tagihan terhubung dengan seorang siswa, grup tagihan, dan memiliki detail item pembayaran.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama Siswa:</strong> Nama siswa penerima tagihan.</li>
                    <li><strong class="font-semibold">Tagihan:</strong> Judul atau deskripsi utama tagihan.</li>
                    <li><strong class="font-semibold">Grup Tagihan:</strong> Kategori tagihan (misal: SPP, Uang Gedung).</li>
                    <li><strong class="font-semibold">Progress Pembayaran:</strong> Jumlah item tagihan yang sudah lunas dari total.</li>
                    <li><strong class="font-semibold">Pembayaran Terakhir:</strong> Tanggal pembayaran terakhir yang tercatat.</li>
                    <li><strong class="font-semibold">Total Tagihan:</strong> Jumlah total yang harus dibayar.</li>
                    <li><strong class="font-semibold">Sisa Tagihan:</strong> Jumlah sisa yang belum dibayar.</li>
                    <li><strong class="font-semibold">Status:</strong> Status keseluruhan tagihan (Belum Lunas, Sebagian Lunas, Lunas).</li>
                    <li><strong class="font-semibold">Dibuat:</strong> Tanggal tagihan dibuat.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Tagihan → Siswa:** Setiap tagihan terkait dengan satu siswa.</li>
                    <li>**Tagihan → Grup Tagihan:** Terkategorikan ke dalam grup tagihan.</li>
                    <li>**Tagihan → Item Tagihan:** Setiap tagihan terdiri dari beberapa item pembayaran.</li>
                    <li>**Tagihan → Pembayaran:** Terhubung dengan transaksi pembayaran yang masuk.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Manajemen tagihan yang efisien sangat penting untuk kelancaran arus kas dan pelacakan keuangan sekolah.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Tagihan --}}
    <div id="billDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Tagihan: <span id="detailModalTitle"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Siswa:</strong> <span id="detailStudentName"></span></p>
                <p><strong>Judul Tagihan:</strong> <span id="detailTitle"></span></p>
                <p><strong>Grup Tagihan:</strong> <span id="detailBillGroup"></span></p>
                <p><strong>Total Tagihan:</strong> <span id="detailTotalAmount"></span></p>
                <p><strong>Jumlah Terbayar:</strong> <span id="detailPaidAmount"></span></p>
                <p><strong>Sisa Tagihan:</strong> <span id="detailRemainingAmount"></span></p>
                <p><strong>Status Pembayaran:</strong> <span id="detailStatus"></span></p>
                <p><strong>Tanggal Dibuat:</strong> <span id="detailCreatedAt"></span></p>
                <p><strong>Jatuh Tempo:</strong> <span id="detailDueDate"></span></p>
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

        // --- Modal Detail Tagihan ---
        const billDetailModal = document.getElementById('billDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailModalTitle = document.getElementById('detailModalTitle');
        const detailStudentName = document.getElementById('detailStudentName');
        const detailTitle = document.getElementById('detailTitle');
        const detailBillGroup = document.getElementById('detailBillGroup');
        const detailTotalAmount = document.getElementById('detailTotalAmount');
        const detailPaidAmount = document.getElementById('detailPaidAmount');
        const detailRemainingAmount = document.getElementById('detailRemainingAmount');
        const detailStatus = document.getElementById('detailStatus');
        const detailCreatedAt = document.getElementById('detailCreatedAt');
        const detailDueDate = document.getElementById('detailDueDate');
        const detailModalContent = billDetailModal.querySelector('.transform');


        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailModalTitle.textContent = this.dataset.title; // Set title of modal
                detailStudentName.textContent = this.dataset.studentName;
                detailTitle.textContent = this.dataset.title;
                detailBillGroup.textContent = this.dataset.billGroup;
                detailTotalAmount.textContent = this.dataset.totalAmount;
                detailPaidAmount.textContent = this.dataset.paidAmount;
                detailRemainingAmount.textContent = this.dataset.remainingAmount;
                detailStatus.textContent = this.dataset.status;
                detailCreatedAt.textContent = this.dataset.createdAt;
                detailDueDate.textContent = this.dataset.dueDate;


                openModal(billDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(billDetailModal, detailModalContent));
        billDetailModal.addEventListener('click', function(event) {
            if (event.target === billDetailModal) {
                closeModal(billDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush