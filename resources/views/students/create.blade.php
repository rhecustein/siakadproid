@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Tambah Data Siswa</h2>
  <p class="text-sm text-gray-500">Lengkapi informasi siswa baru.</p>
</div>

<form action="{{ route('core.students.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-xl p-6 space-y-4">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
      <label class="text-sm font-medium text-gray-700">Akun User</label>
      <select name="user_id" class="form-select w-full" required>
        <option value="">- Pilih Akun -</option>
        @foreach ($users as $user)
          <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->email }})
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Sekolah</label>
      <select name="school_id" class="form-select w-full" required>
        <option value="">- Pilih Sekolah -</option>
        @foreach ($schools as $school)
          <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
            {{ $school->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Kelas</label>
      <select name="grade_id" class="form-select w-full">
        <option value="">- Pilih Kelas -</option>
        @foreach ($grades as $grade)
          <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
            {{ $grade->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Wali Utama</label>
      <select name="parent_id" class="form-select w-full">
        <option value="">- Pilih Wali -</option>
        @foreach ($parents as $parent)
          <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
            {{ $parent->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">NIS</label>
      <input type="text" name="nis" value="{{ old('nis') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">NISN</label>
      <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full" required />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Jenis Kelamin</label>
      <select name="gender" class="form-select w-full">
        <option value="">- Pilih -</option>
        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tempat Lahir</label>
      <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Lahir</label>
      <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Masuk</label>
      <input type="date" name="admission_date" value="{{ old('admission_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Lulus</label>
      <input type="date" name="graduation_date" value="{{ old('graduation_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Agama</label>
      <input type="text" name="religion" value="{{ old('religion', 'Islam') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">No. HP</label>
      <input type="text" name="phone" value="{{ old('phone') }}" class="form-input w-full" />
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-medium text-gray-700">Alamat</label>
      <textarea name="address" rows="3" class="form-textarea w-full">{{ old('address') }}</textarea>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Status Siswa</label>
      <input type="text" name="student_status" value="{{ old('student_status', 'aktif') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Aktif</label>
      <select name="is_active" class="form-select w-full">
        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-medium text-gray-700">Catatan</label>
      <textarea name="notes" rows="3" class="form-textarea w-full">{{ old('notes') }}</textarea>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Foto</label>
      <input type="file" name="photo" class="form-input w-full" />
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <a href="{{ route('core.students.index') }}"
       class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
      ← Batal
    </a>
    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
      Simpan Data
    </button>
  </div>
</form>
@endsection
