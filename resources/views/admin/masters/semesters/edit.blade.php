@extends('layouts.app')

@section('content')
<div class="mb-6 max-w-xl">
  <h2 class="text-2xl font-bold text-blue-700">Edit Semester</h2>
  <p class="text-sm text-gray-500 mb-4">Perbarui data semester untuk tahun ajaran tertentu.</p>

  <form action="{{ route('master.semesters.update', $semester->id) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
      <select name="school_year_id" class="w-full border rounded px-3 py-2 text-sm" required>
        <option value="">Pilih Tahun Ajaran</option>
        @foreach($years as $year)
          <option value="{{ $year->id }}" {{ $semester->school_year_id == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
        @endforeach
      </select>
      @error('school_year_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Nama Semester</label>
      <input type="text" name="name" value="{{ old('name', $semester->name) }}" class="w-full border rounded px-3 py-2 text-sm" required>
      @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ $semester->is_active ? 'checked' : '' }}>
        <span class="ml-2 text-sm text-gray-700">Tandai sebagai semester aktif</span>
      </label>
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('master.semesters.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
      <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
    </div>
  </form>
</div>
@endsection
