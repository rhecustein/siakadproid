@extends('layouts.app')

@section('title', 'Penilaian Harian')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📘 Penilaian Harian</h1>
        <a href="{{ route('academic.daily-assessments.create') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            + Tambah Penilaian
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-md shadow-md">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Siswa</th>
                    <th class="px-4 py-3">Pelajaran</th>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Guru</th>
                    <th class="px-4 py-3">Nilai</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessments as $index => $assessment)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($assessment->date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $assessment->student->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $assessment->subject->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $assessment->classroom->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $assessment->teacher->name ?? '-' }}</td>
                        <td class="px-4 py-2 font-semibold text-blue-700">{{ $assessment->score ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('assessments.show', $assessment->id) }}"
                               class="text-indigo-600 hover:underline text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                            Belum ada data penilaian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assessments->links() }}
    </div>
</div>
@endsection
