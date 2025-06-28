@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Jadwal Pendaftaran</h1>

    <a href="{{ route('admission-schedules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Jadwal
    </a>

    <table class="w-full mt-4 bg-white border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Nama Jadwal</th>
                <th class="px-4 py-2 text-left">Mulai</th>
                <th class="px-4 py-2 text-left">Selesai</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $schedule->name }}</td>
                    <td class="px-4 py-2">{{ $schedule->start_date }}</td>
                    <td class="px-4 py-2">{{ $schedule->end_date }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admission-schedules.edit', $schedule->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admission-schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">Belum ada jadwal.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
