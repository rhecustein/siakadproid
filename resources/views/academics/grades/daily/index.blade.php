@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Input Nilai Harian</h2>
  <p class="text-sm text-gray-500">Kelola dan input nilai harian siswa berdasarkan mata pelajaran dan kelas.</p>
</div>

<!-- Filter -->
<form method="GET" action="" class="mb-4 flex flex-wrap gap-2">
  <select name="classroom_id" class="rounded px-3 py-2 border text-sm">
    <option value="">Pilih Kelas</option>
    @foreach($classrooms as $classroom)
      <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
        {{ $classroom->name }}
      </option>
    @endforeach
  </select>

  <select name="subject_id" class="rounded px-3 py-2 border text-sm">
    <option value="">Pilih Mata Pelajaran</option>
    @foreach($subjects as $subject)
      <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
        {{ $subject->name }}
      </option>
    @endforeach
  </select>

  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
    Tampilkan
  </button>
  <a href="{{ route('academic.grades.daily.create') }}" class="ml-auto bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
    + Input Nilai
  </a>
</form>

<!-- Tabel Nilai Harian -->
<div class="bg-white shadow rounded-lg overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 border">Tanggal</th>
        <th class="px-4 py-2 border">Mapel</th>
        <th class="px-4 py-2 border">Kelas</th>
        <th class="px-4 py-2 border">Topik</th>
        <th class="px-4 py-2 border">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($grades as $grade)
        <tr class="border-t hover:bg-gray-50">
          <td class="px-4 py-2 border">{{ $grade->date }}</td>
          <td class="px-4 py-2 border">{{ $grade->subject->name ?? '-' }}</td>
          <td class="px-4 py-2 border">{{ $grade->classroom->name ?? '-' }}</td>
          <td class="px-4 py-2 border">{{ $grade->topic ?? '-' }}</td>
          <td class="px-4 py-2 border text-center space-x-2">
            <a href="{{ route('academic.grades.daily.edit', $grade->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
            <form action="{{ route('academic.grades.daily.destroy', $grade->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Hapus data nilai ini?')">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada data nilai harian.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
