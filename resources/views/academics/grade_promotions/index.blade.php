@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Laporan Kenaikan Kelas</h2>
    <p class="text-sm text-gray-500">Rekap data siswa yang naik kelas dari tahun ajaran sebelumnya.</p>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Dari Kelas</th>
          <th class="px-4 py-2 text-left">Ke Kelas</th>
          <th class="px-4 py-2 text-left">Tanggal Proses</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($promotions as $promotion)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $promotion->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $promotion->fromClassroom->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $promotion->toClassroom->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($promotion->processed_at)->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data kenaikan kelas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
