@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kelas (Grade Levels)</h1>
        <a href="{{ route('academic.grade-levels.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Tambah Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Level</th>
                    <th class="p-3">Grade</th>
                    <th class="p-3">Label</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gradeLevels as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration + ($gradeLevels->currentPage() - 1) * $gradeLevels->perPage() }}</td>
                        <td class="p-3">{{ $item->level->name ?? '-' }}</td>
                        <td class="p-3">{{ $item->grade }}</td>
                        <td class="p-3 font-semibold">{{ $item->label }}</td>
                        <td class="p-3">{{ $item->description ?? '-' }}</td>
                        <td class="p-3">
                            <span class="inline-block px-2 py-1 text-xs rounded
                                {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('academic.grade-levels.edit', $item->id) }}"
                               class="text-blue-600 hover:underline text-sm">Edit</a>

                            <form action="{{ route('academic.grade-levels.destroy', $item->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $gradeLevels->withQueryString()->links() }}
    </div>
</div>
@endsection
