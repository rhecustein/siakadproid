@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pendaftar</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admission.admissions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Pendaftaran
    </a>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-2">Nama</th>
                    <th class="text-left px-4 py-2">Tgl Lahir</th>
                    <th class="text-left px-4 py-2">Telepon</th>
                    <th class="text-left px-4 py-2">Status Terakhir</th>
                    <th class="text-left px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $admission)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $admission->name }}</td>
                        <td class="px-4 py-2">{{ $admission->birth_date }}</td>
                        <td class="px-4 py-2">{{ $admission->phone }}</td>
                        <td class="px-4 py-2">
                            {{ optional($admission->statusLogs->last())->status ?? 'Belum Diverifikasi' }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admission.admissions.show', $admission->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            <a href="{{ route('admission.admissions.verify', $admission->id) }}" class="text-green-600 hover:underline">Verifikasi</a>
                            <a href="{{ route('admission.admissions.payment.form', $admission->id) }}" class="text-indigo-600 hover:underline">Pembayaran</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada pendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
