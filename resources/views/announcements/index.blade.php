@extends('layouts.app')

@section('content')
<style>
  @keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fade-in 0.4s ease-out;
  }
</style>

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6 animate-fade-in">

  <!-- Header -->
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-blue-800">📋 Daftar Pengumuman</h1>
    <a href="{{ route('communication.announcements.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition shadow">
      + Buat Pengumuman
    </a>
  </div>

  <!-- Tabel -->
  <div class="overflow-auto bg-white shadow border border-gray-100 rounded-xl">
    <table class="min-w-full text-sm text-gray-800">
      <thead class="bg-gray-50 text-xs text-gray-600 uppercase sticky top-0 z-10">
        <tr>
          <th class="px-4 py-3 text-left">Judul</th>
          <th class="px-4 py-3 text-left">Kategori</th>
          <th class="px-4 py-3 text-left">Target</th>
          <th class="px-4 py-3 text-left">Prioritas</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3 text-left">Tayang</th>
          <th class="px-4 py-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        @forelse($announcements as $announcement)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3 font-medium text-gray-900">
              {{ $announcement->title }}
              @if ($announcement->is_pinned)
                <span class="ml-1 text-blue-500">📌</span>
              @endif
            </td>
            <td class="px-4 py-3 capitalize">{{ $announcement->category }}</td>
            <td class="px-4 py-3 capitalize">{{ $announcement->target }}</td>
            <td class="px-4 py-3">
              @php
                $color = match($announcement->priority) {
                  'mendesak' => 'red',
                  'tinggi' => 'yellow',
                  default => 'gray',
                };
              @endphp
              <span class="inline-block px-2 py-1 text-xs rounded bg-{{ $color }}-100 text-{{ $color }}-700 capitalize">
                {{ $announcement->priority }}
              </span>
            </td>
            <td class="px-4 py-3">
              @if($announcement->is_active)
                <span class="inline-block px-2 py-1 text-xs rounded bg-green-100 text-green-700">Aktif</span>
              @else
                <span class="inline-block px-2 py-1 text-xs rounded bg-gray-200 text-gray-600">Nonaktif</span>
              @endif
            </td>
            <td class="px-4 py-3">
              {{ $announcement->published_at ? $announcement->published_at->format('d M Y H:i') : '-' }}
            </td>
            <td class="px-4 py-3 space-x-2">
              <a href="{{ route('communication.announcements.edit', $announcement->id) }}"
                 class="text-sm text-blue-600 hover:underline">Edit</a>

              <form action="{{ route('communication.announcements.destroy', $announcement->id) }}"
                    method="POST" class="inline-block"
                    onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center py-6 text-gray-500">Belum ada pengumuman.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection
