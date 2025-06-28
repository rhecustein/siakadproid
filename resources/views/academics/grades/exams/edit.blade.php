@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-xl bg-white p-6 rounded shadow">

    <div class="mb-4">
      <a href="{{ route('academic.grades.exams.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar nilai ujian
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Edit Nilai Ujian</h2>
    <p class="text-sm text-gray-500 mb-4">Form untuk memperbarui data nilai ujian siswa.</p>

    <form action="{{ route('academic.grades.exams.update', $examScore->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Semester</label>
        <select name="semester_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($semesters as $semester)
            <option value="{{ $semester->id }}" {{ old('semester_id', $examScore->semester_id) == $semester->id ? 'selected' : '' }}>
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
            <option value="{{ $student->id }}" {{ old('student_id', $examScore->student_id) == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
        <select name="subject_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ old('subject_id', $examScore->subject_id) == $subject->id ? 'selected' : '' }}>
              {{ $subject->name }}
            </option>
          @endforeach
        </select>
        @error('subject_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Tipe Ujian</label>
        <select name="type" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach(['PAS', 'PAT', 'UTS', 'UAS'] as $type)
            <option value="{{ $type }}" {{ old('type', $examScore->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
          @endforeach
        </select>
        @error('type')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nilai</label>
        <input type="number" name="score" value="{{ old('score', $examScore->score) }}" step="0.01" min="0" max="100" required
               class="w-full border rounded px-3 py-2 text-sm">
        @error('score')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('academic.grades.exams.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
      </div>
    </form>
  </div>
</div>
@endsection
