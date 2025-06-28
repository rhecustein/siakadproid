@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Edit Data Orang Tua / Wali</h2>
    <p class="text-sm text-gray-500">Perbarui informasi orang tua atau wali siswa.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('core.parents.update', $parent->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', $parent->name) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
          <select name="gender" id="gender"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="L" {{ old('gender', $parent->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender', $parent->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        <div>
          <label for="relationship" class="block text-sm font-medium text-gray-700">Hubungan</label>
          <select name="relationship" id="relationship"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
            <option value="">— Pilih —</option>
            <option value="ayah" {{ old('relationship', $parent->relationship) == 'ayah' ? 'selected' : '' }}>Ayah</option>
            <option value="ibu" {{ old('relationship', $parent->relationship) == 'ibu' ? 'selected' : '' }}>Ibu</option>
            <option value="wali" {{ old('relationship', $parent->relationship) == 'wali' ? 'selected' : '' }}>Wali</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
          <input type="text" name="phone" id="phone" value="{{ old('phone', $parent->phone) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" required>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email', $parent->email) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        </div>
      </div>

      <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="address" id="address" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
                  placeholder="Alamat lengkap">{{ old('address', $parent->address) }}</textarea>
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('core.parents.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
