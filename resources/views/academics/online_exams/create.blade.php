@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">

    <div class="mb-4">
      <a href="{{ route('academic.online-exams.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar ujian
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Tambah Ujian Online</h2>
    <p class="text-sm text-gray-500 mb-4">Silakan lengkapi form untuk menjadwalkan ujian online baru.</p>

    <form action="{{ route('academic.online-exams.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Judul Ujian</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('title')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
          <select name="subject_id" class="w-full border rounded px-3 py-2 text-sm" required>
            <option value="">Pilih Mapel</option>
            @foreach($subjects as $subject)
              <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
            @endforeach
          </select>
          @error('subject_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Kelas</label>
          <select name="classroom_id" class="w-full border rounded px-3 py-2 text-sm" required>
            <option value="">Pilih Kelas</option>
            @foreach($classrooms as $classroom)
              <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                {{ $classroom->name }}
              </option>
            @endforeach
          </select>
          @error('classroom_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium mb-1">Pengajar</label>
          <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm" required>
            <option value="">Pilih Guru</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
          @error('teacher_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Tanggal & Waktu Mulai</label>
          <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="w-full border rounded px-3 py-2 text-sm" required>
          @error('start_at')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-1">Tanggal & Waktu Selesai</label>
        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('end_at')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium mb-1">Deskripsi Ujian (opsional)</label>
        <textarea name="description" class="w-full border rounded px-3 py-2 text-sm" rows="3">{{ old('description') }}</textarea>
        @error('description')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Simpan Ujian
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
