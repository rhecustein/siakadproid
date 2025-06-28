@extends('layouts.app')

@section('content')
<div class="mb-6 max-w-xl">
  <h2 class="text-2xl font-bold text-blue-700">Tambah Semester</h2>
  <p class="text-sm text-gray-500 mb-4">Form untuk menambahkan data semester baru.</p>

  <form action="{{ route('shared.semesters.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf

    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
      <select name="school_year_id" class="w-full border rounded px-3 py-2 text-sm" required>
        <option value="">Pilih Tahun Ajaran</option>
        @foreach($years as $year)
          <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
        @endforeach
      </select>
      @error('school_year_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Nama Semester</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 text-sm" required placeholder="Contoh: Ganjil">
      @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('shared.semesters.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
      <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    </div>
  </form>
</div>
@endsection
