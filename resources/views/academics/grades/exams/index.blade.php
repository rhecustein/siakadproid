@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Daftar Nilai Ujian</h2>
    <p class="text-sm text-gray-500">Berikut adalah data nilai ujian siswa berdasarkan semester dan mata pelajaran.</p>
  </div>

  <div class="mb-4 text-right">
    <a href="{{ route('academic.grades.exams.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
      + Tambah Nilai Ujian
    </a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Semester</th>
          <th class="px-4 py-2 text-left">Mata Pelajaran</th>
          <th class="px-4 py-2 text-left">Tipe Ujian</th>
          <th class="px-4 py-2 text-left">Nilai</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @foreach($examScores as $score)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $loop->iteration }}</td>
          <td class="px-4 py-2">{{ $score->student->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $score->semester->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $score->subject->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $score->type }}</td>
          <td class="px-4 py-2">{{ $score->score }}</td>
          <td class="px-4 py-2 space-x-2">
            <a href="{{ route('academic.grades.exams.edit', $score->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('academic.grades.exams.destroy', $score->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
