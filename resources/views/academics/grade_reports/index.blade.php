@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Laporan Nilai Siswa</h2>
    <p class="text-sm text-gray-500">Tampilkan nilai siswa berdasarkan kelas, semester, dan mata pelajaran.</p>
  </div>

  {{-- Filter --}}
  <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
    <div>
      <label class="block text-sm font-medium mb-1">Semester</label>
      <select name="semester_id" class="w-48 border rounded px-3 py-2 text-sm">
        <option value="">Pilih Semester</option>
        @foreach($semesters as $semester)
          <option value="{{ $semester->id }}" {{ $selected['semester_id'] == $semester->id ? 'selected' : '' }}>
            {{ $semester->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Kelas</label>
      <select name="classroom_id" class="w-48 border rounded px-3 py-2 text-sm">
        <option value="">Pilih Kelas</option>
        @foreach($classrooms as $classroom)
          <option value="{{ $classroom->id }}" {{ $selected['classroom_id'] == $classroom->id ? 'selected' : '' }}>
            {{ $classroom->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
      <select name="subject_id" class="w-48 border rounded px-3 py-2 text-sm">
        <option value="">Pilih Mapel</option>
        @foreach($subjects as $subject)
          <option value="{{ $subject->id }}" {{ $selected['subject_id'] == $subject->id ? 'selected' : '' }}>
            {{ $subject->name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
      Tampilkan
    </button>
  </form>

  {{-- Tabel Nilai --}}
  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Nilai</th>
          <th class="px-4 py-2 text-left">Rata-rata</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($students as $student)
          <tr class="border-t">
            <td class="px-4 py-2">{{ $loop->iteration }}</td>
            <td class="px-4 py-2">{{ $student->name }}</td>
            <td class="px-4 py-2">
              @foreach($grades[$student->id] ?? [] as $detail)
                {{ $detail->gradeInput->type }}: {{ $detail->score }}<br>
              @endforeach
            </td>
            <td class="px-4 py-2">
              @php
                $avg = optional($grades[$student->id])->avg('score');
              @endphp
              {{ number_format($avg ?? 0, 2) }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada data nilai ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
