@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold text-blue-700">📁 Arsip Dokumen</h1>
        <a href="{{ route('facility.document-archives.create') }}"
           class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 shadow">
            + Tambah Dokumen
        </a>
    </div>

    <!-- Tabel Arsip -->
    <div class="bg-white shadow-md rounded-xl overflow-x-auto border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Tanggal Arsip</th>
                    <th class="px-4 py-3 text-left">Diunggah Oleh</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($archives as $archive)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-800">
                            {{ $archive->title }}
                            @if($archive->description)
                                <div class="text-xs text-gray-500 mt-1 truncate">{{ $archive->description }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 capitalize">{{ $archive->category ?? '-' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($archive->archived_at)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $archive->uploader->name ?? '—' }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ asset('storage/' . $archive->file_path) }}" target="_blank"
                               class="text-sm text-blue-600 hover:underline">Lihat</a>
                            <a href="{{ route('facility.document-archives.download', $archive->id) }}"
                               class="text-sm text-green-600 hover:underline">Unduh</a>
                            <form action="{{ route('facility.document-archives.destroy', $archive->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6">Belum ada arsip dokumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
