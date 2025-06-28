@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Ujian Online</h2>
      <p class="text-sm text-gray-500">Daftar seluruh ujian online yang dijadwalkan.</p>
    </div>
    <a href="{{ route('academic.online-exams.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
      + Tambah Ujian
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full text-sm table-auto">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Judul</th>
          <th class="px-4 py-2 text-left">Mapel</th>
          <th class="px-4 py-2 text-left">Kelas</th>
          <th class="px-4 py-2 text-left">Pengajar</th>
          <th class="px-4 py-2 text-left">Waktu</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($exams as $exam)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $exam->title }}</td>
          <td class="px-4 py-2">{{ $exam->subject->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $exam->classroom->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $exam->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">
            {{ \Carbon\Carbon::parse($exam->start_at)->format('d M Y H:i') }} -
            {{ \Carbon\Carbon::parse($exam->end_at)->format('H:i') }}
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('online-exams.show', $exam->id) }}" class="text-blue-600 hover:underline">Lihat</a>
            <a href="{{ route('online-exams.edit', $exam->id) }}" class="text-indigo-600 hover:underline">Edit</a>
            <form action="{{ route('online-exams.destroy', $exam->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada ujian dijadwalkan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
