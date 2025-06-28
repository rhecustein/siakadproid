@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Edit Tahun Ajaran</h2>
    <p class="text-sm text-gray-500">Perbarui informasi tahun ajaran.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="route('academic.academic-years.update', ['academic_year' => $academicYear->id])" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="year" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
        <input type="text" id="year" name="year" value="{{ old('year', $academicYear->year) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
               placeholder="Contoh: 2024/2025" required>
        @error('year')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <a href="{{ route('academic.academic-years.index') }}"
           class="text-sm text-gray-600 hover:underline">← Kembali ke daftar</a>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
