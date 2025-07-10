@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Orang Tua / Wali
            </h1>
            <p class="text-gray-600 text-base">Data orang tua atau wali yang terhubung dengan siswa.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Import --}}
            <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-300 transition-colors duration-200 shadow-sm">
                <i class="fas fa-file-import mr-2"></i> Import
            </a>
            {{-- Tombol Export --}}
            <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold border border-gray-300 hover:bg-gray-300 transition-colors duration-200 shadow-sm">
                <i class="fas fa-file-export mr-2"></i> Export
            </a>
            {{-- Tombol Tambah Orang Tua --}}
            <a href="{{ route('core.parents.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Orang Tua
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
        {{-- Card Total Orang Tua --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Orang Tua</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalParents }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-users fa-lg"></i>
            </div>
        </div>

        {{-- Card Orang Tua Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Orang Tua Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeParents }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Orang Tua Laki-laki --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Orang Tua Laki-laki</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maleParents }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <i class="fas fa-male fa-lg"></i>
            </div>
        </div>

        {{-- Card Orang Tua Perempuan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Orang Tua Perempuan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $femaleParents }}</p>
            </div>
            <div class="p-3 bg-pink-100 rounded-full text-pink-600">
                <i class="fas fa-female fa-lg"></i>
            </div>
        </div>
    </div>


    <form method="GET" action="{{ route('core.parents.index') }}" class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded-xl shadow">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no HP"
            class="w-full border-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4">

        <select name="gender" class="w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Gender</option>
            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <select name="relationship" class="w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Hubungan</option>
            <option value="ayah" {{ request('relationship') == 'ayah' ? 'selected' : '' }}>Ayah</option>
            <option value="ibu" {{ request('relationship') == 'ibu' ? 'selected' : '' }}>Ibu</option>
            <option value="wali" {{ request('relationship') == 'wali' ? 'selected' : '' }}>Wali</option>
        </select>

        <select name="status" class="w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition self-end">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Terapkan Filter
        </button>
    </form>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mt-6">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Jenis Kelamin</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Hubungan</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Email</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">No HP</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Saldo</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($parents as $index => $parent)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4">{{ ($parents->currentPage() - 1) * $parents->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $parent->name }}</td>
                        <td class="px-6 py-4">
                            {{ $parent->gender === 'L' ? 'Laki-laki' : ($parent->gender === 'P' ? 'Perempuan' : '—') }}
                        </td>
                        <td class="px-6 py-4 capitalize">{{ $parent->relationship ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $parent->email ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $parent->phone ?? '—' }}</td>
                        {{-- Safely access wallet balance --}}
                        <td class="px-6 py-4">Rp {{ number_format($parent->wallet->balance ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if ($parent->is_active)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="inline-flex space-x-2">
                                {{-- Tombol Lihat Detail --}}
                                <button type="button"
                                        class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                        data-parent-id="{{ $parent->id }}"
                                        data-parent-name="{{ $parent->name }}"
                                        data-parent-gender="{{ $parent->gender === 'L' ? 'Laki-laki' : ($parent->gender === 'P' ? 'Perempuan' : '—') }}"
                                        data-parent-relationship="{{ $parent->relationship ?? 'N/A' }}"
                                        data-parent-email="{{ $parent->email ?? 'N/A' }}"
                                        data-parent-phone="{{ $parent->phone ?? 'N/A' }}"
                                        data-parent-address="{{ $parent->address ?? 'N/A' }}"
                                        data-parent-latest-topup="{{ number_format($parent->wallet?->latestTopupAmount ?? 0, 0, ',', '.') }}" {{-- Safe access for latestTopupAmount --}}
                                        data-parent-wallet-balance="Rp {{ number_format($parent->wallet->balance ?? 0, 0, ',', '.') }}"
                                        data-parent-active-children="{{ $parent->children->where('is_active', true)->count() }}"
                                        data-parent-status="{{ $parent->is_active ? 'Aktif' : 'Nonaktif' }}"
                                        title="Lihat Detail Orang Tua">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </button>

                                <a href="{{ route('core.parents.edit', $parent->id) }}" title="Edit Orang Tua"
                                   class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('core.parents.destroy', $parent->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data orang tua ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Orang Tua"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">Belum ada data orang tua.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $parents->withQueryString()->links() }}
    </div>
</div>

{{-- Modal Pop-up Informasi Umum Menu --}}
<div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Orang Tua / Wali</h3>
            <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-4">
            <p>Menu ini digunakan untuk mengelola daftar **orang tua atau wali** yang terhubung dengan siswa di sekolah.</p>
            <p>Setiap orang tua/wali dapat memiliki satu atau lebih anak yang terdaftar.</p>

            <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li><strong class="font-semibold">Nama:</strong> Nama lengkap orang tua/wali.</li>
                <li><strong class="font-semibold">Jenis Kelamin:</strong> Jenis kelamin orang tua/wali.</li>
                <li><strong class="font-semibold">Hubungan:</strong> Hubungan dengan siswa (Ayah, Ibu, Wali).</li>
                <li><strong class="font-semibold">Email:</strong> Alamat email guru untuk komunikasi.</li>
                <li><strong class="font-semibold">No HP:</strong> Nomor telepon seluler untuk kontak.</li>
                <li><strong class="font-semibold">Saldo:</strong> Saldo dompet kantin yang dimiliki oleh akun orang tua/wali.</li>
                <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah akun orang tua/wali aktif atau nonaktif.</li>
            </ul>

            <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li>**Orang Tua/Wali → Siswa:** Satu orang tua/wali dapat memiliki banyak siswa.</li>
                <li>**Orang Tua/Wali → Akun Pengguna:** Terhubung dengan akun pengguna untuk login ke portal orang tua.</li>
                <li>**Orang Tua/Wali → Dompet Kantin:** Memiliki dompet digital untuk transaksi kantin.</li>
            </ul>

            <p class="mt-4 text-sm italic text-gray-600">Pastikan data orang tua/wali selalu akurat untuk kelancaran komunikasi dan administrasi siswa.</p>
        </div>
    </div>
</div>

{{-- Modal Pop-up Detail Orang Tua --}}
<div id="parentDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800" id="detailModalTitle">Detail Orang Tua: <span id="detailParentName"></span></h3>
            <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-3">
            <p><strong>Nama Lengkap:</strong> <span id="detailName"></span></p>
            <p><strong>Jenis Kelamin:</strong> <span id="detailGender"></span></p>
            <p><strong>Hubungan:</strong> <span id="detailRelationship"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>No HP:</strong> <span id="detailPhone"></span></p>
            <p><strong>Alamat:</strong> <span id="detailAddress"></span></p>
            <p><strong>Saldo Dompet Kantin:</strong> <span id="detailWalletBalance"></span></p>
            <p><strong>Top Up Terakhir:</strong> <span id="detailLatestTopup"></span></p>
            <p><strong>Jumlah Anak Aktif:</strong> <span id="detailActiveChildren"></span></p>
            <p><strong>Status Akun:</strong> <span id="detailStatus"></span></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Informasi Menu ---
        const menuInfoModal = document.getElementById('menuInfoModal');
        const openMenuInfoModalBtn = document.getElementById('openMenuInfoModal');
        const closeMenuInfoModalBtn = document.getElementById('closeMenuInfoModal');
        const menuModalContent = menuInfoModal.querySelector('.transform');

        function openMenuModal() {
            menuInfoModal.classList.remove('hidden');
            setTimeout(() => {
                menuModalContent.classList.remove('scale-95', 'opacity-0');
                menuModalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeMenuModal() {
            menuModalContent.classList.remove('scale-100', 'opacity-100');
            menuModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menuInfoModal.classList.add('hidden');
            }, 300);
        }

        openMenuInfoModalBtn.addEventListener('click', openMenuModal);
        closeMenuInfoModalBtn.addEventListener('click', closeMenuModal);
        menuInfoModal.addEventListener('click', function(event) {
            if (event.target === menuInfoModal) {
                closeMenuModal();
            }
        });

        // --- Modal Detail Orang Tua ---
        const parentDetailModal = document.getElementById('parentDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailParentName = document.getElementById('detailParentName');
        const detailName = document.getElementById('detailName');
        const detailGender = document.getElementById('detailGender');
        const detailRelationship = document.getElementById('detailRelationship');
        const detailEmail = document.getElementById('detailEmail');
        const detailPhone = document.getElementById('detailPhone');
        const detailAddress = document.getElementById('detailAddress');
        const detailWalletBalance = document.getElementById('detailWalletBalance');
        const detailLatestTopup = document.getElementById('detailLatestTopup');
        const detailActiveChildren = document.getElementById('detailActiveChildren');
        const detailStatus = document.getElementById('detailStatus');
        const detailModalContent = parentDetailModal.querySelector('.transform');


        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data- attributes
                detailParentName.textContent = this.dataset.parentName;
                detailName.textContent = this.dataset.parentName;
                detailGender.textContent = this.dataset.parentGender;
                detailRelationship.textContent = this.dataset.parentRelationship;
                detailEmail.textContent = this.dataset.parentEmail;
                detailPhone.textContent = this.dataset.parentPhone;
                detailAddress.textContent = this.dataset.parentAddress;
                detailWalletBalance.textContent = this.dataset.parentWalletBalance;
                detailLatestTopup.textContent = this.dataset.parentLatestTopup;
                detailActiveChildren.textContent = this.dataset.parentActiveChildren;
                detailStatus.textContent = this.dataset.parentStatus;


                parentDetailModal.classList.remove('hidden');
                setTimeout(() => {
                    detailModalContent.classList.remove('scale-95', 'opacity-0');
                    detailModalContent.classList.add('scale-100', 'opacity-100');
                }, 50);
            });
        });

        closeDetailModalBtn.addEventListener('click', function() {
            detailModalContent.classList.remove('scale-100', 'opacity-100');
            detailModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                parentDetailModal.classList.add('hidden');
            }, 300);
        });

        parentDetailModal.addEventListener('click', function(event) {
            if (event.target === parentDetailModal) {
                detailModalContent.classList.remove('scale-100', 'opacity-100');
                detailModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    parentDetailModal.classList.add('hidden');
                }, 300);
            }
        });
    });
</script>
@endpush