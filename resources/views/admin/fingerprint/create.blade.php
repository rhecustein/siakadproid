@extends('layouts.app')

@section('content')
<style>
    @keyframes pulse-scan {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }

    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>

<div class="max-w-5xl mx-auto p-6">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('core.users.index') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:underline hover:text-blue-800 transition">
            ← Kembali ke daftar pengguna
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col md:flex-row animate-fade-in">
        
        <!-- Ilustrasi Fingerprint -->
        <div class="md:w-1/2 bg-blue-50 flex flex-col items-center justify-center py-10 relative border-r">
            <div id="fingerAnimation" class="transition-all">
                <img src="{{ asset('images/finger.png') }}" 
                     alt="Fingerprint Scanner" 
                     class="w-56 h-auto drop-shadow-md duration-300" />
            </div>
            <button id="scanFingerprintBtn"
                class="mt-6 px-6 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition shadow-lg">
                Scan Sidik Jari
            </button>
            <p class="mt-3 text-sm text-gray-600 text-center px-4">Gunakan alat ZK9500. Data akan otomatis masuk ke form setelah berhasil dipindai.</p>

            <!-- Notifikasi -->
            <div id="scanNotice" class="hidden mt-4 px-4 py-2 rounded bg-green-100 text-green-800 text-sm font-medium animate-fade-in shadow">
                ✅ Sidik jari berhasil dipindai!
            </div>
        </div>

        <!-- Form Input & Info User -->
        <div class="md:w-1/2 p-8">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Sidik Jari</h2>
            
            <div class="mb-4">
                <label class="text-sm text-gray-600">Nama</label>
                <p class="font-medium text-gray-900">{{ $user->name }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-600">Email</label>
                <p class="font-medium text-gray-900">{{ $user->email }}</p>
            </div>

            <form action="{{ route('core.fingerprint.store', $user->id) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="finger_position" class="block text-sm font-medium text-gray-700">Posisi Jari</label>
                    <select name="finger_position" id="finger_position" class="mt-1 w-full border rounded-md p-2 focus:ring focus:ring-blue-200">
                        <option value="right_thumb">Jempol Kanan</option>
                        <option value="right_index">Telunjuk Kanan</option>
                        <option value="left_thumb">Jempol Kiri</option>
                        <option value="left_index">Telunjuk Kiri</option>
                    </select>
                </div>

                <div>
                    <label for="device_type" class="block text-sm font-medium text-gray-700">Tipe Perangkat</label>
                    <select name="device_type" id="device_type" class="mt-1 w-full border rounded-md p-2 focus:ring focus:ring-blue-200">
                        <option value="absensi">Absensi</option>
                        <option value="kantin">Kantin</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <input type="hidden" name="template_data" id="template_data">

                <button type="submit"
                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition shadow-md">
                    Simpan Sidik Jari
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Simulasi JavaScript scan sidik jari --}}
<script>
    const scanBtn = document.getElementById('scanFingerprintBtn');
    const templateInput = document.getElementById('template_data');
    const scanNotice = document.getElementById('scanNotice');
    const img = document.getElementById('fingerAnimation');

    scanBtn.addEventListener('click', () => {
        // Scan animasi
        img.classList.add('animate-pulse');
        img.style.animation = 'pulse-scan 1.2s ease-in-out 1';

        // Simulasi hasil dari alat ZK9500
        setTimeout(() => {
            templateInput.value = 'sample_template_base64_or_hex';
            img.style.animation = '';

            scanNotice.classList.remove('hidden');
            scanNotice.classList.add('flex');
        }, 1000);
    });
</script>
@endsection
