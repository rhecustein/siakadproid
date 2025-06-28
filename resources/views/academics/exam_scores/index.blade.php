@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-semibold mb-4">Pendataan Nilai Ekstrakurikuler</h2>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('academic.extra-scores.index') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="semester_id" class="border rounded px-3 py-2">
                <option value="">-- Semua Semester --</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                        {{ $semester->name }}
                    </option>
                @endforeach
            </select>

            <select name="extracurricular_id" class="border rounded px-3 py-2">
                <option value="">-- Semua Ekstrakurikuler --</option>
                @foreach ($extracurriculars as $extra)
                    <option value="{{ $extra->id }}" {{ request('extracurricular_id') == $extra->id ? 'selected' : '' }}>
                        {{ $extra->name }}
                    </option>
                @endforeach
            </select>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>

    {{-- Tambah Nilai --}}
    <div class="mb-4">
        <a href="{{ route('academic.extra-scores.create') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Tambah Nilai
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border">Siswa</th>
                    <th class="px-4 py-3 border">Ekstrakurikuler</th>
                    <th class="px-4 py-3 border">Semester</th>
                    <th class="px-4 py-3 border">Nilai</th>
                    <th class="px-4 py-3 border">Catatan</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($scores as $score)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $score->student->name }}</td>
                        <td class="px-4 py-2 border">{{ $score->extracurricular->name }}</td>
                        <td class="px-4 py-2 border">{{ $score->semester->name }}</td>
                        <td class="px-4 py-2 border">{{ $score->score ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $score->note ?? '-' }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('academic.extra-scores.edit', $score->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('academic.extra-scores.destroy', $score->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data nilai ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
