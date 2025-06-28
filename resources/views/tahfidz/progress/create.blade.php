@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow space-y-6">

    <div>
      <a href="{{ route('religion.tahfidz-progresses.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Kembali ke progres tahfidz
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700">Tambah Progres Tahfidz</h2>
    <p class="text-sm text-gray-500 mb-4">Isi detail hafalan siswa sesuai perkembangan terakhir.</p>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
        <strong>Terjadi kesalahan:</strong>
        <ul class="list-disc ml-5 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('religion.tahfidz-progresses.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Siswa</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm @error('student_id') border-red-500 @enderror" required>
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
          <label class="block text-sm font-medium mb-1">Tanggal Pencatatan</label>
          <input type="date" name="recorded_at" value="{{ old('recorded_at') }}"
                 class="w-full border rounded px-3 py-2 text-sm @error('recorded_at') border-red-500 @enderror" required>
          @error('recorded_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Semester</label>
          <select name="semester_id" class="w-full border rounded px-3 py-2 text-sm @error('semester_id') border-red-500 @enderror">
            <option value="">Pilih Semester</option>
            @foreach($semesters as $semester)
              <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                {{ $semester->name }}
              </option>
            @endforeach
          </select>
          @error('semester_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Juz</label>
        <input type="number" name="juz" min="1" max="30" value="{{ old('juz') }}"
               class="w-full border rounded px-3 py-2 text-sm @error('juz') border-red-500 @enderror" required>
        @error('juz') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Dari Surah</label>
          <input type="text" name="from_surah" value="{{ old('from_surah') }}"
                 class="w-full border rounded px-3 py-2 text-sm @error('from_surah') border-red-500 @enderror">
          @error('from_surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Sampai Surah</label>
          <input type="text" name="to_surah" value="{{ old('to_surah') }}"
                 class="w-full border rounded px-3 py-2 text-sm @error('to_surah') border-red-500 @enderror">
          @error('to_surah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Dari Ayat</label>
          <input type="text" name="from_verse" value="{{ old('from_verse') }}"
                 class="w-full border rounded px-3 py-2 text-sm @error('from_verse') border-red-500 @enderror">
          @error('from_verse') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Sampai Ayat</label>
          <input type="text" name="to_verse" value="{{ old('to_verse') }}"
                 class="w-full border rounded px-3 py-2 text-sm @error('to_verse') border-red-500 @enderror">
          @error('to_verse') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Status Hafalan</label>
        <select name="status" class="w-full border rounded px-3 py-2 text-sm @error('status') border-red-500 @enderror" required>
          <option value="belum" {{ old('status') == 'belum' ? 'selected' : '' }}>Belum</option>
          <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
          <option value="hafal" {{ old('status') == 'hafal' ? 'selected' : '' }}>Hafal</option>
        </select>
        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan</label>
        <textarea name="remarks" rows="3"
                  class="w-full border rounded px-3 py-2 text-sm @error('remarks') border-red-500 @enderror">{{ old('remarks') }}</textarea>
        @error('remarks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-6">
        <input type="hidden" name="is_final" value="0">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_final" class="mr-2" value="1" {{ old('is_final') ? 'checked' : '' }}>
          Tandai sebagai final
        </label>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Simpan Progres
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
