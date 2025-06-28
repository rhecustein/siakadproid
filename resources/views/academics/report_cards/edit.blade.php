@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-xl bg-white p-6 rounded shadow">

    <div class="mb-4">
      <a href="{{ route('academic.report-cards.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar rapor
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Edit Rapor Siswa</h2>
    <p class="text-sm text-gray-500 mb-4">Form untuk memperbarui data rapor siswa.</p>

    <form action="{{ route('academic.report-cards.update', $reportCard->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id', $reportCard->student_id) == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Semester</label>
        <select name="semester_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($semesters as $semester)
            <option value="{{ $semester->id }}" {{ old('semester_id', $reportCard->semester_id) == $semester->id ? 'selected' : '' }}>
              {{ $semester->name }}
            </option>
          @endforeach
        </select>
        @error('semester_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Kelas</label>
        <select name="classroom_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}" {{ old('classroom_id', $reportCard->classroom_id) == $classroom->id ? 'selected' : '' }}>
              {{ $classroom->name }}
            </option>
          @endforeach
        </select>
        @error('classroom_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Status Final</label>
        <select name="finalized" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="0" {{ old('finalized', $reportCard->finalized) == 0 ? 'selected' : '' }}>Belum Final</option>
          <option value="1" {{ old('finalized', $reportCard->finalized) == 1 ? 'selected' : '' }}>Final</option>
        </select>
        @error('finalized')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Catatan Rapor</label>
        <textarea name="note" class="w-full border rounded px-3 py-2 text-sm" rows="3">{{ old('note', $reportCard->note) }}</textarea>
        @error('note')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('academic.report-cards.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
      </div>
    </form>
  </div>
</div>
@endsection
