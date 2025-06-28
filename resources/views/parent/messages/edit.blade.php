@extends('layouts.app')

@section('title', 'Edit Pesan')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Edit Pesan</h2>
        <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('messages.update', $message->id) }}" method="POST" class="space-y-6 bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <!-- Subjek -->
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject', $message->subject) }}" required class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Pesan -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Isi Pesan</label>
            <textarea name="message" id="message" rows="5" required class="w-full border-gray-300 rounded-md shadow-sm">{{ old('message', $message->message) }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
