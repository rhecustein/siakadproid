@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Level Pendidikan</h1>
        <a href="{{ route('academic.levels.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Tambah Level
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
                    <th class="p-3">Nama</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3 text-center">Kelas</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($levels as $level)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($levels->currentPage() - 1) * $levels->perPage() }}</td>
                    <td class="p-3 font-semibold">{{ $level->name }}</td>
                    <td class="p-3 text-gray-700">{{ $level->slug }}</td>
                    <td class="p-3 capitalize">{{ $level->type ?? '-' }}</td>
                    <td class="p-3 text-center">
                        {{ $level->min_grade ?? '-' }} - {{ $level->max_grade ?? '-' }}
                    </td>
                    <td class="p-3">
                        <span class="inline-block px-2 py-1 text-xs rounded
                            {{ $level->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                            {{ $level->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('academic.levels.edit', $level->id) }}"
                           class="text-blue-600 hover:underline text-sm">Edit</a>

                        <form action="{{ route('academic.levels.destroy', $level->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus level ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data level.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $levels->withQueryString()->links() }}
    </div>
</div>
@endsection
