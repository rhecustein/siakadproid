@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <div class="mb-8 flex items-center justify-between"> {{-- Changed to flex for title and info button --}}
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                Tambah Cabang Baru
            </h1>
            {{-- Tombol Informasi Lengkap --}}
            <button type="button" id="infoButton" class="p-3 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>
        </div>
        <p class="text-gray-600 text-base text-center -mt-6 mb-8">Silakan isi semua informasi yang diperlukan untuk menambahkan cabang baru ke sistem.</p> {{-- Adjusted margin-top --}}


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

        <form method="POST" action="{{ route('shared.branches.store') }}">
            @csrf

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Cabang <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                       required placeholder="Contoh: Cabang Pusat, Cabang Surabaya">
                @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                <textarea name="address" id="address" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none shadow-sm"
                          required placeholder="Alamat lengkap cabang, termasuk nama jalan, kota, dan provinsi.">{{ old('address') }}</textarea>
                @error('address') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('shared.branches.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Cabang
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-base font-semibold shadow-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-2-4l-4-4m0 0L8 7m4-4v3m0-3c1.333-1.333 3.333-1.333 4.667 0"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2"></path></svg>
                    Simpan Cabang
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Pop-up Informasi Lengkap (Modal) --}}
<div id="infoModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Informasi Menu: Tambah Cabang Baru</h3>
            <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-4">
            <p>Formulir ini digunakan untuk menambahkan data **cabang utama** baru ke dalam sistem SIAKAD Al-Bahjah. Setiap cabang akan menjadi unit organisasi terpisah yang dapat memiliki beberapa sekolah di bawahnya.</p>

            <h4 class="font-bold text-gray-800">Detail Kolom:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li><strong class="font-semibold">Nama Cabang:</strong> Nama resmi cabang (misalnya: Cabang Pusat, Cabang Surabaya, Cabang Malang). Ini adalah kolom wajib.</li>
                <li><strong class="font-semibold">Alamat:</strong> Alamat lengkap fisik dari cabang tersebut. Ini juga kolom wajib.</li>
            </ul>

            <h4 class="font-bold text-gray-800 mt-4">Hubungan & Relasi Data:</h4>
            <ul class="list-disc list-inside text-sm space-y-2">
                <li>**Cabang → Sekolah:** Setiap data sekolah yang Anda tambahkan nantinya akan terkait dengan salah satu cabang yang ada di sini.</li>
                <li>**Manajemen Terpusat:** Data cabang menjadi struktur hierarki tertinggi kedua (setelah Yayasan) dalam sistem SIAKAD, memungkinkan pengelolaan yang terpusat namun terstruktur berdasarkan lokasi/unit.</li>
                <li>**Pengguna:** Admin cabang atau pengguna terkait dapat memiliki akses dan hak kelola yang terbatas pada data di cabang masing-masing.</li>
            </ul>

            <p class="mt-4 text-sm italic text-gray-600">Pastikan informasi yang dimasukkan akurat untuk kelancaran pengelolaan data selanjutnya.</p>
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

        // Hide modal when clicking outside of the content (but not on the button itself)
        infoModal.addEventListener('click', function(event) {
            if (event.target === infoModal) { // Check if the click was directly on the overlay
                hideModal();
            }
        });
    });
</script>
@endsection