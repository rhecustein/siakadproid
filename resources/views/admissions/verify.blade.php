@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-6">
    <h1 class="text-2xl font-bold mb-4">Verifikasi & Seleksi Pendaftar</h1>

    <!-- Data Siswa -->
    <div class="bg-gray-100 p-4 rounded">
        <h2 class="font-semibold mb-2">Data Pendaftar</h2>
        <p><strong>Nama:</strong> {{ $admission->name }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ $admission->birth_date }}</p>
        <p><strong>Telepon:</strong> {{ $admission->phone }}</p>
    </div>

    <!-- Berkas Upload -->
    <div>
        <h2 class="text-lg font-semibold mb-2">Berkas Terlampir</h2>
        @forelse ($admission->files as $file)
            <div class="flex items-center justify-between bg-gray-50 p-3 mb-2 border rounded">
                <span>{{ basename($file->file_path) }}</span>
                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-600 underline text-sm">Lihat</a>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada berkas diunggah.</p>
        @endforelse
    </div>

    <!-- Riwayat Status -->
    <div>
        <h2 class="text-lg font-semibold mb-2">Riwayat Status</h2>
        <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
            @forelse ($admission->statusLogs as $log)
                <li>
                    <strong>{{ $log->status }}</strong>
                    <span class="text-gray-500">({{ $log->created_at->format('d M Y H:i') }})</span>
                    @if($log->note)
                        - <em>{{ $log->note }}</em>
                    @endif
                </li>
            @empty
                <li>Belum ada status.</li>
            @endforelse
        </ul>
    </div>

    <!-- Tambah Status Baru -->
    <div>
        <h2 class="text-lg font-semibold mb-2">Tambah Status Seleksi</h2>
        <form action="{{ route('admission.admissions.status-log.store', $admission->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <select name="status" required class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Status</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Ditolak">Ditolak</option>
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Review Berkas">Review Berkas</option>
                </select>
            </div>
            <div>
                <textarea name="note" rows="3" class="w-full border rounded px-3 py-2" placeholder="Catatan opsional..."></textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
