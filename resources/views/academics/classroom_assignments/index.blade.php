@extends('layouts.app')

@section('title', 'Kelas Paralel')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">🧩 Daftar Kelas Paralel</h1>
        <a href="{{ route('academic.classroom-assignments.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-medium rounded shadow">
            + Tambah Kelas Paralel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Jenjang</th>
                    <th class="px-4 py-3 text-left">Label Kelas</th>
                    <th class="px-4 py-3 text-left">Wali Kelas</th>
                    <th class="px-4 py-3 text-left">Ruang</th>
                    <th class="px-4 py-3 text-left">Entri Penempatan</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($assignments as $assignment)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration + ($assignments->currentPage() - 1) * $assignments->perPage() }}</td>
                        <td class="px-4 py-2">{{ $assignment->gradeLevel->label ?? '-' }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $assignment->name }}</td>
                        <td class="px-4 py-2">{{ $assignment->homeroomTeacher->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $assignment->classroom->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            ID: {{ $assignment->class_enrollments_id }}
                        </td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('academic.classroom-assignments.show', $assignment->id) }}"
                               class="text-blue-600 hover:underline text-sm">Lihat</a>
                            <a href="{{ route('academic.classroom-assignments.edit', $assignment->id) }}"
                               class="text-yellow-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('academic.classroom-assignments.destroy', $assignment->id) }}"
                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                            Belum ada data kelas paralel.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
