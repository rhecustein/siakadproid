@extends('layouts.app')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">📅 Rekap Absensi Harian</h1>

  {{-- Filter --}}
  <form method="GET" action="{{ route('absences.index') }}" class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
        <input type="date" name="date" value="{{ request('date') }}" class="w-full border border-gray-300 rounded-md shadow-sm text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Jenis Absensi</label>
        <select name="absence_type_id" class="w-full border border-gray-300 rounded-md shadow-sm text-sm">
          <option value="">Semua</option>
          @foreach ($types as $type)
            <option value="{{ $type->id }}" {{ request('absence_type_id') == $type->id ? 'selected' : '' }}>
              {{ $type->label ?? $type->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="w-full border border-gray-300 rounded-md shadow-sm text-sm">
          <option value="">Semua</option>
          @foreach (['hadir', 'izin', 'sakit', 'alpa', 'pulang', 'ghoib'] as $status)
            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
              {{ ucfirst($status) }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="flex items-end">
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700">
          Tampilkan
        </button>
      </div>
      
      <div class="flex items-end">
        <a href="{{ route('absences.index') }}" class="w-full text-center text-sm text-gray-600 hover:underline">
          Reset
        </a>
      </div>
    </div>
  </form>

  {{-- Statistik Ringkas --}}
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-6">
    @foreach(['hadir','izin','sakit','alpa','pulang','ghoib'] as $key)
      <div class="bg-white p-4 rounded shadow text-center border border-gray-100">
        <p class="text-xs text-gray-500 capitalize mb-1">{{ $key }}</p>
        <p class="text-xl font-bold text-gray-800">{{ $counts[$key] ?? 0 }}</p>
      </div>
    @endforeach
  </div>

  {{-- Grup Absensi --}}
  @forelse ($groupedRecords as $label => $group)
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">{{ $label ?? 'Tanpa Kategori' }}</h2>
        <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-100 divide-y divide-gray-200">
          <thead class="bg-gray-50 text-gray-700">
            <tr>
              <th class="px-4 py-2 font-semibold">#</th>
              <th class="px-4 py-2 font-semibold">Nama</th>
              <th class="px-4 py-2 font-semibold">Kelas</th>
              <th class="px-4 py-2 font-semibold">Waktu</th>
              <th class="px-4 py-2 font-semibold">Status</th>
              <th class="px-4 py-2 font-semibold">Petugas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach ($group as $i => $record)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ $i + 1 }}</td>
                <td class="px-4 py-2">{{ $record->student->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $record->student->kelas->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $record->time_segment ?? '-' }}</td>
                <td class="px-4 py-2">
                  <span class="inline-block px-2 py-1 rounded text-xs font-medium
                    @switch($record->status)
                      @case('hadir') bg-green-100 text-green-800 @break
                      @case('izin') bg-yellow-100 text-yellow-800 @break
                      @case('sakit') bg-blue-100 text-blue-800 @break
                      @case('alpa') bg-red-100 text-red-800 @break
                      @case('pulang') bg-purple-100 text-purple-800 @break
                      @case('ghoib') bg-gray-200 text-gray-800 @break
                    @endswitch">
                    {{ ucfirst($record->status) }}
                  </span>
                </td>
                <td class="px-4 py-2">{{ $record->recorder->name ?? '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @empty
    <p class="text-center text-gray-500">Belum ada data absensi untuk hari ini.</p>
  @endforelse
</div>
@endsection
