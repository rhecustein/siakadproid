@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Grup Tagihan
            </h1>
            <p class="text-gray-600 text-base">Kelola kelompok tagihan untuk memudahkan pengelolaan pembayaran siswa.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Grup --}}
            <a href="{{ route('finance.bill-groups.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Grup
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
        {{-- Card Total Grup Tagihan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Grup Tagihan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBillGroups }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-layer-group fa-lg"></i>
            </div>
        </div>

        {{-- Card Grup Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Grup Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeBillGroups }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Grup SPP (Asumsi type 'spp') --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Grup SPP</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $sppGroups }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
        </div>

        {{-- Card Grup Uang Gedung (Asumsi type 'uang_gedung') --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Grup Uang Gedung</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $gedungGroups }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-building fa-lg"></i>
            </div>
        </div>
    </div>


    {{-- Filter Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('finance.bill-groups.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" placeholder="Cari nama grup..." value="{{ request('search') }}"
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="type" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Jenis Tagihan</option>
                @foreach(App\Models\BillGroup::TYPES as $key => $label)
                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            {{-- Asumsi $schools dilewatkan dari controller --}}
            <select name="school_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Sekolah</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                @endforeach
            </select>

            {{-- Asumsi $levels dilewatkan dari controller --}}
            <select name="level_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Jenjang</option>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                @endforeach
            </select>

            <input type="text" name="academic_year" placeholder="Tahun Ajaran (cth: 2024)"
                   value="{{ request('academic_year') }}"
                   class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('finance.bill-groups.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Grup</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Jenis Tagihan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Sekolah</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Jenjang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kelas Target</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tahun Ajaran</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Target Gender</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-right">Nominal per Item</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Jumlah Item</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Periode</th>
                        <th class="px-6 py-3 text-center border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($billGroups as $group)
                        <tr class="border-t hover:bg-blue-50 transition-colors duration-150">
                            <td class="p-3">{{ $loop->iteration + ($billGroups->currentPage() - 1) * $billGroups->perPage() }}</td>
                            <td class="p-3 font-semibold text-gray-800">{{ $group->name }}</td>
                            <td class="p-3 text-gray-600">{{ $group->billType->name ?? $group->type }}</td> {{-- Display bill type name or raw type --}}
                            <td class="p-3 text-gray-700">{{ $group->school->name ?? '-' }}</td>
                            <td class="p-3 text-gray-700">{{ $group->level->name ?? '-' }}</td>
                            <td class="p-3 text-gray-700">{{ $group->gradelevel->name ?? '-' }}</td> {{-- Assuming 'grade' relation for grade level name --}}
                            <td class="p-3 text-gray-700">{{ $group->academicYear->year ?? '-' }}</td> {{-- Assuming academicYear relation --}}
                            <td class="p-3 text-gray-700 capitalize">
                                @if($group->gender)
                                    {{ $group->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    Semua
                                @endif
                            </td>
                            <td class="p-3 text-right">Rp {{ number_format($group->amount_per_tagihan, 0, ',', '.') }}</td>
                            <td class="p-3 text-center">{{ $group->tagihan_count }}</td>
                            <td class="p-3 text-gray-600">
                                @if($group->start_date && $group->end_date)
                                    {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $group->name }}"
                                            data-type="{{ $group->billType->name ?? $group->type }}"
                                            data-school="{{ $group->school->name ?? 'N/A' }}"
                                            data-level="{{ $group->level->name ?? 'N/A' }}"
                                            data-grade="{{ $group->grade->name ?? 'N/A' }}"
                                            data-academic-year="{{ $group->academicYear->year ?? 'N/A' }}"
                                            data-gender="{{ $group->gender ? ($group->gender == 'male' ? 'Laki-laki' : 'Perempuan') : 'Semua' }}"
                                            data-amount-per-tagihan="Rp {{ number_format($group->amount_per_tagihan, 0, ',', '.') }}"
                                            data-tagihan-count="{{ $group->tagihan_count }}"
                                            data-start-date="{{ $group->start_date ? \Carbon\Carbon::parse($group->start_date)->translatedFormat('d M Y') : 'N/A' }}"
                                            data-end-date="{{ $group->end_date ? \Carbon\Carbon::parse($group->end_date)->translatedFormat('d M Y') : 'N/A' }}"
                                            data-description="{{ $group->description ?? 'N/A' }}"
                                            title="Lihat Detail Grup Tagihan">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('finance.bill-groups.edit', $group->id) }}"
                                    class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>

                                    <form action="{{ route('finance.bill-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus grup ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                        @csrf @method('DELETE')
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
                            <td colspan="12" class="p-4 text-center text-gray-500">Tidak ada grup tagihan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $billGroups->links() }}
        </div>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Grup Tagihan</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **kelompok tagihan pembayaran** yang dapat digenerate secara masal kepada siswa berdasarkan kriteria tertentu.</p>
                <p>Setiap grup tagihan memiliki nama, jenis tagihan terkait, target sekolah/jenjang/kelas/gender, nominal, jumlah item, dan periode berlakunya.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama Grup:</strong> Nama kelompok tagihan (misal: SPP Siswa Baru 2024).</li>
                    <li><strong class="font-semibold">Jenis Tagihan:</strong> Tipe tagihan yang akan digenerate (misal: SPP Bulanan, Uang Gedung).</li>
                    <li><strong class="font-semibold">Sekolah, Jenjang, Kelas Target:</strong> Kriteria siswa yang akan menerima tagihan ini.</li>
                    <li><strong class="font-semibold">Tahun Ajaran:</strong> Tahun akademik grup tagihan ini berlaku.</li>
                    <li><strong class="font-semibold">Target Gender:</strong> Filter siswa berdasarkan jenis kelamin.</li>
                    <li><strong class="font-semibold">Nominal per Item:</strong> Jumlah uang untuk setiap item tagihan.</li>
                    <li><strong class="font-semibold">Jumlah Item:</strong> Berapa kali item tagihan akan muncul (misal: 12 untuk SPP 12 bulan).</li>
                    <li><strong class="font-semibold">Periode:</strong> Tanggal mulai dan berakhirnya grup tagihan ini.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Grup Tagihan → Tipe Tagihan:** Setiap grup dikaitkan dengan satu jenis tagihan.</li>
                    <li>**Grup Tagihan → Siswa:** Tagihan akan digenerate ke siswa yang memenuhi kriteria grup.</li>
                    <li>**Grup Tagihan → Tagihan:** Menjadi dasar pembuatan tagihan individual siswa.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Grup tagihan menyederhanakan proses pembuatan tagihan yang seragam untuk banyak siswa.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Grup Tagihan --}}
    <div id="billGroupDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Grup Tagihan: <span id="detailGroupName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Grup:</strong> <span id="detailName"></span></p>
                <p><strong>Jenis Tagihan:</strong> <span id="detailBillType"></span></p>
                <p><strong>Sekolah:</strong> <span id="detailSchool"></span></p>
                <p><strong>Jenjang:</strong> <span id="detailLevel"></span></p>
                <p><strong>Kelas Target:</strong> <span id="detailGrade"></span></p>
                <p><strong>Tahun Ajaran:</strong> <span id="detailAcademicYear"></span></p>
                <p><strong>Target Gender:</strong> <span id="detailGender"></span></p>
                <p><strong>Nominal per Item:</strong> <span id="detailAmountPerTagihan"></span></p>
                <p><strong>Jumlah Item:</strong> <span id="detailTagihanCount"></span></p>
                <p><strong>Periode Berlaku:</strong> <span id="detailPeriod"></span></p>
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

        // --- Modal Detail Grup Tagihan ---
        const billGroupDetailModal = document.getElementById('billGroupDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailGroupName = document.getElementById('detailGroupName');
        const detailName = document.getElementById('detailName');
        const detailBillType = document.getElementById('detailBillType');
        const detailSchool = document.getElementById('detailSchool');
        const detailLevel = document.getElementById('detailLevel');
        const detailGrade = document.getElementById('detailGrade');
        const detailAcademicYear = document.getElementById('detailAcademicYear');
        const detailGender = document.getElementById('detailGender');
        const detailAmountPerTagihan = document.getElementById('detailAmountPerTagihan');
        const detailTagihanCount = document.getElementById('detailTagihanCount');
        const detailPeriod = document.getElementById('detailPeriod');
        const detailDescription = document.getElementById('detailDescription');
        const detailModalContent = billGroupDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailGroupName.textContent = this.dataset.name;
                detailName.textContent = this.dataset.name;
                detailBillType.textContent = this.dataset.type;
                detailSchool.textContent = this.dataset.school;
                detailLevel.textContent = this.dataset.level;
                detailGrade.textContent = this.dataset.grade;
                detailAcademicYear.textContent = this.dataset.academicYear;
                detailGender.textContent = this.dataset.gender;
                detailAmountPerTagihan.textContent = this.dataset.amountPerTagihan;
                detailTagihanCount.textContent = this.dataset.tagihanCount;
                detailPeriod.textContent = this.dataset.startDate && this.dataset.endDate ? `${this.dataset.startDate} - ${this.dataset.endDate}` : 'N/A'; // Combine
                detailDescription.textContent = this.dataset.description;

                openModal(billGroupDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(billGroupDetailModal, detailModalContent));
        billGroupDetailModal.addEventListener('click', function(event) {
            if (event.target === billGroupDetailModal) {
                closeModal(billGroupDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush