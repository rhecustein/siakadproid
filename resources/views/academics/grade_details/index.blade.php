@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Daftar Nilai Siswa</h2>
  <p class="text-sm text-gray-500">Berikut adalah data nilai siswa yang sudah diinput berdasarkan grade input.</p>
</div>

<!-- Tombol Tambah -->
<div class="mb-4">
  <a href="{{ route('academic.grade-details.create') }}" class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
    + Input Nilai
  </a>
</div>

<!-- Tabel Nilai -->
<div class="bg-white shadow rounded-lg overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 border">ID</th>
        <th class="px-4 py-2 border">Tanggal</th>
        <th class="px-4 py-2 border">Siswa</th>
        <th class="px-4 py-2 border">Nilai</th>
        <th class="px-4 py-2 border">Catatan</th>
        <th class="px-4 py-2 border text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($gradeDetails as $detail)
        <tr class="border-t hover:bg-gray-50">
          <td class="px-4 py-2 border">{{ $detail->id }}</td>
          <td class="px-4 py-2 border">{{ $detail->gradeInput->date ?? '-' }}</td>
          <td class="px-4 py-2 border">{{ $detail->student->name ?? '-' }}</td>
          <td class="px-4 py-2 border">{{ $detail->score }}</td>
          <td class="px-4 py-2 border">{{ $detail->note ?? '-' }}</td>
          <td class="px-4 py-2 border text-center space-x-2">
            <a href="{{ route('academic.grade-details.edit', $detail->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
            <form action="{{ route('academic.grade-details.destroy', $detail->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Hapus data ini?')">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="px-4 py-3 text-center text-gray-500">Belum ada data nilai.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
