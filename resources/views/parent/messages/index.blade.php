@extends('layouts.app')

@section('title', 'Kotak Masuk')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📥 Kotak Masuk Pesan</h2>
        <a href="{{ route('parent.messages.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-md hover:bg-sky-700 transition">
            ➕ Tulis Pesan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter dan Search -->
    <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari subjek / nama..." class="w-full sm:w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm">

        <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            <option value="">Semua Status</option>
            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">🔍 Filter</button>
    </form>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Anak</th>
                    <th class="px-4 py-2 text-left">Tujuan</th>
                    <th class="px-4 py-2 text-left">Subjek</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($messages as $message)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $message->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $message->student->name }}</td>
                        <td class="px-4 py-2">{{ $message->receiver->name }}</td>
                        <td class="px-4 py-2">{{ $message->subject }}</td>
                        <td class="px-4 py-2">
                            <span class="text-xs px-2 py-1 rounded {{ $message->status === 'unread' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('messages.show', $message->id) }}" class="text-sky-600 hover:underline text-sm">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Belum ada pesan terkirim.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
