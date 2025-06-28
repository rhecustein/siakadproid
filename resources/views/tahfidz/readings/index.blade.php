@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-green-700">Kegiatan Mengaji</h2>
      <p class="text-sm text-gray-500">Rekap bacaan Al-Qur'an siswa beserta kehadiran dan metode.</p>
    </div>
    <a href="{{ route('religion.quran-readings.create') }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
      + Tambah Bacaan
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Siswa</th>
          <th class="px-4 py-2 text-left">Surah & Ayat</th>
          <th class="px-4 py-2 text-left">Metode</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Guru</th>
          <th class="px-4 py-2 text-left">Lampiran</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @forelse($readings as $reading)
        <tr class="border-t">
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reading->recorded_at)->format('d M Y') }}</td>
          <td class="px-4 py-2">{{ $reading->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $reading->surah }}:{{ $reading->ayat_start }} - {{ $reading->ayat_end }}</td>
          <td class="px-4 py-2 capitalize">{{ $reading->method }}</td>
          <td class="px-4 py-2 capitalize">{{ $reading->status }}</td>
          <td class="px-4 py-2">{{ $reading->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">
            @if($reading->attachment_path)
              <a href="{{ Storage::url($reading->attachment_path) }}" class="text-blue-600 hover:underline" target="_blank">Lihat</a>
            @else
              -
            @endif
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('religion.quran-readings.edit', $reading->id) }}" class="text-indigo-600 hover:underline">Edit</a>
            <form action="{{ route('religion.quran-readings.destroy', $reading->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline" type="submit">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada data mengaji.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
