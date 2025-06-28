@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-blue-700">Penugasan Wali Kelas</h2>
        <p class="text-sm text-gray-500">Daftar wali kelas yang sudah ditetapkan per tahun ajaran dan kelas.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('academic.teachers.index') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
            < Daftar Guru </a> <a href="{{ route('academic.homeroom.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                + Tetapkan Wali Kelas
        </a>
    </div>
</div>
@if (session('success'))
<div
    class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
    <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Tahun Ajaran</th>
                <th class="px-6 py-3">Kelas</th>
                <th class="px-6 py-3">Wali Kelas</th>
                <th class="px-6 py-3">Ditugaskan</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($assignments as $index => $assignment)
            <tr class="hover:bg-blue-50 transition">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                <td class="px-6 py-3">{{ $assignment->academicYear->year ?? '—' }}</td>
                <td class="px-6 py-3">{{ $assignment->classroom->name ?? '—' }}</td>
                <td class="px-6 py-3">{{ $assignment->teacher->name ?? '—' }}</td>
                <td class="px-6 py-3">
                    {{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->translatedFormat('d M Y') : '—' }}
                </td>
                <td class="px-6 py-3">
                    @if ($assignment->is_active)
                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
                    @else
                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
                    <a href="{{ route('academic.homeroom.edit', $assignment->id) }}"
                        class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                        Edit
                    </a>
                    <form action="{{ route('academic.homeroom.destroy', $assignment->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus penugasan wali kelas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data wali kelas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
