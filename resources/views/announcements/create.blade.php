@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-xl p-6 space-y-6">

  <h1 class="text-xl font-bold text-blue-700">📝 Buat Pengumuman Baru</h1>

  <form method="POST" action="{{ route('communication.announcements.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    {{-- Judul --}}
    <div>
      <label class="block text-sm font-medium text-gray-700">Judul</label>
      <input type="text" name="title" value="{{ old('title') }}"
             class="w-full mt-1 border-gray-300 rounded-md shadow-sm"
             required autofocus>
      @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Isi Konten --}}
    <div>
      <label class="block text-sm font-medium text-gray-700">Isi</label>
      <textarea name="content" rows="6"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('content') }}</textarea>
      @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Kategori, Prioritas, Target --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Kategori</label>
        <select name="category" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
          @foreach(['informasi', 'jadwal', 'keuangan', 'darurat', 'lainnya'] as $cat)
            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
              {{ ucfirst($cat) }}
            </option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Prioritas</label>
        <select name="priority" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
          @foreach(['normal', 'tinggi', 'mendesak'] as $prio)
            <option value="{{ $prio }}" {{ old('priority') === $prio ? 'selected' : '' }}>
              {{ ucfirst($prio) }}
            </option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Target</label>
        <select name="target" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
          @foreach(['all', 'guru', 'ortu', 'siswa'] as $target)
            <option value="{{ $target }}" {{ old('target') === $target ? 'selected' : '' }}>
              {{ ucfirst($target) }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Checkbox Options --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_pinned" value="1" class="rounded" {{ old('is_pinned') ? 'checked' : '' }}>
        Tampilkan di atas (Pinned)
      </label>
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', true) ? 'checked' : '' }}>
        Aktifkan
      </label>
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_public" value="1" class="rounded" {{ old('is_public') ? 'checked' : '' }}>
        Publik (bisa dibaca tanpa login)
      </label>
    </div>

    {{-- Tanggal Terbit & Kadaluarsa --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Tayang</label>
        <input type="datetime-local" name="published_at"
               class="w-full mt-1 border-gray-300 rounded-md shadow-sm"
               value="{{ old('published_at') }}">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
        <input type="datetime-local" name="expired_at"
               class="w-full mt-1 border-gray-300 rounded-md shadow-sm"
               value="{{ old('expired_at') }}">
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Target Sekolah</label>
        <select name="school_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
          @foreach($schools as $school)
            <option value="{{ $school->id }}" {{ old('school_id') === $school->id ? 'selected' : '' }}>
              {{ $school->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- File Lampiran --}}
    <div>
      <label class="block text-sm font-medium text-gray-700">Lampiran File</label>
      <input type="file" name="files[]" multiple class="mt-2 text-sm text-gray-600">
      <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, JPG, MP4, max 2MB per file.</p>
      @error('files.*') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end gap-3">
      <a href="{{ route('communication.announcements.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:underline">← Batal</a>
      <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
        Simpan Pengumuman
      </button>
    </div>
  </form>

</div>
@endsection
