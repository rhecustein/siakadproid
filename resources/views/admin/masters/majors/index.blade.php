@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">
                Daftar Jurusan
            </h1>
            <p class="text-gray-600 text-base">Semua jurusan yang terdaftar berdasarkan jenjang dan tipe.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Jurusan --}}
            <a href="{{ route('academic.majors.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 min-w-max">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Jurusan
            </a>
            {{-- Tombol Info (Membuka Modal) --}}
            <button type="button" id="openInfoModal" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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

    {{-- Filter Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('academic.majors.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, slug, atau kode..."
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

            <select name="type" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Tipe</option>
                <option value="umum" {{ request('type') == 'umum' ? 'selected' : '' }}>Umum</option>
                <option value="kejuruan" {{ request('type') == 'kejuruan' ? 'selected' : '' }}>Kejuruan</option>
            </select>

            <select name="status" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            <a href="{{ route('academic.majors.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center justify-center gap-1 min-w-[100px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
                Reset
            </a>
        </form>
    </div>

    {{-- Table of Majors --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Slug</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Kode</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Jenjang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Sekolah</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Tipe</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($majors as $index => $major)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4">{{ $majors->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $major->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $major->slug }}</td>
                            <td class="px-6 py-4">{{ $major->code ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $major->level->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $major->school->name ?? '—' }}</td>
                            <td class="px-6 py-4 capitalize">{{ $major->type }}</td>
                            <td class="px-6 py-4">
                                @if ($major->is_active)
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2">
                                    <a href="{{ route('academic.majors.edit', $major->id) }}" title="Edit Jurusan"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('academic.majors.destroy', $major->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus jurusan ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Jurusan"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">Belum ada data jurusan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination (assuming $majors is paginated) --}}
    <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
        <p>
            Menampilkan <span class="font-semibold">{{ $majors->firstItem() }}</span> – <span class="font-semibold">{{ $majors->lastItem() }}</span> dari total <span class="font-semibold">{{ $majors->total() }}</span> jurusan
        </p>
        <div>
            {{ $majors->appends(request()->query())->onEachSide(1)->links() }}
        </div>
    </div>

    {{-- Modal Pop-up Informasi --}}
    <div id="infoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Daftar Jurusan</h3>
                <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                    &times;
                </button>
            </div>

            <div class="text-gray-700 space-y-4">
                <p>Menu ini digunakan untuk mengelola daftar **jurusan** atau program studi yang tersedia di setiap jenjang pendidikan.</p>
                <p>Jurusan ini akan menjadi dasar saat membuat jadwal pelajaran dan mencatat nilai.</p>

                <h4 class="font-bold text-gray-800 mt-4">Detail Kolom Penting:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li><strong class="font-semibold">Nama:</strong> Nama jurusan (misalnya: IPA, IPS, Teknik Komputer).</li>
                    <li><strong class="font-semibold">Slug:</strong> Identifikasi jurusan yang ramah URL.</li>
                    <li><strong class="font-semibold">Kode:</strong> Kode unik jurusan (misalnya: IPA-SMA).</li>
                    <li><strong class="font-semibold">Jenjang:</strong> Jenjang pendidikan jurusan ini (misalnya: SMA).</li>
                    <li><strong class="font-semibold">Sekolah:</strong> Sekolah tempat jurusan ini tersedia.</li>
                    <li><strong class="font-semibold">Tipe:</strong> Kategori jurusan (Umum, Kejuruan).</li>
                    <li><strong class="font-semibold">Status:</strong> Menunjukkan apakah jurusan aktif atau nonaktif.</li>
                </ul>

                <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
                <ul class="list-disc list-inside text-sm space-y-2">
                    <li>**Jurusan → Jenjang/Sekolah:** Setiap jurusan terkait dengan struktur akademik yang relevan dan sekolah tempatnya berada.</li>
                    <li>**Jurusan → Siswa:** Siswa akan terdaftar di jurusan tertentu.</li>
                    <li>**Jurusan → Mata Pelajaran:** Mata pelajaran dapat terkait dengan jurusan tertentu.</li>
                </ul>

                <p class="mt-4 text-sm italic text-gray-600">Pastikan semua jurusan yang dibutuhkan telah terdaftar dengan benar agar data akademik siswa lengkap dan akurat.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const infoModal = document.getElementById('infoModal');
        const openModalBtn = document.getElementById('openInfoModal');
        const closeModalBtn = document.getElementById('closeModal');
        const modalContent = infoModal.querySelector('.transform');

        function openModal() {
            infoModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50); // Small delay for transition to work
        }

        function closeModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                infoModal.classList.add('hidden');
            }, 300); // Match transition duration
        }

        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside content
        infoModal.addEventListener('click', function(event) {
            if (event.target === infoModal) {
                closeModal();
            }
        });
    });
</script>
@endpush