@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-xl bg-white p-6 rounded shadow">

    <div class="mb-4">
      <a href="{{ route('academic.grades.extracurricular.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar nilai ekstrakurikuler
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Edit Nilai Ekstrakurikuler</h2>
    <p class="text-sm text-gray-500 mb-4">Form untuk memperbarui nilai ekstrakurikuler siswa.</p>

    <form action="{{ route('academic.grades.extracurricular.update', $score->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Semester</label>
        <select name="semester_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($semesters as $semester)
            <option value="{{ $semester->id }}" {{ old('semester_id', $score->semester_id) == $semester->id ? 'selected' : '' }}>
              {{ $semester->name }}
            </option>
          @endforeach
        </select>
        @error('semester_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id', $score->student_id) == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Ekstrakurikuler</label>
        <select name="extracurricular_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($extracurriculars as $eks)
            <option value="{{ $eks->id }}" {{ old('extracurricular_id', $score->extracurricular_id) == $eks->id ? 'selected' : '' }}>
              {{ $eks->name }}
            </option>
          @endforeach
        </select>
        @error('extracurricular_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nilai</label>
        <input type="number" name="score" value="{{ old('score', $score->score) }}" step="0.01" min="0" max="100"
               class="w-full border rounded px-3 py-2 text-sm" required>
        @error('score')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="description" class="w-full border rounded px-3 py-2 text-sm" rows="3">{{ old('description', $score->description) }}</textarea>
        @error('description')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('academic.grades.extracurricular.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
      </div>
    </form>
  </div>
</div>
@endsection
