@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Edit Jenis Tagihan</h2>
  <p class="text-sm text-gray-500">Perbarui informasi jenis tagihan berikut.</p>
</div>

@if ($errors->any())
  <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded shadow">
    <p class="font-semibold">Terjadi kesalahan:</p>
    <ul class="mt-2 list-disc list-inside text-sm">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('finance.bill-types.update', $billType->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
  @csrf
  @method('PUT')

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="text-sm font-medium text-gray-700">Nama</label>
      <input type="text" name="name" value="{{ old('name', $billType->name) }}" class="form-input w-full" required />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Kode</label>
      <input type="text" name="code" value="{{ old('code', $billType->code) }}" class="form-input w-full" required />
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
      <textarea name="description" rows="3" class="form-textarea w-full">{{ old('description', $billType->description) }}</textarea>
    </div>

    <div class="md:col-span-2">
      <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
        <input type="checkbox" name="is_active" class="form-checkbox"
               {{ old('is_active', $billType->is_active) ? 'checked' : '' }}>
        Aktifkan jenis tagihan ini
      </label>
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <a href="{{ route('finance.bill-types.index') }}"
       class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
      ← Batal
    </a>
    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
      Simpan Perubahan
    </button>
  </div>
</form>
@endsection
