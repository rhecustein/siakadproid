@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Laporan Storan Hafalan</h2>
      <p class="text-sm text-gray-500">Rekap storan hafalan siswa berdasarkan tanggal dan pembimbing.</p>
    </div>
    <a href="{{ route('academic.memorization-reports.create') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
      + Tambah Laporan
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Surah</th>
          <th class="px-4 py-2 text-left">Ayat</th>
          <th class="px-4 py-2 text-left">Juz</th>
          <th class="px-4 py-2 text-left">Pembimbing</th>
          <th class="px-4 py-2 text-left">Catatan</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($reports as $report)
        <tr class="border-t">
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</td>
          <td class="px-4 py-2">{{ $report->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $report->surah ?? '-' }}</td>
          <td class="px-4 py-2">
            {{ $report->ayat_start }} - {{ $report->ayat_end }}
          </td>
          <td class="px-4 py-2">{{ $report->juz ?? '-' }}</td>
          <td class="px-4 py-2">{{ $report->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $report->note }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada data hafalan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
