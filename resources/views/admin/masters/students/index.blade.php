@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Siswa
            </h1>
            <p class="text-gray-600 text-base">Kelola semua informasi siswa yang terdaftar dalam sistem.</p>
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
            {{-- Tombol Tambah Siswa --}}
            <a href="{{ route('master.students.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Siswa
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
        {{-- Card Total Siswa --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-user-graduate fa-lg"></i>
            </div>
        </div>

        {{-- Card Siswa Aktif --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Siswa Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeStudents }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
        </div>

        {{-- Card Siswa Laki-laki --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Siswa Laki-laki</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maleStudents }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <i class="fas fa-male fa-lg"></i>
            </div>
        </div>

        {{-- Card Siswa Perempuan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Siswa Perempuan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $femaleStudents }}</p>
            </div>
            <div class="p-3 bg-pink-100 rounded-full text-pink-600">
                <i class="fas fa-female fa-lg"></i>
            </div>
        </div>
    </div>


    <form method="GET" action="{{ route('master.students.index') }}" class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded-xl shadow">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4">

        {{-- Asumsi $grades dilewatkan dari controller --}}
        <select name="grade_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Kelas</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>

        <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Jenis Kelamin</option>
            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
            <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option> {{-- Assuming 'lulus' is also a possible status --}}
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
                    <th class="px-4 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">NIS</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">NISN</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Nama</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Sekolah</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Kelas</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Orang Tua</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Gender</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Masuk</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($students as $index => $student)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-4 py-2">{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $student->nis ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $student->nisn ?? '—' }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-800">{{ $student->name }}</td>
                        <td class="px-4 py-2">{{ $student->school->name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $student->currentClassroom->name ?? '—' }}</td> {{-- Changed to currentClassroom --}}
                        <td class="px-4 py-2">{{ $student->parent->name ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @if($student->gender === 'L') Laki-laki
                            @elseif($student->gender === 'P') Perempuan
                            @else -
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($student->admission_date)->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @if ($student->student_status === 'aktif')
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">
                                    {{ ucfirst($student->student_status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center whitespace-nowrap">
                            <div class="inline-flex space-x-2">
                                {{-- Tombol Lihat Detail --}}
                                <button type="button"
                                        class="p-2 text-xs font-semibold text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-150 flex items-center justify-center view-detail-btn"
                                        data-student-id="{{ $student->id }}"
                                        data-student-name="{{ $student->name }}"
                                        data-student-nis="{{ $student->nis ?? 'N/A' }}"
                                        data-student-nisn="{{ $student->nisn ?? 'N/A' }}"
                                        data-student-school="{{ $student->school->name ?? 'N/A' }}"
                                        data-student-class="{{ $student->currentClassroom->name ?? 'N/A' }}" {{-- Changed to currentClassroom --}}
                                        data-student-parent-name="{{ $student->parent->name ?? 'N/A' }}"
                                        data-student-gender="{{ $student->gender === 'L' ? 'Laki-laki' : ($student->gender === 'P' ? 'Perempuan' : '—') }}"
                                        data-student-admission-date="{{ \Carbon\Carbon::parse($student->admission_date)->translatedFormat('d M Y') ?? 'N/A' }}"
                                        data-student-birth-date="{{ \Carbon\Carbon::parse($student->date_of_birth)->translatedFormat('d M Y') ?? 'N/A' }}"
                                        data-student-birth-place="{{ $student->place_of_birth ?? 'N/A' }}"
                                        data-student-address="{{ $student->address ?? 'N/A' }}"
                                        data-student-phone="{{ $student->phone_number ?? 'N/A' }}"
                                        data-student-status="{{ ucfirst($student->student_status) }}"
                                        title="Lihat Detail Siswa">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </button>

                                <a href="{{ route('master.students.edit', $student->id) }}" title="Edit Siswa"
                                   class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('master.students.destroy', $student->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Siswa"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-4 text-center text-gray-500">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $students->withQueryString()->links() }}
    </div>
</div>

{{-- Modal Pop-up Informasi Umum Menu --}}
<div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Siswa</h3>
            <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-4">
            <p>Menu ini digunakan untuk mengelola data lengkap **siswa** yang terdaftar di sekolah, termasuk informasi pribadi, riwayat akademik, dan status.</p>

            <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li><strong class="font-semibold">NIS / NISN:</strong> Nomor Induk Siswa / Nasional.</li>
                <li><strong class="font-semibold">Nama:</strong> Nama lengkap siswa.</li>
                <li><strong class="font-semibold">Sekolah:</strong> Sekolah tempat siswa terdaftar.</li>
                <li><strong class="font-semibold">Kelas:</strong> Kelas siswa saat ini.</li>
                <li><strong class="font-semibold">Orang Tua:</strong> Nama orang tua atau wali yang terdaftar.</li>
                <li><strong class="font-semibold">Gender:</strong> Jenis kelamin siswa.</li>
                <li><strong class="font-semibold">Masuk:</strong> Tanggal pertama kali siswa terdaftar di sekolah.</li>
                <li><strong class="font-semibold">Status:</strong> Status siswa (Aktif, Nonaktif, Alumni, Lulus).</li>
            </ul>

            <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li>**Siswa → Sekolah:** Setiap siswa terdaftar di satu sekolah.</li>
                <li>**Siswa → Kelas:** Siswa terdaftar di kelas tertentu per tahun ajaran.</li>
                <li>**Siswa → Orang Tua/Wali:** Setiap siswa terhubung dengan data orang tua/wali.</li>
                <li>**Siswa → Nilai & Absensi:** Data nilai dan absensi terkait langsung dengan siswa.</li>
                <li>**Siswa → Pembayaran:** Riwayat pembayaran terkait dengan siswa.</li>
            </ul>

            <p class="mt-4 text-sm italic text-gray-600">Pastikan semua data siswa akurat dan terbaru untuk kelancaran proses belajar mengajar dan administrasi.</p>
        </div>
    </div>
</div>

{{-- Modal Pop-up Detail Siswa --}}
<div id="studentDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800" id="detailModalTitle">Detail Siswa: <span id="detailStudentName"></span></h3>
            <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-3">
            <p><strong>Nama Lengkap:</strong> <span id="detailName"></span></p>
            <p><strong>NIS:</strong> <span id="detailNis"></span></p>
            <p><strong>NISN:</strong> <span id="detailNisn"></span></p>
            <p><strong>Sekolah:</strong> <span id="detailSchool"></span></p>
            <p><strong>Kelas Aktif:</strong> <span id="detailClass"></span></p>
            <p><strong>Orang Tua/Wali:</strong> <span id="detailParentName"></span></p>
            <p><strong>Jenis Kelamin:</strong> <span id="detailGender"></span></p>
            <p><strong>Tanggal Lahir:</strong> <span id="detailBirthDate"></span></p>
            <p><strong>Tempat Lahir:</strong> <span id="detailBirthPlace"></span></p>
            <p><strong>Alamat:</strong> <span id="detailAddress"></span></p>
            <p><strong>Nomor Telepon:</strong> <span id="detailPhone"></span></p>
            <p><strong>Tanggal Masuk:</strong> <span id="detailAdmissionDate"></span></p>
            <p><strong>Status Siswa:</strong> <span id="detailStatus"></span></p>
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

        // --- Modal Detail Siswa ---
        const studentDetailModal = document.getElementById('studentDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailStudentName = document.getElementById('detailStudentName');
        const detailNis = document.getElementById('detailNis');
        const detailNisn = document.getElementById('detailNisn');
        const detailName = document.getElementById('detailName');
        const detailSchool = document.getElementById('detailSchool');
        const detailClass = document.getElementById('detailClass');
        const detailParentName = document.getElementById('detailParentName');
        const detailGender = document.getElementById('detailGender');
        const detailAdmissionDate = document.getElementById('detailAdmissionDate');
        const detailStatus = document.getElementById('detailStatus');
        const detailBirthDate = document.getElementById('detailBirthDate');
        const detailBirthPlace = document.getElementById('detailBirthPlace');
        const detailAddress = document.getElementById('detailAddress');
        const detailPhone = document.getElementById('detailPhone');
        const detailModalContent = studentDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data-attributes
                detailStudentName.textContent = this.dataset.studentName;
                detailNis.textContent = this.dataset.studentNis;
                detailNisn.textContent = this.dataset.studentNisn;
                detailName.textContent = this.dataset.studentName;
                detailSchool.textContent = this.dataset.studentSchool;
                detailClass.textContent = this.dataset.studentClass;
                detailParentName.textContent = this.dataset.studentParentName;
                detailGender.textContent = this.dataset.studentGender;
                detailAdmissionDate.textContent = this.dataset.studentAdmissionDate;
                detailStatus.textContent = this.dataset.studentStatus;
                detailBirthDate.textContent = this.dataset.studentBirthDate;
                detailBirthPlace.textContent = this.dataset.studentBirthPlace;
                detailAddress.textContent = this.dataset.studentAddress;
                detailPhone.textContent = this.dataset.studentPhone;


                studentDetailModal.classList.remove('hidden');
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
                studentDetailModal.classList.add('hidden');
            }, 300);
        });

        studentDetailModal.addEventListener('click', function(event) {
            if (event.target === studentDetailModal) {
                detailModalContent.classList.remove('scale-100', 'opacity-100');
                detailModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    studentDetailModal.classList.add('hidden');
                }, 300);
            }
        });
    });
</script>
@endpush