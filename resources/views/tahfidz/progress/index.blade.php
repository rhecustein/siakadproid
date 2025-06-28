@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 sm:px-6 lg:px-8">

  {{-- Alert sukses --}}
  @if(session('success'))
    <div class="mb-4 max-w-3xl mx-auto">
      <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded text-sm shadow">
        ✅ {{ session('success') }}
      </div>
    </div>
  @endif

  <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Progress Tahfidz Siswa</h2>
      <p class="text-sm text-gray-500">Lihat dan pantau perkembangan hafalan siswa berdasarkan juz dan surah.</p>
    </div>
    <a href="{{ route('religion.tahfidz-progresses.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
      + Tambah Progres
    </a>
  </div>

  <form method="GET" class="mb-5 flex flex-wrap gap-4 items-end">
    <div>
      <label class="text-sm font-medium">Siswa</label>
      <select name="student_id" class="w-56 border rounded px-3 py-2 text-sm">
        <option value="">Semua</option>
        @foreach($students as $student)
          <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
            {{ $student->name }}
          </option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
      Filter
    </button>
  </form>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full text-sm table-auto">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Tanggal</th>
          <th class="px-4 py-2 text-left">Siswa</th>
          <th class="px-4 py-2 text-left">Juz</th>
          <th class="px-4 py-2 text-left">Dari Surah/Ayat</th>
          <th class="px-4 py-2 text-left">Sampai Surah/Ayat</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Semester</th>
          <th class="px-4 py-2 text-left">Validator</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @forelse($progressList as $progress)
        <tr class="border-t">
          <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($progress->recorded_at)->format('d M Y') }}</td>
          <td class="px-4 py-2">{{ $progress->student->name ?? '-' }}</td>
          <td class="px-4 py-2">Juz {{ $progress->juz }}</td>
          <td class="px-4 py-2">{{ $progress->from_surah }}:{{ $progress->from_verse }}</td>
          <td class="px-4 py-2">{{ $progress->to_surah }}:{{ $progress->to_verse }}</td>
          <td class="px-4 py-2">
            <span class="px-2 py-1 text-xs rounded 
              {{ $progress->status === 'hafal' ? 'bg-green-100 text-green-700' : 
                 ($progress->status === 'proses' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-600') }}">
              {{ ucfirst($progress->status) }}
            </span>
          </td>
          <td class="px-4 py-2">{{ $progress->semester->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $progress->validator->name ?? '-' }}</td>
          <td class="px-4 py-2 whitespace-nowrap flex gap-2">
            <a href="{{ route('religion.tahfidz-progresses.edit', $progress->id) }}"
               class="text-indigo-600 hover:underline">Edit</a>
            <form action="{{ route('religion.tahfidz-progresses.destroy', $progress->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin hapus?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="px-4 py-4 text-center text-gray-500">Belum ada data progres tahfidz.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
