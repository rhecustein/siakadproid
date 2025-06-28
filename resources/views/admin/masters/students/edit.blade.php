@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Edit Data Siswa</h2>
    <p class="text-sm text-gray-500">Perbarui data lengkap siswa pada formulir berikut.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('master.students.update', $student->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Login</label>
          <input type="email" name="email" id="email" value="{{ old('email', $student->user->email) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
          <input type="text" name="nis" id="nis" value="{{ old('nis', $student->nis) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
          <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $student->nisn) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
          <select name="gender" id="gender"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
          <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $student->place_of_birth) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
          <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
          <input type="text" name="religion" id="religion" value="{{ old('religion', $student->religion) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label for="school_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
          <select name="school_id" id="school_id"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
            <option value="">— Pilih Sekolah —</option>
            @foreach ($schools as $school)
              <option value="{{ $school->id }}" {{ old('school_id', $student->school_id) == $school->id ? 'selected' : '' }}>
                {{ $school->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="grade_id" class="block text-sm font-medium text-gray-700">Kelas</label>
          <select name="grade_id" id="grade_id"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500"
                  required>
              <option value="">— Pilih Kelas —</option>
              @foreach ($grades as $grade)
                  <option value="{{ $grade->id }}" {{ old('grade_id', $student->grade_id) == $grade->id ? 'selected' : '' }}>
                      {{ $grade->label }} ({{ $grade->description ?? 'Tanpa deskripsi' }})
                  </option>
              @endforeach
          </select>
        </div>
        <div>
          <label for="parent_id" class="block text-sm font-medium text-gray-700">Orang Tua / Wali</label>
          <select name="parent_id" id="parent_id"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            @foreach ($parents as $parent)
              <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                {{ $parent->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
          <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
          <label for="admission_date" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
          <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date', $student->admission_date) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
      </div>

      <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="address" id="address" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                  placeholder="Alamat lengkap">{{ old('address', $student->address) }}</textarea>
      </div>

      <div>
        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
        <textarea name="notes" id="notes" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                  placeholder="Catatan khusus">{{ old('notes', $student->notes) }}</textarea>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('master.students.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
