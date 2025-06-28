@extends('layouts.app')

@section('title', 'Riwayat Kehadiran')

@section('content')
<div class="container mx-auto p-4">

    {{-- Header Profil --}}
    <div class="bg-white shadow rounded p-6 flex gap-6 items-center mb-6">
        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xl">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-600">Role: {{ ucfirst($user->role ?? '-') }}</p>
            <p class="text-gray-600">Unit: {{ $user->unit->name ?? '-' }}</p>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach(['hadir', 'izin', 'sakit', 'alfa'] as $status)
            <div class="bg-gray-100 p-4 rounded text-center">
                <div class="text-sm text-gray-500">{{ ucfirst($status) }}</div>
                <div class="text-2xl font-bold">
                    {{ $attendanceStats[$status] ?? 0 }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Waktu</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Device</th>
                    <th class="px-4 py-2 border">Manual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr class="text-sm">
                        <td class="px-4 py-2 border">{{ $att->date }}</td>
                        <td class="px-4 py-2 border">{{ $att->time }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($att->type) }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($att->status) }}</td>
                        <td class="px-4 py-2 border">{{ $att->device ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            @if($att->is_manual)
                                <span class="text-red-500 text-xs">Manual</span>
                            @else
                                <span class="text-green-600 text-xs">Otomatis</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">Belum ada data kehadiran.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $attendances->links() }}
        </div>
    </div>

</div>
@endsection
