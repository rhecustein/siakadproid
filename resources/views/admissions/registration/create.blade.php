@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow space-y-6">
    <h1 class="text-2xl font-bold mb-4">Formulir Pendaftaran Siswa Baru</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admission.admissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Informasi Umum -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Informasi Umum</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="registration_number" placeholder="registration_number" class="border rounded px-3 py-2 w-full" required>
                <input type="text" name="full_name" placeholder="Nama Lengkap" class="border rounded px-3 py-2 w-full" required>
                <input type="text" name="birth_place" placeholder="Tempat Lahir" class="border rounded px-3 py-2 w-full">
                <input type="date" name="birth_date" class="border rounded px-3 py-2 w-full" required>
                <select name="gender" class="border rounded px-3 py-2 w-full">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </div>

        <!-- Kontak -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Kontak</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" name="email" placeholder="Email" class="border rounded px-3 py-2 w-full">
                <input type="text" name="phone" placeholder="Nomor HP (WA)" class="border rounded px-3 py-2 w-full" required>
            </div>
            <textarea name="address" rows="3" placeholder="Alamat Lengkap" class="w-full border rounded px-3 py-2 mt-2"></textarea>
        </div>

        <!-- Pendidikan -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Pendidikan Sebelumnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="previous_school" placeholder="Asal Sekolah" class="border rounded px-3 py-2 w-full">
                <select name="last_grade" class="border rounded px-3 py-2 w-full">
                    <option value="">Jenjang Terakhir</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                </select>
            </div>
        </div>

        <!-- Orang Tua -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Data Orang Tua / Wali</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="father_name" placeholder="Nama Ayah" class="border rounded px-3 py-2 w-full">
                <input type="text" name="mother_name" placeholder="Nama Ibu" class="border rounded px-3 py-2 w-full">
                <input type="text" name="father_job" placeholder="Pekerjaan Ayah" class="border rounded px-3 py-2 w-full">
                <input type="text" name="mother_job" placeholder="Pekerjaan Ibu" class="border rounded px-3 py-2 w-full">
                <input type="text" name="guardian_phone" placeholder="Kontak Darurat" class="border rounded px-3 py-2 w-full">
            </div>
        </div>

        <!-- Upload Berkas -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Upload Berkas</h2>
            <input type="file" name="files[]" class="w-full border rounded px-3 py-2" multiple>
            <p class="text-sm text-gray-500 mt-1">Berkas yang disarankan: KK, Akta, Foto (max 2MB)</p>
        </div>

        <!-- Tambahan -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Keterangan Tambahan</h2>
            <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2" placeholder="Catatan kesehatan, kebutuhan khusus, dll"></textarea>
            <select name="entry_path" class="w-full border rounded px-3 py-2 mt-2">
                <option value="">Pilih Jalur Masuk</option>
                <option value="Umum">Umum</option>
                <option value="Prestasi">Prestasi</option>
                <option value="Tahfidz">Tahfidz</option>
            </select>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Simpan Pendaftaran
            </button>
        </div>
    </form>
</div>
@endsection
