@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">✏️ Edit Arsip Dokumen</h2>
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

        <form method="POST" action="{{ route('facility.document-archives.update', $archive->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
                <input type="text" name="title" value="{{ old('title', $archive->title) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $archive->category) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('category') border-red-500 @enderror">
                @error('category')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="mt-1 w-full border rounded-md p-2 @error('description') border-red-500 @enderror"
                          placeholder="Opsional">{{ old('description', $archive->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Arsip</label>
                <input type="date" name="archived_at" value="{{ old('archived_at', \Carbon\Carbon::parse($archive->archived_at)->format('Y-m-d')) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('archived_at') border-red-500 @enderror"
                       required>
                @error('archived_at')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">File Saat Ini</label>
                <p class="mt-1 text-sm">
                    <a href="{{ asset('storage/' . $archive->file_path) }}" target="_blank"
                       class="text-blue-600 underline">📄 Lihat Dokumen</a>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Unggah File Baru (opsional)</label>
                <input type="file" name="file"
                       class="mt-1 w-full border rounded-md p-2 file:mr-4 file:py-1 file:px-3 file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 @error('file') border-red-500 @enderror">
                @error('file')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Perbarui Arsip
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
