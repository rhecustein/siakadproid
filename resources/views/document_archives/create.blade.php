@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">📤 Tambah Arsip Dokumen</h2>
            <a href="{{ route('facility.document-archives.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        {{-- Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('facility.document-archives.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="mt-1 w-full border rounded-md p-2 @error('title') border-red-500 @enderror"
                       required placeholder="Contoh: SK Kenaikan Jabatan">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="category" value="{{ old('category') }}"
                       class="mt-1 w-full border rounded-md p-2 @error('category') border-red-500 @enderror"
                       placeholder="Contoh: Surat Izin, Raport, SK">
                @error('category')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" rows="4"
                          class="mt-1 w-full border rounded-md p-2 @error('description') border-red-500 @enderror"
                          placeholder="Tuliskan keterangan atau detail singkat...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Arsip</label>
                <input type="date" name="archived_at" value="{{ old('archived_at', date('Y-m-d')) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('archived_at') border-red-500 @enderror" required>
                @error('archived_at')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Upload File</label>
                <input type="file" name="file"
                       class="mt-1 w-full border rounded-md p-2 file:mr-4 file:py-1 file:px-3 file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 @error('file') border-red-500 @enderror"
                       required>
                @error('file')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Simpan Arsip
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
