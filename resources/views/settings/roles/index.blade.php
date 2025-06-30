@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Peran Pengguna
            </h1>
            <p class="text-gray-600 text-base">Kelola peran dan hak akses pengguna dalam sistem.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Peran --}}
            <a href="{{ route('core.roles.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Peran
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
        {{-- Card Total Peran --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Peran</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalRoles }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-user-tag fa-lg"></i>
            </div>
        </div>

        {{-- Card Peran Web --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Peran Web</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $webRoles }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-globe fa-lg"></i>
            </div>
        </div>

        {{-- Card Peran API --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Peran API</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $apiRoles }}</p>
            </div>
            <div class="p-3 bg-teal-100 rounded-full text-teal-600">
                <i class="fas fa-network-wired fa-lg"></i>
            </div>
        </div>

        {{-- Card Peran Aktif (sudah ditugaskan ke user) --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Peran Terpakai</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeRoles }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-double fa-lg"></i>
            </div>
        </div>
    </div>


    {{-- Filter & Search Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('core.roles.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau deskripsi peran..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="guard_name" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Guard</option>
                <option value="web" {{ request('guard_name') == 'web' ? 'selected' : '' }}>Web</option>
                <option value="api" {{ request('guard_name') == 'api' ? 'selected' : '' }}>API</option>
            </select>
            {{-- Tambahkan filter Scope jika Anda ingin menampilkan filter berdasarkan scope --}}
            {{--
            <select name="scope" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Scope</option>
                <option value="sd" {{ request('scope') == 'sd' ? 'selected' : '' }}>SD</option>
                <option value="smp" {{ request('scope') == 'smp' ? 'selected' : '' }}>SMP</option>
                <option value="sma" {{ request('scope') == 'sma' ? 'selected' : '' }}>SMA</option>
                <option value="ponpes" {{ request('scope') == 'ponpes' ? 'selected' : '' }}>Pondok</option>
            </select>
            --}}

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('core.roles.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
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
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Peran</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Tampilan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Guard</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Deskripsi</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Lingkup (Scope)</th>
                        <th class="px-6 py-3 text-center border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $index => $role)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-3">{{ $roles->firstItem() + $index }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $role->display_name ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $role->guard_name }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $role->description ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-700">
                                @if($role->scope)
                                    @foreach(json_decode($role->scope) as $scope)
                                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full mr-1">{{ $scope }}</span>
                                    @endforeach
                                @else
                                    Semua
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    {{-- Tombol Lihat Detail (Opsional, bisa tambahkan di sini jika detail berbeda dari edit) --}}
                                    <button type="button"
                                            class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                            data-name="{{ $role->name }}"
                                            data-display-name="{{ $role->display_name ?? 'N/A' }}"
                                            data-guard-name="{{ $role->guard_name }}"
                                            data-description="{{ $role->description ?? 'N/A' }}"
                                            data-scope="{{ $role->scope ? implode(', ', json_decode($role->scope)) : 'Semua' }}"
                                            title="Lihat Detail Peran">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('core.roles.edit', $role->id) }}" title="Edit Peran"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('core.roles.destroy', $role->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus peran ini? Ini juga akan melepaskan peran dari semua pengguna yang terhubung. Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus Peran"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada peran ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $roles->links() }}
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Peran</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola **peran (roles)** pengguna dalam sistem, yang menentukan grup hak akses mereka.</p>
                <p>Setiap peran memiliki nama unik, nama tampilan yang lebih mudah dibaca, dan dikaitkan dengan 'guard' tertentu (misal: 'web' untuk aplikasi web, 'api' untuk akses API).</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama Peran:</strong> Identifikasi unik peran (misal: `admin`, `guru`, `siswa`).</li>
                    <li><strong class="font-semibold">Nama Tampilan:</strong> Nama yang lebih mudah dibaca di UI (misal: `Administrator Sistem`).</li>
                    <li><strong class="font-semibold">Guard:</strong> Sistem autentikasi yang digunakan peran ini (web atau api).</li>
                    <li><strong class="font-semibold">Deskripsi:</strong> Penjelasan singkat tentang tanggung jawab peran.</li>
                    <li><strong class="font-semibold">Lingkup (Scope):</strong> Batasan opsional peran ke unit tertentu (misal: hanya berlaku untuk SMP).</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Peran → Izin (Permissions):** Peran akan memiliki kumpulan izin yang ditugaskan.</li>
                    <li>**Peran → Pengguna (Users):** Setiap pengguna dapat ditugaskan satu atau lebih peran.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Manajemen peran yang tepat adalah dasar dari sistem keamanan yang kuat dan terorganisir.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Peran --}}
    <div id="roleDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Peran: <span id="detailRoleName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Peran:</strong> <span id="detailName"></span></p>
                <p><strong>Nama Tampilan:</strong> <span id="detailDisplayName"></span></p>
                <p><strong>Guard:</strong> <span id="detailGuardName"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detailDescription"></span></p>
                <p><strong>Lingkup (Scope):</strong> <span id="detailScope"></span></p>
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

        // --- Modal Detail Peran ---
        const roleDetailModal = document.getElementById('roleDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailRoleName = document.getElementById('detailRoleName');
        const detailName = document.getElementById('detailName');
        const detailDisplayName = document.getElementById('detailDisplayName');
        const detailGuardName = document.getElementById('detailGuardName');
        const detailDescription = document.getElementById('detailDescription');
        const detailScope = document.getElementById('detailScope');
        const detailModalContent = roleDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailRoleName.textContent = this.dataset.name; // For modal title
                detailName.textContent = this.dataset.name;
                detailDisplayName.textContent = this.dataset.displayName;
                detailGuardName.textContent = this.dataset.guardName;
                detailDescription.textContent = this.dataset.description;
                detailScope.textContent = this.dataset.scope;

                openModal(roleDetailModal, detailModalContent);
            });
        });

        closeDetailModalBtn.addEventListener('click', () => closeModal(roleDetailModal, detailModalContent));
        roleDetailModal.addEventListener('click', function(event) {
            if (event.target === roleDetailModal) {
                closeModal(roleDetailModal, detailModalContent);
            }
        });
    });
</script>
@endpush