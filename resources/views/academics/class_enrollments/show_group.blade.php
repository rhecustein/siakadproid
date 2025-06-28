@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 mb-1">📋 Daftar Siswa dalam Penempatan</h1>
            <p class="text-sm text-gray-600">
                Jenjang: <strong>{{ $data->first()?->gradeLevel->name ?? '-' }}</strong> |
                Kelas: <strong>{{ $data->first()?->classroom->name ?? '-' }}</strong> |
                Tahun Ajaran: <strong>{{ $data->first()?->academicYear->name ?? '-' }}</strong> |
                Semester: <strong>{{ $data->first()?->semester->name ?? '-' }}</strong>
            </p>
        </div>
        <a href="{{ route('academic.class-enrollments.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium px-4 py-2 rounded">
            ← Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Siswa</th>
                    <th class="px-4 py-2">NIS / ID</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $i => $item)
                    <tr>
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">{{ $item->student->name }}</td>
                        <td class="px-4 py-2">{{ $item->student->nis ?? '-' }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <form action="{{ route('academic.class-enrollments.destroy', $item->id) }}"
                                  method="POST" class="inline" onsubmit="return confirm('Hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada siswa dalam grup ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
