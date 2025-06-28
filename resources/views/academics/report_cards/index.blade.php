@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Rapor Siswa</h2>
      <p class="text-sm text-gray-500">Lihat dan kelola data rapor siswa berdasarkan semester, kelas, dan nama siswa.</p>
    </div>
    <a href="{{ route('academic.report-cards.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
      + Tambah Rapor
    </a>
  </div>

  {{-- Filter --}}
  <div class="mb-4">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
      <div>
        <label class="block text-sm font-medium mb-1">Semester</label>
        <select name="semester_id" class="border rounded px-3 py-2 text-sm">
          <option value="">Semua</option>
          @foreach($semesters as $semester)
            <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
              {{ $semester->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Kelas</label>
        <select name="classroom_id" class="border rounded px-3 py-2 text-sm">
          <option value="">Semua</option>
          @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
              {{ $classroom->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
               class="border rounded px-3 py-2 text-sm w-48">
      </div>

      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
        Filter
      </button>
    </form>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Kelas</th>
          <th class="px-4 py-2 text-left">Semester</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($reportCards as $report)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $loop->iteration }}</td>
          <td class="px-4 py-2">{{ $report->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $report->classroom->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $report->semester->name ?? '-' }}</td>
          <td class="px-4 py-2">
            <span class="inline-block px-2 py-1 text-xs rounded {{ $report->finalized ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
              {{ $report->finalized ? 'Final' : 'Belum Final' }}
            </span>
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('academic.report-cards.show', $report->id) }}" class="text-blue-600 hover:underline">Lihat</a>
            @if(!$report->finalized)
              <a href="{{ route('academic.report-cards.edit', $report->id) }}" class="text-indigo-600 hover:underline">Edit</a>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-4 text-center text-gray-500">Tidak ada data rapor ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
