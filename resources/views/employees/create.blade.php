@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Tambah Pegawai Baru</h2>
  <p class="text-sm text-gray-500">Isi data pegawai dengan lengkap.</p>
</div>

<form action="{{ route('employee.employees.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-xl p-6 space-y-4">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- School --}}
    <div>
      <label class="text-sm font-medium text-gray-700">Unit Sekolah</label>
      <select name="school_id" class="form-select w-full" required>
        <option value="">- Pilih Sekolah -</option>
        @foreach ($schools as $school)
          <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
            {{ $school->name }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Field lainnya tetap --}}
    <div>
      <label class="text-sm font-medium text-gray-700">NIP</label>
      <input type="text" name="nip" value="{{ old('nip') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">No. HP</label>
      <input type="text" name="phone" value="{{ old('phone') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Posisi</label>
      <input type="text" name="position" value="{{ old('position') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Departemen</label>
      <input type="text" name="department" value="{{ old('department') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tempat Lahir</label>
      <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Lahir</label>
      <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Masuk</label>
      <input type="date" name="join_date" value="{{ old('join_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Keluar</label>
      <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Jenis Kelamin</label>
      <select name="gender" class="form-select w-full">
        <option value="">- Pilih -</option>
        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Status Pernikahan</label>
      <select name="marital_status" class="form-select w-full">
        <option value="">- Pilih -</option>
        <option value="Menikah" {{ old('marital_status') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
        <option value="Belum Menikah" {{ old('marital_status') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Agama</label>
      <input type="text" name="religion" value="{{ old('religion', 'Islam') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tingkat Pendidikan</label>
      <input type="text" name="education_level" value="{{ old('education_level') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Asal Institusi Pendidikan</label>
      <input type="text" name="last_education_institution" value="{{ old('last_education_institution') }}" class="form-input w-full" />
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-medium text-gray-700">Alamat</label>
      <textarea name="address" rows="3" class="form-textarea w-full">{{ old('address') }}</textarea>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Foto (opsional)</label>
      <input type="file" name="photo" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Status</label>
      <select name="status" class="form-select w-full">
        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
      </select>
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <a href="{{ route('employee.employees.index') }}"
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
