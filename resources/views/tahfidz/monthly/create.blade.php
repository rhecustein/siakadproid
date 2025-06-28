@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">

    <div class="mb-4">
      <a href="{{ route('religion.monthly-tahfidz-targets.index') }}" class="text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar tahfidz bulanan
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Tambah Target Tahfidz Bulanan</h2>
    <p class="text-sm text-gray-500 mb-4">Silakan lengkapi form berikut untuk mencatat target dan capaian hafalan siswa.</p>

    <form action="{{ route('religion.monthly-tahfidz-targets.store') }}" method="POST">
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
        @error('student_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Tahun</label>
          <input type="number" name="year" value="{{ old('year', now()->year) }}"
                 class="w-full border rounded px-3 py-2 text-sm" required>
          @error('year')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Bulan</label>
          <select name="month" class="w-full border rounded px-3 py-2 text-sm" required>
            @foreach(range(1, 12) as $m)
              <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
              </option>
            @endforeach
          </select>
          @error('month')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium mb-1">Target Juz</label>
          <input type="number" name="target_juz" value="{{ old('target_juz') }}"
                 class="w-full border rounded px-3 py-2 text-sm" required min="0">
          @error('target_juz')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Capaian Juz</label>
          <input type="number" name="achieved_juz" value="{{ old('achieved_juz') }}"
                 class="w-full border rounded px-3 py-2 text-sm" required min="0">
          @error('achieved_juz')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Catatan</label>
        <textarea name="note" class="w-full border rounded px-3 py-2 text-sm" rows="3">{{ old('note') }}</textarea>
        @error('note')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
