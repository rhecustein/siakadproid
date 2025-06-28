@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 space-y-6">

  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold text-blue-700">📋 Daftar Pengumuman</h1>
    <a href="{{ route('announcements.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
      + Buat Pengumuman
    </a>
  </div>

  <div class="overflow-auto bg-white shadow rounded-xl border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600">
        <tr>
          <th class="px-4 py-3">Judul</th>
          <th class="px-4 py-3">Kategori</th>
          <th class="px-4 py-3">Target</th>
          <th class="px-4 py-3">Prioritas</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Tayang</th>
          <th class="px-4 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($announcements as $announcement)
          <tr>
            <td class="px-4 py-2 font-medium text-gray-800">
              {{ $announcement->title }}
              @if ($announcement->is_pinned)
                <span class="ml-2 text-xs text-blue-500">📌</span>
              @endif
            </td>
            <td class="px-4 py-2">{{ ucfirst($announcement->category) }}</td>
            <td class="px-4 py-2">{{ ucfirst($announcement->target) }}</td>
            <td class="px-4 py-2">
              <span class="px-2 py-1 text-xs rounded 
                bg-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-100 
                text-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-700">
                {{ ucfirst($announcement->priority) }}
              </span>
            </td>
            <td class="px-4 py-2">
              <span class="text-xs px-2 py-1 rounded 
                {{ $announcement->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td class="px-4 py-2">
              {{ $announcement->published_at ? $announcement->published_at->format('d M Y H:i') : '-' }}
            </td>
            <td class="px-4 py-2 space-x-2">
              <a href="{{ route('announcements.edit', $announcement->id) }}"
                 class="text-sm text-blue-600 hover:underline">Edit</a>

              <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="inline-block"
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
