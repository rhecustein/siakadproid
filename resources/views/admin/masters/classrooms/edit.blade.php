@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Edit Ruangan Kelas</h2>
    <p class="text-sm text-gray-500">Perbarui informasi kelas seperti nama, jenjang, atau ruangan.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('master.classrooms.update', $classroom->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
        <input type="text" name="name" id="name" required
               value="{{ old('name', $classroom->name) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
      </div>

      <div>
        <label for="alias" class="block text-sm font-medium text-gray-700">Alias (Opsional)</label>
        <input type="text" name="alias" id="alias"
               value="{{ old('alias', $classroom->alias) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
      </div>

      <div>
        <label for="room" class="block text-sm font-medium text-gray-700">Keterangan</label>
        <input type="text" name="room" id="room"
               value="{{ old('room', $classroom->room) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
      </div>

      <div>
        <label for="level_id" class="block text-sm font-medium text-gray-700">Jenjang</label>
        <select name="level_id" id="level_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Pilih Jenjang —</option>
          @foreach ($levels as $level)
            <option value="{{ $level->id }}" {{ old('level_id', $classroom->level_id) == $level->id ? 'selected' : '' }}>
              {{ $level->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="grade_level_id" class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
        <select name="grade_level_id" id="grade_level_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Pilih Tingkat —</option>
          @foreach ($gradeLevels as $grade)
            <option value="{{ $grade->id }}" {{ old('grade_level_id', $classroom->grade_level_id) == $grade->id ? 'selected' : '' }}>
              {{ $grade->label }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
        <select name="academic_year_id" id="academic_year_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Pilih Tahun Ajaran —</option>
          @foreach ($academicYears as $year)
            <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id) == $year->id ? 'selected' : '' }}>
              {{ $year->year }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="curriculum_id" class="block text-sm font-medium text-gray-700">Kurikulum</label>
        <select name="curriculum_id" id="curriculum_id"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Pilih Kurikulum —</option>
          @foreach ($curriculums as $curriculum)
            <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $classroom->curriculum_id) == $curriculum->id ? 'selected' : '' }}>
              {{ $curriculum->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
        <input type="number" name="order" id="order"
               value="{{ old('order', $classroom->order) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
      </div>

      <div>
        <label for="is_active" class="block text-sm font-medium text-gray-700">Status Aktif</label>
        <select name="is_active" id="is_active"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="1" {{ old('is_active', $classroom->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ old('is_active', $classroom->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
        </select>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('master.classrooms.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Perbarui Kelas
        </button>
      </div>
    </form>
  </div>
@endsection
