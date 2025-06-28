@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Penempatan Kelas Siswa</h1>
        <a href="{{ route('academic.class-enrollments.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
            + Tambah Penempatan
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow rounded p-4 border">
            <h2 class="text-sm text-gray-500 mb-1">Total Siswa</h2>
            <p class="text-xl font-bold text-gray-800">{{ number_format($totalStudents) }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 border">
            <h2 class="text-sm text-gray-500 mb-1">Sudah Ditempatkan</h2>
            <p class="text-xl font-bold text-green-600">{{ number_format($enrolledCount) }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 border">
            <h2 class="text-sm text-gray-500 mb-1">Belum Ditempatkan</h2>
            <p class="text-xl font-bold text-red-600">{{ number_format($notEnrolledCount) }}</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" class="w-full bg-white p-4 rounded-md shadow mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-full md:w-1/4">
                <label for="academic_year_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select name="academic_year_id" id="academic_year_id"
                        class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Tahun Ajaran --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/4">
                <label for="semester_id" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester_id" id="semester_id"
                        class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Semester --</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/4">
                <label for="level_id" class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                <select name="level_id" id="level_id"
                        class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="">-- Jenjang --</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-1 md:mt-6">
                <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Jenjang</th>
                    <th class="px-4 py-2">Kelas</th>
                    <th class="px-4 py-2">Ruang Kelas</th>
                    <th class="px-4 py-2">Tahun Ajaran</th>
                    <th class="px-4 py-2">Semester</th>
                    <th class="px-4 py-2">Jumlah Siswa</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($enrollments as $key => $group)
                    @php
                        $first = $group->firstWhere(fn($e) =>
                            $e->level && $e->gradeLevel && $e->classroom && $e->academicYear && $e->semester
                        ) ?? $group->first();
                    @endphp
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $first->level->name }}</td>
                        <td class="px-4 py-2">{{ $first->gradeLevel->label ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $first->classroom->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $first->academicYear->year ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $first->semester->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $group->count() }} siswa</td>
                        <td class="px-4 py-2">
                            <a href="{{ url("academic/class-enrollments/group/{$first->level_id}/{$first->grade_level_id}/{$first->classroom_id}/{$first->academic_year_id}/{$first->semester_id}") }}">
    Lihat Siswa
</a>          </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada data penempatan kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
