@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Tahfidz Bulanan</h2>
      <p class="text-sm text-gray-500">Rekap target dan capaian hafalan setiap bulan untuk masing-masing siswa.</p>
    </div>
    <a href="{{ route('religion.monthly-tahfidz-targets.create') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 shadow">
      + Tambah Target
    </a>
  </div>
    @if (session('success'))
    <div class="max-w-3xl mx-auto mb-4">
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow text-sm">
            ✅ {{ session('success') }}
        </div>
    </div>
@endif

  <div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full text-sm table-auto">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-2 text-left">Nama Siswa</th>
          <th class="px-4 py-2 text-left">Bulan</th>
          <th class="px-4 py-2 text-left">Target Juz</th>
          <th class="px-4 py-2 text-left">Tercapai</th>
          <th class="px-4 py-2 text-left">Catatan</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 divide-y">
        @forelse($targets as $target)
        <tr>
          <td class="px-4 py-2">{{ $target->student->name ?? '-' }}</td>
          <td class="px-4 py-2">
            {{ \Carbon\Carbon::create($target->year, $target->month)->translatedFormat('F Y') }}
          </td>
          <td class="px-4 py-2">{{ $target->target_juz }}</td>
          <td class="px-4 py-2">{{ $target->achieved_juz }}</td>
          <td class="px-4 py-2">{{ $target->note ?? '-' }}</td>
          <td class="px-4 py-2 space-x-2 whitespace-nowrap">
            <a href="{{ route('religion.monthly-tahfidz-targets.edit', $target->id) }}"
               class="text-sm text-blue-600 hover:underline">Edit</a>

            <form action="{{ route('religion.monthly-tahfidz-targets.destroy', $target->id) }}"
                  method="POST" class="inline-block"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data tahfidz bulanan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
