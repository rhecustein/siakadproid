@extends('layouts.app')

@section('content')
<div class="mb-8">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
        Edit Data Siswa
      </h2>
      <p class="text-sm text-gray-500 mt-1">Perbarui informasi lengkap siswa.</p>
    </div>
    <a href="{{ route('core.students.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
      ← Kembali ke Daftar
    </a>
  </div>

  <div class="bg-white shadow-lg rounded-xl p-6 md:p-8">
    <form action="{{ route('core.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
        {{-- Akun User --}}
        <div>
          <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Akun User <span class="text-red-500">*</span></label>
          {{-- Menambahkan 'disabled' dan 'pointer-events-none' untuk membuat field readonly secara visual --}}
          <select id="user_id" name="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm bg-gray-100 cursor-not-allowed pointer-events-none" required disabled>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $student->user_id) == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
          {{-- Penting: Jika user_id harus tetap dikirim saat update, tambahkan hidden input --}}
          <input type="hidden" name="user_id" value="{{ old('user_id', $student->user_id) }}">
          @error('user_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Sekolah --}}
        <div>
          <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Sekolah <span class="text-red-500">*</span></label>
          <select id="school_id" name="school_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm" required>
            @foreach ($schools as $school)
              <option value="{{ $school->id }}" {{ old('school_id', $student->school_id) == $school->id ? 'selected' : '' }}>
                {{ $school->name }}
              </option>
            @endforeach
          </select>
          @error('school_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Kelas --}}
        <div>
          <label for="grade_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
          <select id="grade_id" name="grade_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
            <option value="">- Pilih Kelas -</option>
            @foreach ($grades as $grade)
              <option value="{{ $grade->id }}" {{ old('grade_id', $student->grade_id) == $grade->id ? 'selected' : '' }}>
                {{ $grade->label }}
              </option>
            @endforeach
          </select>
          @error('grade_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Wali Utama --}}
        <div>
          <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Wali Utama</label>
          <select id="parent_id" name="parent_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
            <option value="">- Pilih Wali -</option>
            @foreach ($parents as $parent)
              <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                {{ $parent->name }}
              </option>
            @endforeach
          </select>
          @error('parent_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- NIS --}}
        <div>
          <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
          <input type="text" id="nis" name="nis" value="{{ old('nis', $student->nis) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('nis')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- NISN --}}
        <div>
          <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
          <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('nisn')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nama Lengkap --}}
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
          <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" required />
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Jenis Kelamin --}}
        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
          <select id="gender" name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
            <option value="">- Pilih -</option>
            <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
          @error('gender')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tempat Lahir --}}
        <div>
          <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
          <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $student->place_of_birth) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('place_of_birth')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div>
          <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
          <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('date_of_birth')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tanggal Masuk --}}
        <div>
          <label for="admission_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
          <input type="date" id="admission_date" name="admission_date" value="{{ old('admission_date', $student->admission_date?->format('Y-m-d')) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('admission_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tanggal Lulus --}}
        <div>
          <label for="graduation_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lulus</label>
          <input type="date" id="graduation_date" name="graduation_date" value="{{ old('graduation_date', $student->graduation_date?->format('Y-m-d')) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('graduation_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Agama --}}
        <div>
          <label for="religion" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
          <input type="text" id="religion" name="religion" value="{{ old('religion', $student->religion) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('religion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- No. HP --}}
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2" />
          @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Alamat --}}
        <div class="sm:col-span-2">
          <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
          <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2">{{ old('address', $student->address) }}</textarea>
          @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Status Siswa --}}
        <div>
          <label for="student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa</label>
          <select id="student_status" name="student_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
              <option value="aktif" {{ old('student_status', $student->student_status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="nonaktif" {{ old('student_status', $student->student_status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
              <option value="alumni" {{ old('student_status', $student->student_status) == 'alumni' ? 'selected' : '' }}>Alumni</option>
              <option value="lulus" {{ old('student_status', $student->student_status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
          </select>
          @error('student_status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Aktif --}}
        <div>
          <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Aktif</label>
          <select id="is_active" name="is_active" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
            <option value="1" {{ old('is_active', $student->is_active) ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', $student->is_active) == false ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
          @error('is_active')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Catatan --}}
        <div class="sm:col-span-2">
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
          <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2">{{ old('notes', $student->notes) }}</textarea>
          @error('notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Foto --}}
        <div class="sm:col-span-2">
          <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
          <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
          @if ($student->photo)
            <div class="mt-4">
              <p class="text-sm text-gray-600 mb-2">Foto Saat Ini:</p>
              <img src="{{ asset('storage/' . $student->photo) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-sm" alt="Foto Siswa">
            </div>
          @endif
          @error('photo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="pt-5 border-t border-gray-200">
        <div class="flex justify-end space-x-3">
          <a href="{{ route('core.students.index') }}"
             class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
            Batal
          </a>
          <button type="submit"
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
            Simpan Perubahan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection