@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">
    <div class="mb-4">
      <a href="{{ route('tahfidz.submissions.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar setoran
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Edit Setoran Hafalan</h2>
    <p class="text-sm text-gray-500 mb-4">Perbarui informasi setoran hafalan siswa.</p>

    <form action="{{ route('tahfidz.submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id', $submission->student_id) == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Tanggal Setoran</label>
          <input type="date" name="recorded_at" value="{{ old('recorded_at', $submission->recorded_at) }}"
                 class="w-full border rounded px-3 py-2 text-sm" required>
          @error('recorded_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Guru Penyimak</label>
          <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">Pilih Guru</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ old('teacher_id', $submission->teacher_id) == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
          @error('teacher_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Surah</label>
        <input type="text" name="surah" value="{{ old('surah', $submission->surah) }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Dari Ayat</label>
          <input type="text" name="ayat_start" value="{{ old('ayat_start', $submission->ayat_start) }}"
                 class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Sampai Ayat</label>
          <input type="text" name="ayat_end" value="{{ old('ayat_end', $submission->ayat_end) }}"
                 class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Jenis Hafalan</label>
          <select name="type" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(['ziyadah','murojaah','tilawah'] as $type)
              <option value="{{ $type }}" {{ old('type', $submission->type) == $type ? 'selected' : '' }}>
                {{ ucfirst($type) }}
              </option>
            @endforeach
          </select>
          @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Status</label>
          <select name="status" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(['belum lancar','cukup','baik','sangat baik'] as $stat)
              <option value="{{ $stat }}" {{ old('status', $submission->status) == $stat ? 'selected' : '' }}>
                {{ ucfirst($stat) }}
              </option>
            @endforeach
          </select>
          @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nilai</label>
        <input type="number" name="score" min="0" max="100" value="{{ old('score', $submission->score) }}"
               class="w-full border rounded px-3 py-2 text-sm">
        @error('score') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan</label>
        <textarea name="note" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('note', $submission->note) }}</textarea>
        @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      @if($submission->attachment_path)
      <div class="mb-4">
        <p class="text-sm text-gray-700">Lampiran Saat Ini:
          <a href="{{ Storage::url($submission->attachment_path) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
        </p>
      </div>
      @endif

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Ganti Lampiran (opsional)</label>
        <input type="file" name="attachment" class="w-full border rounded px-3 py-2 text-sm">
        @error('attachment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_validated" class="mr-2"
                 {{ old('is_validated', $submission->is_validated) ? 'checked' : '' }}>
          Tandai sebagai sudah divalidasi
        </label>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Perbarui Setoran
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
