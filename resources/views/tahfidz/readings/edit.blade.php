@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">
    <div class="mb-4">
      <a href="{{ route('religion.quran-readings.index') }}" class="text-sm text-green-600 hover:underline">
        ← Kembali ke daftar mengaji
      </a>
    </div>

    <h2 class="text-2xl font-bold text-green-700 mb-1">Edit Kegiatan Mengaji</h2>
    <p class="text-sm text-gray-500 mb-4">Perbarui catatan bacaan Al-Qur'an siswa.</p>

    <form action="{{ route('religion.quran-readings.update', $reading->id) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm" required>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id', $reading->student_id) == $student->id ? 'selected' : '' }}>
              {{ $student->name }}
            </option>
          @endforeach
        </select>
        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Tanggal</label>
          <input type="date" name="recorded_at" value="{{ old('recorded_at', $reading->recorded_at) }}" class="w-full border rounded px-3 py-2 text-sm" required>
          @error('recorded_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Guru (opsional)</label>
          <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">Pilih Guru</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ old('teacher_id', $reading->teacher_id) == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
          @error('teacher_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Surah</label>
        <input type="text" name="surah" value="{{ old('surah', $reading->surah) }}" class="w-full border rounded px-3 py-2 text-sm" required>
        @error('surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Dari Ayat</label>
          <input type="text" name="ayat_start" value="{{ old('ayat_start', $reading->ayat_start) }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Sampai Ayat</label>
          <input type="text" name="ayat_end" value="{{ old('ayat_end', $reading->ayat_end) }}" class="w-full border rounded px-3 py-2 text-sm">
          @error('ayat_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Metode</label>
          <select name="method" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(['langsung','dengan guru','daring'] as $m)
              <option value="{{ $m }}" {{ old('method', $reading->method) == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
            @endforeach
          </select>
          @error('method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Status</label>
          <select name="status" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(['hadir','tidak hadir','izin','sakit'] as $s)
              <option value="{{ $s }}" {{ old('status', $reading->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan</label>
        <textarea name="note" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('note', $reading->note) }}</textarea>
        @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      @if($reading->attachment_path)
      <div class="mb-4">
        <p class="text-sm text-gray-700">Lampiran Saat Ini:
          <a href="{{ Storage::url($reading->attachment_path) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
        </p>
      </div>
      @endif

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Ganti Lampiran (opsional)</label>
        <input type="file" name="attachment" class="w-full border rounded px-3 py-2 text-sm">
        @error('attachment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
          Perbarui Kegiatan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
