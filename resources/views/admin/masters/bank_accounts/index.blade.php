@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Rekening Bank
            </h1>
            <p class="text-gray-600 text-base">Daftar rekening bank yang digunakan untuk pembayaran sekolah dan donasi.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Akun --}}
            <a href="{{ route('finance.bank-accounts.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Akun
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
        {{-- Card Total Akun --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Akun</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAccounts }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-university fa-lg"></i>
            </div>
        </div>

        {{-- Card Akun Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Akun Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeAccounts }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Akun Online Payment --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pembayaran Online</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $onlinePaymentAccounts }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-wallet fa-lg"></i>
            </div>
        </div>

        {{-- Card Akun Donasi --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Akun Donasi</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $donationAccounts }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-hand-holding-usd fa-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">No. Rekening</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Pemegang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Bank</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Sekolah</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Digunakan Untuk</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Aktif</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($accounts as $account)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $account->account_number }}</td>
                            <td class="px-6 py-3">{{ $account->account_holder }}</td>
                            <td class="px-6 py-3">{{ $account->bank_name }} <span class="text-xs text-gray-500">({{ $account->bank_code }})</span></td>
                            <td class="px-6 py-3">{{ $account->school->name ?? '-' }}</td> {{-- Asumsi relasi school di model bank account --}}
                            <td class="px-6 py-3 space-x-1">
                                @if($account->online_payment)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Online</span>
                                @endif
                                @if($account->can_pay_bills)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Tagihan</span>
                                @endif
                                @if($account->can_save)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">Tabungan</span>
                                @endif
                                @if($account->can_donate)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">Donasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if ($account->is_active)
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
                                            data-account-number="{{ $account->account_number }}"
                                            data-account-holder="{{ $account->account_holder }}"
                                            data-bank-name="{{ $account->bank_name }}"
                                            data-bank-code="{{ $account->bank_code }}"
                                            data-school-name="{{ $account->school->name ?? 'N/A' }}"
                                            data-is-active="{{ $account->is_active ? 'Aktif' : 'Nonaktif' }}"
                                            data-online-payment="{{ $account->online_payment ? 'Ya' : 'Tidak' }}"
                                            data-can-pay-bills="{{ $account->can_pay_bills ? 'Ya' : 'Tidak' }}"
                                            data-can-save="{{ $account->can_save ? 'Ya' : 'Tidak' }}"
                                            data-can-donate="{{ $account->can_donate ? 'Ya' : 'Tidak' }}"
                                            title="Lihat Detail Rekening">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('finance.bank-accounts.edit', $account->id) }}"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('finance.bank-accounts.destroy', $account->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus rekening ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">Belum ada rekening bank yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $accounts->links() }}
        </div>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Rekening Bank</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola daftar **rekening bank** yang digunakan oleh sekolah untuk berbagai transaksi keuangan, seperti pembayaran SPP, donasi, atau tabungan.</p>
                <p>Pastikan semua detail rekening akurat dan statusnya selalu diperbarui.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">No. Rekening:</strong> Nomor rekening bank.</li>
                    <li><strong class="font-semibold">Nama Pemegang:</strong> Nama pemilik rekening.</li>
                    <li><strong class="font-semibold">Bank:</strong> Nama bank dan kode bank.</li>
                    <li><strong class="font-semibold">Sekolah:</strong> Sekolah yang terkait dengan rekening ini (jika spesifik).</li>
                    <li><strong class="font-semibold">Digunakan Untuk:</strong> Indikator penggunaan rekening (misal: Pembayaran Online, Tagihan, Tabungan, Donasi).</li>
                    <li><strong class="font-semibold">Aktif:</strong> Status rekening (Aktif/Nonaktif).</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Rekening Bank → Sekolah:** Setiap rekening dapat terhubung dengan satu sekolah.</li>
                    <li>**Rekening Bank → Transaksi Keuangan:** Menjadi tujuan atau sumber dana untuk berbagai transaksi.</li>
                    <li>**Rekening Bank → Virtual Account:** Rekening bank dapat memiliki Virtual Account terkait.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Manajemen rekening bank yang akurat mendukung transparansi dan efisiensi keuangan sekolah.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Rekening Bank --}}
    <div id="bankAccountDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="detailModalTitle">Detail Rekening Bank: <span id="detailAccountNumber"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nomor Rekening:</strong> <span id="detailAccNumber"></span></p>
                <p><strong>Nama Pemegang:</strong> <span id="detailAccHolder"></span></p>
                <p><strong>Nama Bank:</strong> <span id="detailBankName"></span></p>
                <p><strong>Kode Bank:</strong> <span id="detailBankCode"></span></p>
                <p><strong>Sekolah Terkait:</strong> <span id="detailSchoolName"></span></p>
                <p><strong>Status Aktif:</strong> <span id="detailIsActive"></span></p>
                <p><strong>Untuk Pembayaran Online:</strong> <span id="detailOnlinePayment"></span></p>
                <p><strong>Untuk Pembayaran Tagihan:</strong> <span id="detailCanPayBills"></span></p>
                <p><strong>Untuk Tabungan:</strong> <span id="detailCanSave"></span></p>
                <p><strong>Untuk Donasi:</strong> <span id="detailCanDonate"></span></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Informasi Umum Menu ---
        const menuInfoModal = document.getElementById('menuInfoModal');
        const openMenuInfoModalBtn = document.getElementById('openMenuInfoModal');
        const closeMenuInfoModalBtn = document.getElementById('closeMenuInfoModal');
        const menuModalContent = menuInfoModal.querySelector('.transform');

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

        openMenuInfoModalBtn.addEventListener('click', () => openModal(menuInfoModal, menuModalContent));
        closeMenuInfoModalBtn.addEventListener('click', () => closeModal(menuInfoModal, menuModalContent));
        menuInfoModal.addEventListener('click', function(event) {
            if (event.target === menuInfoModal) {
                closeModal(menuInfoModal, menuModalContent);
            }
        });

        // --- Modal Detail Rekening Bank ---
        const bankAccountDetailModal = document.getElementById('bankAccountDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailAccountNumber = document.getElementById('detailAccountNumber');
        const detailAccNumber = document.getElementById('detailAccNumber');
        const detailAccHolder = document.getElementById('detailAccHolder');
        const detailBankName = document.getElementById('detailBankName');
        const detailBankCode = document.getElementById('detailBankCode');
        const detailSchoolName = document.getElementById('detailSchoolName');
        const detailIsActive = document.getElementById('detailIsActive');
        const detailOnlinePayment = document.getElementById('detailOnlinePayment');
        const detailCanPayBills = document.getElementById('detailCanPayBills');
        const detailCanSave = document.getElementById('detailCanSave');
        const detailCanDonate = document.getElementById('detailCanDonate');
        const detailModalContent = bankAccountDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data- attributes
                detailAccountNumber.textContent = this.dataset.accountNumber;
                detailAccNumber.textContent = this.dataset.accountNumber;
                detailAccHolder.textContent = this.dataset.accountHolder;
                detailBankName.textContent = this.dataset.bankName;
                detailBankCode.textContent = this.dataset.bankCode;
                detailSchoolName.textContent = this.dataset.schoolName;
                detailIsActive.textContent = this.dataset.isActive;
                detailOnlinePayment.textContent = this.dataset.onlinePayment;
                detailCanPayBills.textContent = this.dataset.canPayBills;
                detailCanSave.textContent = this.dataset.canSave;
                detailCanDonate.textContent = this.dataset.canDonate;

                openModal(bankAccountDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(bankAccountDetailModal, detailModalContent));
        bankAccountDetailModal.addEventListener('click', function(event) {
            if (event.target === bankAccountDetailModal) {
                closeModal(bankAccountDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush