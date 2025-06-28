@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <div class="mb-8 flex items-center justify-between"> {{-- Changed to flex for title and info button --}}
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                Tambah Sekolah Baru
            </h1>
            {{-- Tombol Informasi Lengkap --}}
            <button type="button" id="infoButton" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>
        </div>
        <p class="text-gray-600 text-base text-center -mt-6 mb-8">Lengkapi semua informasi yang diperlukan untuk menambahkan data sekolah baru.</p>


        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
                <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <strong class="font-semibold">Terjadi beberapa kesalahan:</strong>
                    <ul class="list-disc ml-5 mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('shared.schools.store') }}">
            @csrf

            <div class="mb-5">
                <label for="branch_id" class="block text-sm font-semibold text-gray-700 mb-2">Cabang <span class="text-red-500">*</span></label>
                <select name="branch_id" id="branch_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm appearance-none bg-white pr-8"
                        required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branch_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       required placeholder="Contoh: SD Al-Bahjah 1, SMP Al-Bahjah 2">
                @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="npsn" class="block text-sm font-semibold text-gray-700 mb-2">NPSN</label>
                <input type="text" name="npsn" id="npsn" value="{{ old('npsn') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       placeholder="Nomor Pokok Sekolah Nasional (opsional)">
                @error('npsn') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Sekolah</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}"
                       placeholder="misal: Formal, Pondok, Diniyah, Tahfidz"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm">
                @error('type') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                <textarea name="address" id="address" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                          required placeholder="Alamat lengkap sekolah, termasuk nama jalan, kota, dan provinsi.">{{ old('address') }}</textarea>
                @error('address') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       placeholder="Contoh: 021-xxxx xxxx">
                @error('phone') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       placeholder="Email resmi sekolah">
                @error('email') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('shared.schools.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Sekolah
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-base font-semibold shadow-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-2-4l-4-4m0 0L8 7m4-4v3m0-3c1.333-1.333 3.333-1.333 4.667 0"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2"></path></svg>
                    Simpan Sekolah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Pop-up Informasi Lengkap (Modal) --}}
<div id="infoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Tambah Sekolah Baru</h3>
            <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-4">
            <p>Formulir ini digunakan untuk menambahkan data **sekolah** baru ke dalam sistem SIAKAD Al-Bahjah.</p>
            <p>Setiap sekolah akan terkait dengan sebuah cabang induk dan menjadi unit pendidikan utama yang memiliki siswa, guru, kelas, dan kurikulumnya sendiri.</p>

            <h4 class="font-bold text-gray-800">Detail Kolom:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li><strong class="font-semibold">Cabang:</strong> Pilih cabang induk tempat sekolah ini bernaung. Ini adalah kolom wajib.</li>
                <li><strong class="font-semibold">Nama Sekolah:</strong> Nama resmi sekolah (misalnya: SD Al-Bahjah 1, SMP Al-Bahjah 2). Ini adalah kolom wajib dan harus unik.</li>
                <li><strong class="font-semibold">NPSN:</strong> Nomor Pokok Sekolah Nasional (opsional).</li>
                <li><strong class="font-semibold">Jenis Sekolah:</strong> Tipe sekolah (misalnya: Formal, Pondok, Diniyah, Tahfidz).</li>
                <li><strong class="font-semibold">Alamat:</strong> Alamat lengkap sekolah. Ini adalah kolom wajib.</li>
                <li><strong class="font-semibold">No. Telepon:</strong> Nomor telepon kontak sekolah.</li>
                <li><strong class="font-semibold">Email:</strong> Alamat email resmi sekolah.</li>
            </ul>

            <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li>**Sekolah → Ruangan:** Setiap ruangan fisik yang terdaftar nantinya akan terkait dengan sekolah ini.</li>
                <li>**Sekolah → Kelas:** Kelas-kelas (grade levels) akan dibuat dan diasosiasikan dengan sekolah ini.</li>
                <li>**Sekolah → Guru & Siswa:** Data guru dan siswa akan terkait langsung dengan sekolah tempat mereka mengajar atau belajar.</li>
                <li>**Manajemen Terpusat:** Data sekolah adalah inti dari pengelolaan akademik dan operasional di tingkat unit pendidikan.</li>
            </ul>

            <p class="mt-4 text-sm italic text-gray-600">Pastikan semua informasi dimasukkan dengan akurat untuk integritas data sistem.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const infoButton = document.getElementById('infoButton');
        const infoModal = document.getElementById('infoModal');
        const closeModal = document.getElementById('closeModal');
        const modalContent = infoModal.querySelector('div'); // The inner div with content

        // Function to show modal with animation
        function showModal() {
            infoModal.classList.remove('hidden');
            setTimeout(() => {
                infoModal.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10); // Small delay to allow 'hidden' class removal before transition
        }

        // Function to hide modal with animation
        function hideModal() {
            infoModal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                infoModal.classList.add('hidden');
            }, 300); // Wait for transition to finish before hiding
        }

        infoButton.addEventListener('click', showModal);
        closeModal.addEventListener('click', hideModal);

        // Hide modal when clicking outside of the content
        infoModal.addEventListener('click', function(event) {
            if (event.target === infoModal) { // Check if the click was directly on the overlay
                hideModal();
            }
        });
    });
</script>
@endsection