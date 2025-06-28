@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Input Nilai Harian</h2>
  <p class="text-sm text-gray-500">Masukkan nilai siswa berdasarkan mata pelajaran dan kelas.</p>
</div>

<form action="{{ route('academic.grades.daily.store') }}" method="POST">
  @csrf
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div>
      <label class="block text-sm font-medium">Tanggal</label>
      <input type="date" name="date" class="w-full rounded border px-3 py-2 text-sm" required>
    </div>
    <div>
      <label class="block text-sm font-medium">Topik</label>
      <input type="text" name="topic" class="w-full rounded border px-3 py-2 text-sm">
    </div>
    <div>
      <label class="block text-sm font-medium">Kelas</label>
      <select name="classroom_id" class="w-full rounded border px-3 py-2 text-sm" required>
        <option value="">Pilih Kelas</option>
        @foreach($classrooms as $classroom)
          <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium">Mata Pelajaran</label>
      <select name="subject_id" class="w-full rounded border px-3 py-2 text-sm" required>
        <option value="">Pilih Mapel</option>
        @foreach($subjects as $subject)
          <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <h4 class="text-lg font-semibold mb-2">Nilai Siswa</h4>
  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border">No</th>
          <th class="px-4 py-2 border">Nama</th>
          <th class="px-4 py-2 border">Nilai</th>
          <th class="px-4 py-2 border">Catatan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $index => $student)
        <tr class="border-t">
          <td class="px-4 py-2 border">{{ $index + 1 }}</td>
          <td class="px-4 py-2 border">{{ $student->name }}</td>
          <td class="px-4 py-2 border">
            <input type="number" step="0.01" name="scores[{{ $student->id }}][score]" class="w-20 px-2 py-1 border rounded text-sm">
          </td>
          <td class="px-4 py-2 border">
            <input type="text" name="scores[{{ $student->id }}][note]" class="w-full px-2 py-1 border rounded text-sm">
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex justify-end">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
      Simpan Nilai
    </button>
  </div>
</form>
@endsection
