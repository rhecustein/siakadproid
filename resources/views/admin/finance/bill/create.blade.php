@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Tambah Tagihan Manual</h2>
  <p class="text-sm text-gray-500">Lengkapi form berikut untuk membuat tagihan manual tanpa grup.</p>
</div>

@if (session('error'))
  <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded shadow">
    {{ session('error') }}
  </div>
@endif

@if (session('success'))
  <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow">
    {{ session('success') }}
  </div>
@endif

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

<form action="{{ route('finance.bills.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="text-sm font-medium text-gray-700">Siswa</label>
      <select name="student_id" class="form-select w-full" required>
        <option value="">- Pilih Siswa -</option>
        @foreach ($students as $student)
          <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
            {{ $student->name }} ({{ $student->nis ?? 'NIS kosong' }})
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Kelompok Tagihan (Opsional)</label>
      <select name="bill_group_id" class="form-select w-full">
        <option value="">- Tidak Dikelompokkan -</option>
        @foreach ($billGroups as $group)
          <option value="{{ $group->id }}" {{ old('bill_group_id') == $group->id ? 'selected' : '' }}>
            {{ $group->name }}
          </option>
        @endforeach
      </select>
    </div>

   <div>
    <label class="text-sm font-medium text-gray-700">Jenis Tagihan</label>
    <select name="bill_type_id" class="form-select w-full" required>
        <option value="">- Pilih Jenis -</option>
        @foreach ($billTypes as $type)
        <option value="{{ $type->id }}" {{ old('bill_type_id') == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
        </option>
        @endforeach
    </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Judul Tagihan</label>
      <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full" required />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Jumlah Tagihan (Rp)</label>
      <input type="number" step="0.01" name="total_amount" value="{{ old('total_amount') }}" class="form-input w-full" required />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
      <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
      <input type="date" name="due_date" value="{{ old('due_date') }}" class="form-input w-full" />
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Status</label>
      <select name="status" class="form-select w-full">
        <option value="unpaid" {{ old('status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
        <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>Sebagian</option>
        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
      </select>
    </div>

    <div>
      <label class="text-sm font-medium text-gray-700">Petugas Input</label>
      <select name="created_by" class="form-select w-full">
        <option value="">- Pilih User -</option>
        @foreach ($users as $user)
          <option value="{{ $user->id }}" {{ old('created_by') == $user->id ? 'selected' : '' }}>
            {{ $user->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-medium text-gray-700">Catatan</label>
      <textarea name="notes" rows="3" class="form-textarea w-full">{{ old('notes') }}</textarea>
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <a href="{{ route('finance.bills.index') }}"
       class="inline-block px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
      ← Batal
    </a>
    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
      Simpan Tagihan
    </button>
  </div>
</form>
@endsection
