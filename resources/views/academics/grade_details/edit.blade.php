@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-bold text-blue-700 mb-4">Edit Nilai Siswa</h2>

  <form action="{{ route('academic.grade-details.update', $gradeDetail->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Pilih Grade Input -->
    <div class="mb-4">
      <label for="grade_input_id" class="block text-sm font-medium text-gray-700">Grade Input</label>
      <select name="grade_input_id" id="grade_input_id" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
        <option value="">Pilih Grade Input</option>
        @foreach($gradeInputs as $input)
          <option value="{{ $input->id }}" {{ $gradeDetail->grade_input_id == $input->id ? 'selected' : '' }}>
            {{ $input->id }} - {{ $input->date ?? 'Tanpa tanggal' }}
          </option>
        @endforeach
      </select>
      @error('grade_input_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Pilih Siswa -->
    <div class="mb-4">
      <label for="student_id" class="block text-sm font-medium text-gray-700">Siswa</label>
      <select name="student_id" id="student_id" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
        <option value="">Pilih Siswa</option>
        @foreach($students as $student)
          <option value="{{ $student->id }}" {{ $gradeDetail->student_id == $student->id ? 'selected' : '' }}>
            {{ $student->name }}
          </option>
        @endforeach
      </select>
      @error('student_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Nilai -->
    <div class="mb-4">
      <label for="score" class="block text-sm font-medium text-gray-700">Nilai</label>
      <input type="number" name="score" id="score" step="0.01" min="0" max="100"
             value="{{ old('score', $gradeDetail->score) }}"
             class="mt-1 block w-full border rounded px-3 py-2 text-sm">
      @error('score')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Catatan -->
    <div class="mb-4">
      <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
      <textarea name="note" id="note" rows="3" class="mt-1 block w-full border rounded px-3 py-2 text-sm">{{ old('note', $gradeDetail->note) }}</textarea>
      @error('note')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Tombol -->
    <div class="flex justify-end">
      <a href="{{ route('academic.grade-details.index') }}" class="bg-gray-200 text-sm px-4 py-2 rounded mr-2">Batal</a>
      <button type="submit" class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">Update</button>
    </div>
  </form>
</div>
@endsection
