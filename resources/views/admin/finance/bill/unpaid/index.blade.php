@extends('layouts.app')

@section('content')
<div class="max-w-screen-xl mx-auto py-6 px-4">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">📌 Daftar Tagihan Belum Lunas</h1>

  {{-- Filter --}}
  <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Sekolah</label>
      <select name="school_id" class="form-select w-full border-gray-300 rounded">
        <option value="">-- Semua --</option>
        @foreach($schools as $school)
          <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
            {{ $school->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Jenjang</label>
      <select name="level_id" class="form-select w-full border-gray-300 rounded">
        <option value="">-- Semua --</option>
        @foreach($levels as $level)
          <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
            {{ $level->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Kelas</label>
      <select name="grade_id" class="form-select w-full border-gray-300 rounded">
        <option value="">-- Semua --</option>
        @foreach($grades as $grade)
          <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
            {{ $grade->label }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="flex items-end">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        🔍 Filter
      </button>
    </div>
  </form>

  {{-- Tabel --}}
  <div class="overflow-x-auto bg-white rounded-lg shadow border">
    <table class="min-w-full text-sm text-left text-gray-700">
      <thead class="bg-gray-100 text-sm font-semibold text-gray-600">
        <tr>
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">Nama</th>
          <th class="px-4 py-3">NISN</th>
          <th class="px-4 py-3">Kelas</th>
          <th class="px-4 py-3">Sekolah</th>
          <th class="px-4 py-3 text-right">Jumlah Tagihan Aktif</th>
          <th class="px-4 py-3 text-right">Total Belum Lunas</th>
          <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($studentData as $index => $data)
          <tr class="border-t">
            <td class="px-4 py-3">{{ $index + 1 }}</td>
            <td class="px-4 py-3">{{ $data['student']->name }}</td>
            <td class="px-4 py-3">{{ $data['student']->nisn ?? '-' }}</td>
            <td class="px-4 py-3">{{ $data['student']->grade->label ?? '-' }}</td>
            <td class="px-4 py-3">{{ $data['student']->school->name ?? '-' }}</td>
            <td class="px-4 py-3 text-right">{{ $data['active_bills'] }}</td>
            <td class="px-4 py-3 text-right text-red-600 font-semibold">
              Rp {{ number_format($data['total_outstanding'], 0, ',', '.') }}
            </td>
            <td class="px-4 py-3 text-center">
              <a href="{{ route('finance.bills.index', ['student_id' => $data['student']->id]) }}"
                 class="text-blue-600 hover:underline text-sm">🔍 Detail</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-4 py-4 text-center text-gray-500">Tidak ada data tagihan belum lunas.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
