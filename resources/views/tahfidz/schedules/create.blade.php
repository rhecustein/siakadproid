@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">
    <div class="mb-4">
      <a href="{{ route('religion.quran-review-schedules.index') }}" class="text-sm text-green-600 hover:underline">
        ← Kembali ke daftar jadwal
      </a>
    </div>

    <h2 class="text-2xl font-bold text-green-700 mb-1">Tambah Jadwal Murojaah</h2>
    <p class="text-sm text-gray-500 mb-4">Lengkapi informasi untuk membuat jadwal murojaah siswa.</p>

    <form action="{{ route('religion.quran-review-schedules.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih siswa</option>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
          @endforeach
        </select>
        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Hari</label>
          <select name="day" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(['senin','selasa','rabu','kamis','jumat','sabtu','ahad'] as $day)
              <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
            @endforeach
          </select>
          @error('day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Jam</label>
          <input type="time" name="time" value="{{ old('time') }}" class="w-full border rounded px-3 py-2 text-sm" required>
          @error('time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Guru (opsional)</label>
        <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm">
          <option value="">Pilih guru</option>
          @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
          @endforeach
        </select>
        @error('teacher_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Target Surah</label>
        <input type="text" name="target_surah" value="{{ old('target_surah') }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('target_surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Ayat Mulai</label>
          <input type="text" name="ayat_start" value="{{ old('ayat_start') }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Ayat Akhir</label>
          <input type="text" name="ayat_end" value="{{ old('ayat_end') }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Status Jadwal</label>
        <select name="status" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach(['aktif','selesai','batal'] as $status)
            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
          @endforeach
        </select>
        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
        <textarea name="note" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('note') }}</textarea>
        @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
          Simpan Jadwal
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
