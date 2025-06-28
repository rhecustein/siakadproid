@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Proses Kelulusan</h2>
    <p class="text-sm text-gray-500">Tentukan siswa yang dinyatakan lulus dari jenjang akhir.</p>
  </div>

  {{-- Filter --}}
  <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
    <div>
      <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
      <select name="school_year_id" class="w-48 border rounded px-3 py-2 text-sm">
        <option value="">Semua</option>
        @foreach($schoolYears as $year)
          <option value="{{ $year->id }}" {{ request('school_year_id') == $year->id ? 'selected' : '' }}>
            {{ $year->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Kelas</label>
      <select name="classroom_id" class="w-48 border rounded px-3 py-2 text-sm">
        <option value="">Semua</option>
        @foreach($classrooms as $classroom)
          <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
            {{ $classroom->name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
      Filter
    </button>
  </form>

  {{-- Daftar siswa --}}
  <form action="{{ route('academic.graduations.store') }}" method="POST">
    @csrf

    <div class="bg-white shadow rounded overflow-x-auto">
      <table class="min-w-full table-auto text-sm">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="px-4 py-2"><input type="checkbox" onclick="document.querySelectorAll('input[name^=student_ids]').forEach(cb => cb.checked = this.checked)" /></th>
            <th class="px-4 py-2 text-left">Nama Siswa</th>
            <th class="px-4 py-2 text-left">Kelas</th>
            <th class="px-4 py-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @forelse($students as $student)
          <tr class="border-t">
            <td class="px-4 py-2">
              <input type="checkbox" name="student_ids[]" value="{{ $student->id }}">
            </td>
            <td class="px-4 py-2">{{ $student->name }}</td>
            <td class="px-4 py-2">{{ $student->classroom->name ?? '-' }}</td>
            <td class="px-4 py-2">
              <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                Belum Lulus
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada siswa ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($students->count())
    <div class="mt-4">
      <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
        Tandai Lulus
      </button>
    </div>
    @endif
  </form>
</div>
@endsection
