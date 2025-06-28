@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Edit Data Guru</h2>
    <p class="text-sm text-gray-500">Perbarui informasi guru sesuai kebutuhan.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
          <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
          <select name="gender" id="gender"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email', $teacher->email) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
        </div>
        <div>
          <label for="school_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
          <select name="school_id" id="school_id"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
            <option value="">— Pilih Sekolah —</option>
            @foreach ($schools as $school)
              <option value="{{ $school->id }}" {{ old('school_id', $teacher->school_id) == $school->id ? 'selected' : '' }}>
                {{ $school->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="position" class="block text-sm font-medium text-gray-700">Posisi</label>
          <input type="text" name="position" id="position" value="{{ old('position', $teacher->position) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                 placeholder="Contoh: Wali Kelas, Guru Tahfidz, Waka">
        </div>
        <div>
          <label for="employment_status" class="block text-sm font-medium text-gray-700">Status Kepegawaian</label>
          <select name="employment_status" id="employment_status"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih Status —</option>
            <option value="Tetap" {{ old('employment_status', $teacher->employment_status) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
            <option value="Kontrak" {{ old('employment_status', $teacher->employment_status) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            <option value="Honorer" {{ old('employment_status', $teacher->employment_status) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
          </select>
        </div>
      </div>

      <div>
        <label for="type" class="block text-sm font-medium text-gray-700">Jenis Guru</label>
        <select name="type" id="type"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Pilih Jenis —</option>
          <option value="Formal" {{ old('type', $teacher->type) == 'Formal' ? 'selected' : '' }}>Formal</option>
          <option value="Pondok" {{ old('type', $teacher->type) == 'Pondok' ? 'selected' : '' }}>Pondok</option>
          <option value="Diniyah" {{ old('type', $teacher->type) == 'Diniyah' ? 'selected' : '' }}>Diniyah</option>
        </select>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('teachers.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
