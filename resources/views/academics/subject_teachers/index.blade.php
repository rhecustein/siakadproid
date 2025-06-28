@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Pengampu Mata Pelajaran</h2>
    <p class="text-sm text-gray-500">Kelola guru pengampu untuk tiap kelas dan mata pelajaran.</p>
  </div>

  {{-- Form Tambah/Update --}}
  <form action="{{ route('academic.subject-teachers.store') }}" method="POST" class="mb-6 bg-white shadow p-4 rounded space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Kelas</label>
        <select name="classroom_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih Kelas</option>
          @foreach(App\Models\Classroom::all() as $classroom)
            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
        <select name="subject_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih Mapel</option>
          @foreach(App\Models\Subject::all() as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Guru Pengampu</label>
        <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm" required>
          <option value="">Pilih Guru</option>
          @foreach(App\Models\Teacher::all() as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="text-right">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
        Simpan Pengampu
      </button>
    </div>
  </form>

  {{-- Tabel Data Pengampu --}}
  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600">
        <tr>
          <th class="px-4 py-2 text-left">Kelas</th>
          <th class="px-4 py-2 text-left">Mata Pelajaran</th>
          <th class="px-4 py-2 text-left">Guru Pengampu</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @forelse($data as $item)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $item->classroom->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $item->subject->name ?? '-' }}</td>
          <td class="px-4 py-2">{{ $item->teacher->name ?? '-' }}</td>
          <td class="px-4 py-2">
            <form action="{{ route('academic.subject-teachers.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data pengampu.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
