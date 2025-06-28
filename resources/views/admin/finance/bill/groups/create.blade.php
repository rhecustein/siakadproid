@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">Tambah Grup Tagihan</h1>
        <a href="{{ route('finance.bill-groups.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar Grup
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('finance.bill-groups.store') }}" method="POST" class="bg-white shadow rounded p-6 space-y-5">
        @csrf

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Jenis Tagihan --}}
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Tagihan</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Jenis Tagihan --</option>

                <optgroup label="Tagihan Rutin / Periode">
                    <option value="spp" {{ old('type') == 'spp' ? 'selected' : '' }}>SPP Sekolah</option>
                    <option value="pondokan" {{ old('type') == 'pondokan' ? 'selected' : '' }}>Biaya Pondokan</option>
                    <option value="makan" {{ old('type') == 'makan' ? 'selected' : '' }}>Konsumsi Harian</option>
                    <option value="asrama" {{ old('type') == 'asrama' ? 'selected' : '' }}>Asrama / Penginapan</option>
                    <option value="infaq_rutin" {{ old('type') == 'infaq_rutin' ? 'selected' : '' }}>Infaq Rutin</option>
                    <option value="laundry" {{ old('type') == 'laundry' ? 'selected' : '' }}>Laundry Santri</option>
                </optgroup>

                <optgroup label="Tagihan Event / Sekali">
                    <option value="daftar_ulang" {{ old('type') == 'daftar_ulang' ? 'selected' : '' }}>Daftar Ulang Tahunan</option>
                    <option value="ujian" {{ old('type') == 'ujian' ? 'selected' : '' }}>Ujian Tengah/Akhir</option>
                    <option value="ekskul" {{ old('type') == 'ekskul' ? 'selected' : '' }}>Ekstrakurikuler</option>
                    <option value="study_tour" {{ old('type') == 'study_tour' ? 'selected' : '' }}>Study Tour</option>
                    <option value="pakaian" {{ old('type') == 'pakaian' ? 'selected' : '' }}>Seragam / Jas</option>
                    <option value="buku" {{ old('type') == 'buku' ? 'selected' : '' }}>Buku / Kitab</option>
                    <option value="kegiatan" {{ old('type') == 'kegiatan' ? 'selected' : '' }}>Kegiatan Lainnya</option>
                </optgroup>

                <optgroup label="Khusus Pesantren / Opsional">
                    <option value="tahfidz" {{ old('type') == 'tahfidz' ? 'selected' : '' }}>Program Tahfidz</option>
                    <option value="pembangunan" {{ old('type') == 'pembangunan' ? 'selected' : '' }}>Donasi Pembangunan</option>
                    <option value="kesehatan" {{ old('type') == 'kesehatan' ? 'selected' : '' }}>Kesehatan / Klinik</option>
                    <option value="perpustakaan" {{ old('type') == 'perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                    <option value="akomodasi" {{ old('type') == 'akomodasi' ? 'selected' : '' }}>Akomodasi Santri</option>
                </optgroup>

                <optgroup label="Lainnya">
                    <option value="infaq_sukarela" {{ old('type') == 'infaq_sukarela' ? 'selected' : '' }}>Infaq Sukarela</option>
                    <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </optgroup>
            </select>

            </div>

            {{-- Nama Tagihan --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nama Tagihan</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            {{-- Sekolah --}}
            <div>
                <label class="block text-sm font-medium mb-1">Sekolah</label>
                <select name="school_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Level --}}
            <div>
                <label class="block text-sm font-medium mb-1">Kelas / Level</label>
                <select name="level_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Level --</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun Ajaran --}}
           <div>
            <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
            <select name="academic_year" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                @foreach([
                    '2024-2025',
                    '2025-2026',
                    '2026-2027',
                    '2027-2028',
                    '2028-2029',
                    '2029-2030'
                ] as $year)
                    <option value="{{ $year }}" {{ old('academic_year', $billGroup->academic_year ?? '') === $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        </div>

        <div class="grid md:grid-cols-3 gap-4">
            {{-- Gender --}}
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">-- Semua --</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Jumlah Tagihan --}}
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Tagihan</label>
                <input type="number" name="tagihan_count" class="w-full border rounded px-3 py-2"
                       value="{{ old('tagihan_count') }}" placeholder="cth: 120 (bulan)">
            </div>

            {{-- Nominal --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nominal per Tagihan (Rp)</label>
                <input type="number" name="amount_per_tagihan" class="w-full border rounded px-3 py-2"
                       value="{{ old('amount_per_tagihan') }}" step="1000">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Tanggal Mulai --}}
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border rounded px-3 py-2"
                       value="{{ old('start_date') }}">
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border rounded px-3 py-2"
                       value="{{ old('end_date') }}">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="text-right pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
