@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Kehadiran</h1>
        <a href="{{ route('core.attendances.manual-input') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Absensi Manual</a>
    </div>

    {{-- FILTER FORM --}}
    <form method="GET" action="{{ route('core.attendances.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input type="text" name="search" placeholder="Cari nama atau NIS..." value="{{ request('search') }}"
            class="border px-3 py-2 rounded w-full" />

        <input type="date" name="date" value="{{ request('date') }}" class="border px-3 py-2 rounded w-full" />

        <select name="type" class="border px-3 py-2 rounded w-full">
            <option value="">-- Tipe --</option>
            <option value="masuk" @selected(request('type') === 'masuk')>Masuk</option>
            <option value="pulang" @selected(request('type') === 'pulang')>Pulang</option>
        </select>

        <select name="role_type" class="border px-3 py-2 rounded w-full">
            <option value="">-- Role --</option>
            <option value="siswa" @selected(request('role_type') === 'siswa')>Siswa</option>
            <option value="guru" @selected(request('role_type') === 'guru')>Guru</option>
            <option value="staff" @selected(request('role_type') === 'staff')>Staff</option>
        </select>

        <select name="status" class="border px-3 py-2 rounded w-full">
            <option value="">-- Status --</option>
            @foreach(['hadir','izin','sakit','alfa'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        <a href="{{ route('core.attendances.index') }}" class="text-gray-600 underline self-center">Reset</a>
    </form>

    {{-- TOMBOL EKSTRA --}}
    <div class="flex gap-4 mb-4">
        <button class="bg-gray-200 px-3 py-1 rounded text-sm hover:bg-gray-300">Export Excel</button>
        <button class="bg-gray-200 px-3 py-1 rounded text-sm hover:bg-gray-300">Export PDF</button>
    </div>

    {{-- TABEL ABSENSI --}}
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Unit</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Waktu</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Device</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $item)
                <tr class="text-sm">
                    <td class="px-4 py-2 border">{{ $item->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($item->role_type) }}</td>
                    <td class="px-4 py-2 border">{{ $item->unit->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $item->date }}</td>
                    <td class="px-4 py-2 border">{{ $item->time }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($item->type) }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($item->status) }}</td>
                    <td class="px-4 py-2 border">{{ $item->device ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        <a href="#" class="text-blue-600 hover:underline text-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">Tidak ada data ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $attendances->links() }}
        </div>
    </div>

    {{-- DEVICE STATUS --}}
    <div class="mt-8">
        <h2 class="text-lg font-bold mb-2">Status Perangkat Absensi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Placeholder - bisa diisi realtime status device --}}
            <div class="border p-4 rounded shadow">
                <p class="font-semibold">Fingerprint Kantin</p>
                <p>Status: <span class="text-green-600 font-bold">Online</span></p>
                <p>Lokasi: Kantin Utama</p>
            </div>
            <div class="border p-4 rounded shadow">
                <p class="font-semibold">Fingerprint Kelas 9A</p>
                <p>Status: <span class="text-red-600 font-bold">Offline</span></p>
                <p>Lokasi: Gedung A Lt 2</p>
            </div>
        </div>
    </div>

</div>
@endsection
