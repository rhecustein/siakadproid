@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Tambah Orang Tua / Wali</h2>
    <p class="text-sm text-gray-500">Isi data lengkap orang tua atau wali yang akan dihubungkan dengan siswa.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('core.parents.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
          <select name="gender" id="gender"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        <div>
          <label for="relationship" class="block text-sm font-medium text-gray-700">Hubungan</label>
          <select name="relationship" id="relationship"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="ayah" {{ old('relationship') == 'ayah' ? 'selected' : '' }}>Ayah</option>
            <option value="ibu" {{ old('relationship') == 'ibu' ? 'selected' : '' }}>Ibu</option>
            <option value="wali" {{ old('relationship') == 'wali' ? 'selected' : '' }}>Wali</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
          <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email (opsional)</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
      </div>

      <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="address" id="address" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                  placeholder="Alamat lengkap">{{ old('address') }}</textarea>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('core.parents.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Orang Tua
        </button>
      </div>
    </form>
  </div>
@endsection
