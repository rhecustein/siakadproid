@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Guru & Wali Kelas
            </h1>
            <p class="text-gray-600 text-base">Kelola informasi semua guru dan penugasan wali kelas dalam sistem.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Guru --}}
            <a href="{{ route('academic.teachers.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Guru
            </a>
            {{-- Tombol Wali Kelas (Contoh) --}}
            <a href="{{ route('academic.homeroom.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200 min-w-max">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Wali Kelas
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
        {{-- Card Total Guru --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Guru</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTeachers }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-chalkboard-teacher fa-lg"></i>
            </div>
        </div>

        {{-- Card Guru Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Guru Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeTeachers }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Wali Kelas Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Wali Kelas Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeHomeroomTeachers }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-users fa-lg"></i>
            </div>
        </div>

        {{-- Card Total Sekolah --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Sekolah</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalSchools }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <i class="fas fa-school fa-lg"></i>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('academic.teachers.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, NIP, atau email..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="gender" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <select name="status" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            {{-- Asumsi $schools dilewatkan dari controller --}}
            <select name="school_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Sekolah</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('academic.teachers.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">NIP</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Jenis Kelamin</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Sekolah</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Jabatan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Wali Kelas</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($teachers as $index => $teacher)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $teachers->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $teacher->name }}</td>
                            <td class="px-6 py-4">{{ $teacher->nip ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-6 py-4">{{ $teacher->email ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $teacher->school->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $teacher->position ?? '—' }}</td>
                            <td class="px-6 py-4">
                                {{-- Menggunakan relasi currentHomeroomAssignment --}}
                                @if ($teacher->currentHomeroomAssignment)
                                    {{ $teacher->currentHomeroomAssignment->classroom->name ?? '—' }}
                                    <span class="text-xs text-gray-500">({{ $teacher->currentHomeroomAssignment->academicYear->year ?? 'N/A' }})</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($teacher->is_active)
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
                                            data-teacher-id="{{ $teacher->id }}"
                                            data-teacher-name="{{ $teacher->name }}"
                                            data-teacher-nip="{{ $teacher->nip ?? 'N/A' }}"
                                            data-teacher-gender="{{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                            data-teacher-email="{{ $teacher->email ?? 'N/A' }}"
                                            data-teacher-school="{{ $teacher->school->name ?? 'N/A' }}"
                                            data-teacher-position="{{ $teacher->position ?? 'N/A' }}"
                                            data-teacher-employment-status="{{ $teacher->employment_status ?? 'N/A' }}"
                                            data-teacher-type="{{ $teacher->type ?? 'N/A' }}"
                                            data-teacher-homeroom="{{ $teacher->currentHomeroomAssignment->classroom->name ?? 'Tidak Ditugaskan' }}"
                                            data-teacher-homeroom-year="{{ $teacher->currentHomeroomAssignment->academicYear->year ?? 'N/A' }}"
                                            data-teacher-status="{{ $teacher->is_active ? 'Aktif' : 'Nonaktif' }}"
                                            title="Lihat Detail Guru">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('academic.teachers.edit', $teacher->id) }}" title="Edit Guru"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('academic.teachers.destroy', $teacher->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data guru ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Guru"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-gray-500">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination (assuming $teachers is paginated) --}}
        <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600 p-6">
            <p>
                Menampilkan <span class="font-semibold">{{ $teachers->firstItem() }}</span> – <span class="font-semibold">{{ $teachers->lastItem() }}</span> dari total <span class="font-semibold">{{ $teachers->total() }}</span> guru
            </p>
            <div>
                {{ $teachers->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Guru & Wali Kelas</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola daftar **guru** yang mengajar di setiap sekolah, serta menugaskan mereka sebagai **wali kelas**.</p>
                <p>Pastikan data guru lengkap dan penugasan wali kelas akurat untuk mendukung administrasi akademik.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama lengkap guru.</li>
                    <li><strong class="font-semibold">NIP:</strong> Nomor Induk Pegawai guru.</li>
                    <li><strong class="font-semibold">Jenis Kelamin:</strong> Jenis kelamin guru.</li>
                    <li><strong class="font-semibold">Email:</strong> Alamat email guru untuk komunikasi.</li>
                    <li><strong class="font-semibold">Sekolah:</strong> Sekolah tempat guru mengajar.</li>
                    <li><strong class="font-semibold">Jabatan:</strong> Jabatan fungsional atau struktural guru.</li>
                    <li><strong class="font-semibold">Wali Kelas:</strong> Menunjukkan kelas yang diampu sebagai wali kelas (jika ada).</li>
                    <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah akun guru aktif atau nonaktif dalam sistem.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Guru → Sekolah:** Setiap guru terhubung dengan satu sekolah.</li>
                    <li>**Guru → Wali Kelas:** Guru dapat ditugaskan sebagai wali kelas untuk satu kelas.</li>
                    <li>**Guru → Mata Pelajaran:** Guru akan mengampu mata pelajaran tertentu.</li>
                    <li>**Guru → Absensi & Penilaian:** Data absensi dan nilai siswa akan terkait dengan guru yang mengajar.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Pastikan semua data guru akurat dan penugasan wali kelas sesuai untuk kelancaran operasional sekolah.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Guru --}}
    <div id="teacherDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="detailModalTitle">Detail Guru: <span id="detailTeacherName"></span></h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Nama Lengkap:</strong> <span id="detailName"></span></p>
                <p><strong>NIP:</strong> <span id="detailNip"></span></p>
                <p><strong>Jenis Kelamin:</strong> <span id="detailGender"></span></p>
                <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                <p><strong>Sekolah:</strong> <span id="detailSchool"></span></p>
                <p><strong>Jabatan:</strong> <span id="detailPosition"></span></p>
                <p><strong>Status Kepegawaian:</strong> <span id="detailEmploymentStatus"></span></p>
                <p><strong>Jenis Guru:</strong> <span id="detailType"></span></p>
                <p><strong>Wali Kelas Aktif:</strong> <span id="detailHomeroom"></span></p>
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

        // --- Modal Detail Guru ---
        const teacherDetailModal = document.getElementById('teacherDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailModalTitle = document.getElementById('detailModalTitle');
        const detailTeacherName = document.getElementById('detailTeacherName');
        const detailName = document.getElementById('detailName');
        const detailNip = document.getElementById('detailNip');
        const detailGender = document.getElementById('detailGender');
        const detailEmail = document.getElementById('detailEmail');
        const detailSchool = document.getElementById('detailSchool');
        const detailPosition = document.getElementById('detailPosition');
        const detailEmploymentStatus = document.getElementById('detailEmploymentStatus');
        const detailType = document.getElementById('detailType');
        const detailHomeroom = document.getElementById('detailHomeroom');
        const detailStatus = document.getElementById('detailStatus');
        const detailModalContent = teacherDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data- attributes
                detailTeacherName.textContent = this.dataset.teacherName;
                detailName.textContent = this.dataset.teacherName;
                detailNip.textContent = this.dataset.teacherNip;
                detailGender.textContent = this.dataset.teacherGender;
                detailEmail.textContent = this.dataset.teacherEmail;
                detailSchool.textContent = this.dataset.teacherSchool;
                detailPosition.textContent = this.dataset.teacherPosition;
                detailEmploymentStatus.textContent = this.dataset.teacherEmploymentStatus;
                detailType.textContent = this.dataset.teacherType;
                // Combine homeroom class and year if available
                const homeroomClass = this.dataset.teacherHomeroom;
                const homeroomYear = this.dataset.teacherHomeroomYear;
                if (homeroomClass && homeroomYear && homeroomClass !== 'Tidak Ditugaskan') {
                    detailHomeroom.textContent = `${homeroomClass} (${homeroomYear})`;
                } else {
                    detailHomeroom.textContent = homeroomClass; // Will be "Tidak Ditugaskan"
                }

                detailStatus.textContent = this.dataset.teacherStatus;


                teacherDetailModal.classList.remove('hidden');
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
                teacherDetailModal.classList.add('hidden');
            }, 300);
        });

        teacherDetailModal.addEventListener('click', function(event) {
            if (event.target === teacherDetailModal) {
                detailModalContent.classList.remove('scale-100', 'opacity-100');
                detailModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    teacherDetailModal.classList.add('hidden');
                }, 300);
            }
        });
    });
</script>
@endpush