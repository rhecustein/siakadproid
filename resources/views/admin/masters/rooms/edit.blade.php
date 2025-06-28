@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start min-h-screen py-10">
  <div class="w-full max-w-xl bg-white p-6 rounded shadow">
    
    <div class="mb-4">
      <a href="{{ route('facility.rooms.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Kembali ke daftar ruangan
      </a>
    </div>

    <h2 class="text-2xl font-bold text-blue-700 mb-1">Edit Ruangan</h2>
    <p class="text-sm text-gray-500 mb-4">Form untuk memperbarui data ruangan.</p>

    <form action="{{ route('facility.rooms.update', $room->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">name Ruangan</label>
        <input type="text" name="name" value="{{ old('name', $room->name) }}" class="w-full border rounded px-3 py-2 text-sm" required placeholder="Contoh: Ruang Kelas 7A">
        @error('name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Sekolah</label>
        <select name="school_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih Sekolah</option>
          @foreach($schools as $school)
            <option value="{{ $school->id }}" {{ old('school_id', $room->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
          @endforeach
        </select>
        @error('school_id')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('facility.rooms.index') }}" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-100">Batal</a>
        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
      </div>
    </form>
  </div>
</div>
@endsection
