@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <div>
    <h2 class="text-2xl font-bold text-blue-700">Semester</h2>
    <p class="text-sm text-gray-500">Kelola daftar semester untuk setiap tahun ajaran.</p>
  </div>
  <a href="{{ route('shared.semesters.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">+ Tambah Semester</a>
</div>

@if (session('success'))
  <div class="mb-4 text-sm text-green-700 bg-green-100 px-4 py-3 rounded">
    {{ session('success') }}
  </div>
@endif

<div class="bg-white shadow rounded overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 border">#</th>
        <th class="px-4 py-2 border">Semester</th>
        <th class="px-4 py-2 border">Tahun Ajaran</th>
        <th class="px-4 py-2 border">Status</th>
        <th class="px-4 py-2 border text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($semesters as $index => $semester)
        <tr class="border-t hover:bg-gray-50">
          <td class="px-4 py-2 border">{{ $index + 1 }}</td>
          <td class="px-4 py-2 border">{{ $semester->name }}</td>
          <td class="px-4 py-2 border">{{ $semester->schoolYear->name }}</td>
          <td class="px-4 py-2 border">
            @if ($semester->is_active)
              <span class="inline-block bg-green-100 text-green-700 px-3 py-1 text-xs rounded">Aktif</span>
            @else
              <span class="inline-block bg-gray-100 text-gray-600 px-3 py-1 text-xs rounded">Tidak Aktif</span>
            @endif
          </td>
          <td class="px-4 py-2 border text-center space-x-2">
            <a href="{{ route('shared.semesters.edit', $semester->id) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
            <form action="{{ route('shared.semesters.destroy', $semester->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
              @csrf
              @method('DELETE')
              <button class="text-red-600 text-sm hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada data semester.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
