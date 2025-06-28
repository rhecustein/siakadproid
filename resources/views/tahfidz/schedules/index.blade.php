@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-green-700">Jadwal Murojaah</h2>
      <p class="text-sm text-gray-500">Daftar jadwal murojaah siswa setiap pekan berdasarkan guru, hari, dan surah.</p>
    </div>
    <a href="{{ route('religion.quran-review-schedules.create') }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
      + Tambah Jadwal
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Hari</th>
          <th class="px-4 py-2 text-left">Waktu</th>
          <th class="px-4 py-2 text-left">Siswa</th>
          <th class="px-4 py-2 text-left">Guru</th>
          <th class="px-4 py-2 text-left">Target</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @forelse($schedules as $schedule)
        <tr class="border-t">
          <td class="px-4 py-2 capitalize">{{ $schedule->day }}</td>
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</td>
          <td class="px-4 py-2">{{ $schedule->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $schedule->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">
            {{ $schedule->target_surah }}:{{ $schedule->ayat_start }} - {{ $schedule->ayat_end }}
          </td>
          <td class="px-4 py-2">
            <span class="inline-block px-2 py-1 text-xs rounded
              @if($schedule->status == 'aktif') bg-green-100 text-green-700
              @elseif($schedule->status == 'selesai') bg-blue-100 text-blue-700
              @else bg-red-100 text-red-700 @endif">
              {{ ucfirst($schedule->status) }}
            </span>
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('religion.quran-review-schedules.edit', $schedule->id) }}" class="text-indigo-600 hover:underline">Edit</a>
            <form action="{{ route('religion.quran-review-schedules.destroy', $schedule->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada jadwal murojaah.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
