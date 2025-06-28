@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Penugasan Wali Kelas
            </h1>
            <p class="text-gray-600 text-base">Daftar wali kelas yang sudah ditetapkan per tahun ajaran dan kelas.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Daftar Guru --}}
            <a href="{{ route('academic.teachers.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold shadow-md hover:bg-gray-300 transition-colors duration-200 min-w-max">
                <i class="fas fa-users mr-2"></i> Daftar Guru
            </a>
            {{-- Tombol Tetapkan Wali Kelas --}}
            <a href="{{ route('academic.homeroom.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tetapkan Wali Kelas
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

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tahun Ajaran</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kelas</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Wali Kelas</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Ditugaskan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($assignments as $index => $assignment)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td> {{-- Changed to $loop->iteration for simpler numbering --}}
                            <td class="px-6 py-4">{{ $assignment->academicYear->year ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $assignment->classroom->name ?? '—' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $assignment->teacher->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                {{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->translatedFormat('d M Y') : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($assignment->is_active)
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
                                            data-assignment-id="{{ $assignment->id }}"
                                            data-academic-year="{{ $assignment->academicYear->year ?? 'N/A' }}"
                                            data-classroom-name="{{ $assignment->classroom->name ?? 'N/A' }}"
                                            data-teacher-name="{{ $assignment->teacher->name ?? 'N/A' }}"
                                            data-assigned-at="{{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->translatedFormat('d M Y H:i') : 'N/A' }}"
                                            data-is-active="{{ $assignment->is_active ? 'Aktif' : 'Nonaktif' }}"
                                            title="Lihat Detail Penugasan">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>

                                    <a href="{{ route('academic.homeroom.edit', $assignment->id) }}" title="Edit Penugasan"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('academic.homeroom.destroy', $assignment->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus penugasan wali kelas ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Penugasan"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data wali kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination (assuming $assignments is paginated) --}}
        @if($assignments->hasPages())
        <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600 p-6">
            <p>
                Menampilkan <span class="font-semibold">{{ $assignments->firstItem() }}</span> – <span class="font-semibold">{{ $assignments->lastItem() }}</span> dari total <span class="font-semibold">{{ $assignments->total() }}</span> penugasan
            </p>
            <div>
                {{ $assignments->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
        @endif
    </div>

    {{-- Modal Pop-up Informasi Umum Menu --}}
    <div id="menuInfoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Penugasan Wali Kelas</h3>
                <button type="button" id="closeMenuInfoModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk menetapkan **guru** sebagai **wali kelas** untuk setiap kelas di setiap tahun ajaran.</p>
                <p>Setiap kelas hanya dapat memiliki satu wali kelas aktif per tahun ajaran.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Tahun Ajaran:</strong> Tahun akademik penugasan wali kelas (misalnya: 2024/2025).</li>
                    <li><strong class="font-semibold">Kelas:</strong> Kelas yang ditugaskan kepada wali kelas.</li>
                    <li><strong class="font-semibold">Wali Kelas:</strong> Nama guru yang ditugaskan sebagai wali kelas.</li>
                    <li><strong class="font-semibold">Ditugaskan:</strong> Tanggal dan waktu penugasan dilakukan.</li>
                    <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah penugasan ini aktif atau nonaktif.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Penugasan Wali Kelas → Tahun Ajaran:** Terhubung dengan tahun akademik tertentu.</li>
                    <li>**Penugasan Wali Kelas → Kelas:** Terhubung dengan kelas tertentu.</li>
                    <li>**Penugasan Wali Kelas → Guru:** Terhubung dengan guru yang ditugaskan.</li>
                    <li>**Penugasan Wali Kelas → Siswa:** Memungkinkan wali kelas untuk mengelola siswa di kelas tersebut.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Pastikan penugasan wali kelas selalu akurat dan terbaru untuk mendukung peran guru dalam pembinaan siswa.</p>
            </div>
        </div>
    </div>

    {{-- Modal Pop-up Detail Penugasan Wali Kelas --}}
    <div id="assignmentDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="detailModalTitle">Detail Penugasan Wali Kelas</h3>
                <button type="button" id="closeDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-3">
                <p><strong>Tahun Ajaran:</strong> <span id="detailAcademicYear"></span></p>
                <p><strong>Kelas:</strong> <span id="detailClassroomName"></span></p>
                <p><strong>Wali Kelas:</strong> <span id="detailTeacherName"></span></p>
                <p><strong>Ditugaskan Pada:</strong> <span id="detailAssignedAt"></span></p>
                <p><strong>Status Penugasan:</strong> <span id="detailIsActive"></span></p>
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

        // --- Modal Detail Penugasan Wali Kelas ---
        const assignmentDetailModal = document.getElementById('assignmentDetailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModal');
        const detailAcademicYear = document.getElementById('detailAcademicYear');
        const detailClassroomName = document.getElementById('detailClassroomName');
        const detailTeacherName = document.getElementById('detailTeacherName');
        const detailAssignedAt = document.getElementById('detailAssignedAt');
        const detailIsActive = document.getElementById('detailIsActive');
        const detailModalContent = assignmentDetailModal.querySelector('.transform');

        document.querySelectorAll('.view-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Populate modal with data from data- attributes
                detailAcademicYear.textContent = this.dataset.academicYear;
                detailClassroomName.textContent = this.dataset.classroomName;
                detailTeacherName.textContent = this.dataset.teacherName;
                detailAssignedAt.textContent = this.dataset.assignedAt;
                detailIsActive.textContent = this.dataset.isActive;

                assignmentDetailModal.classList.remove('hidden');
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
                assignmentDetailModal.classList.add('hidden');
            }, 300);
        });

        assignmentDetailModal.addEventListener('click', function(event) {
            if (event.target === assignmentDetailModal) {
                detailModalContent.classList.remove('scale-100', 'opacity-100');
                detailModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    assignmentDetailModal.classList.add('hidden');
                }, 300);
            }
        });
    });
</script>
@endpush