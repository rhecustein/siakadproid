@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Setoran Hafalan Siswa</h2>
      <p class="text-sm text-gray-500">Rekap hafalan harian siswa lengkap dengan bukti dan penilaian.</p>
    </div>
    <a href="{{ route('religion.memorization-submissions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
      + Tambah Setoran
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Siswa</th>
          <th class="px-4 py-2 text-left">Surah & Ayat</th>
          <th class="px-4 py-2 text-left">Jenis</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Nilai</th>
          <th class="px-4 py-2 text-left">Guru</th>
          <th class="px-4 py-2 text-left">Lampiran</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @forelse($submissions as $submission)
        <tr class="border-t">
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($submission->recorded_at)->format('d M Y') }}</td>
          <td class="px-4 py-2">{{ $submission->student->name ?? '-' }}</td>
          <td class="px-4 py-2">
            {{ $submission->surah }}:{{ $submission->ayat_start }} - {{ $submission->ayat_end }}
          </td>
          <td class="px-4 py-2 capitalize">{{ $submission->type }}</td>
          <td class="px-4 py-2 capitalize">{{ $submission->status }}</td>
          <td class="px-4 py-2">{{ $submission->score ?? '-' }}</td>
          <td class="px-4 py-2">{{ $submission->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">
            @if($submission->attachment_path)
              <a href="{{ Storage::url($submission->attachment_path) }}" target="_blank" class="text-blue-600 hover:underline">
                Lihat
              </a>
            @else
              -
            @endif
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('religion.memorization-submissions.edit', $submission->id) }}" class="text-indigo-600 hover:underline">Edit</a>
            <form method="POST" action="{{ route('religion.memorization-submissions.destroy', $submission->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus setoran ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="px-4 py-4 text-center text-gray-500">Belum ada data setoran hafalan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
