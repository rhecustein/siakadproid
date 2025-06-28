@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Verifikasi Pendaftar</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Telepon</th>
                    <th class="px-4 py-2 text-left">Status Terakhir</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admissions as $admission)
                    @php
                        $latestStatus = optional($admission->statusLogs->last())->status;
                    @endphp
                    @if (!$latestStatus || in_array($latestStatus, ['Menunggu Verifikasi', 'Review Berkas']))
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $admission->name }}</td>
                        <td class="px-4 py-2">{{ $admission->phone }}</td>
                        <td class="px-4 py-2">{{ $latestStatus ?? 'Belum Diverifikasi' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admission.admissions.verify', $admission->id) }}" class="text-blue-600 hover:underline">
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data pendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
