@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Tetapkan Wali Kelas</h2>
    <p class="text-sm text-gray-500">Pilih guru, kelas, dan tahun ajaran untuk penugasan wali kelas.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('master.homeroom.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label for="teacher_id" class="block text-sm font-medium text-gray-700">Guru</label>
        <select name="teacher_id" id="teacher_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
          <option value="">— Pilih Guru —</option>
          @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
              {{ $teacher->name }} ({{ $teacher->position ?? 'Guru' }})
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="classroom_id" class="block text-sm font-medium text-gray-700">Kelas</label>
        <select name="classroom_id" id="classroom_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
          <option value="">— Pilih Kelas —</option>
          @foreach ($classrooms as $class)
            <option value="{{ $class->id }}" {{ old('classroom_id') == $class->id ? 'selected' : '' }}>
              {{ $class->name }} — {{ $class->academicYear->year ?? '-' }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
        <select name="academic_year_id" id="academic_year_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
          <option value="">— Pilih Tahun Ajaran —</option>
          @foreach ($academicYears as $year)
            <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
              {{ $year->year }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
        <textarea name="note" id="note" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                  placeholder="Misal: Penugasan awal semester atau pengganti sebelumnya">{{ old('note') }}</textarea>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('master.homeroom.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Penugasan
        </button>
      </div>
    </form>
  </div>
@endsection
