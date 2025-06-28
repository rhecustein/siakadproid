@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">
    <div class="mb-4">
      <a href="{{ route('religion.memorization-submissions.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar setoran
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Tambah Setoran Hafalan</h2>
    <p class="text-sm text-gray-500 mb-4">Lengkapi form untuk mencatat setoran hafalan siswa.</p>

    <form action="{{ route('religion.memorization-submissions.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih Siswa</option>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Tanggal Setoran</label>
          <input type="date" name="recorded_at" value="{{ old('recorded_at') }}" class="w-full border rounded px-3 py-2 text-sm" required>
          @error('recorded_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Guru Penyimak</label>
          <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">Pilih Guru</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
          @error('teacher_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Surah</label>
        <input type="text" name="surah" value="{{ old('surah') }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Dari Ayat</label>
          <input type="text" name="ayat_start" value="{{ old('ayat_start') }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Sampai Ayat</label>
          <input type="text" name="ayat_end" value="{{ old('ayat_end') }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Jenis Hafalan</label>
          <select name="type" class="w-full border rounded px-3 py-2 text-sm" required>
            <option value="ziyadah" {{ old('type') == 'ziyadah' ? 'selected' : '' }}>Ziyadah</option>
            <option value="murojaah" {{ old('type') == 'murojaah' ? 'selected' : '' }}>Murojaah</option>
            <option value="tilawah" {{ old('type') == 'tilawah' ? 'selected' : '' }}>Tilawah</option>
          </select>
          @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Status</label>
          <select name="status" class="w-full border rounded px-3 py-2 text-sm" required>
            <option value="belum lancar" {{ old('status') == 'belum lancar' ? 'selected' : '' }}>Belum Lancar</option>
            <option value="cukup" {{ old('status') == 'cukup' ? 'selected' : '' }}>Cukup</option>
            <option value="baik" {{ old('status') == 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="sangat baik" {{ old('status') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
          </select>
          @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nilai (0–100)</label>
        <input type="number" name="score" value="{{ old('score') }}" class="w-full border rounded px-3 py-2 text-sm" min="0" max="100">
        @error('score') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan</label>
        <textarea name="note" class="w-full border rounded px-3 py-2 text-sm" rows="3">{{ old('note') }}</textarea>
        @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Lampiran (opsional)</label>
        <input type="file" name="attachment" class="w-full border rounded px-3 py-2 text-sm">
        @error('attachment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_validated" class="mr-2" {{ old('is_validated') ? 'checked' : '' }}>
          Tandai sebagai sudah divalidasi
        </label>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Simpan Setoran
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
