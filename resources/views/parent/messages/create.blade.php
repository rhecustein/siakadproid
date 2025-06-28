@extends('layouts.app')

@section('title', 'Kirim Pesan ke Wali Kelas')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">💬 Kirim Pesan ke Wali Kelas</h2>
        <a href="{{ route('parent.messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('parent.messages.store') }}" method="POST" class="space-y-6 bg-white shadow-md rounded-lg p-6">
        @csrf

        <!-- Anak yang Mengirim -->
        <div>
            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Anak</label>
            <select name="student_id" id="student_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                @foreach ($children as $child)
                    <option value="{{ $child->id }}">{{ $child->name }} ({{ $child->grade->name ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <!-- Tujuan (Wali Kelas) -->
        <div>
            <label for="receiver_id" class="block text-sm font-medium text-gray-700 mb-1">Tujuan (Wali Kelas)</label>
            <select name="receiver_id" id="receiver_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }} - {{ $teacher->email }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subjek -->
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
            <input type="text" name="subject" id="subject" required class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Pesan -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Isi Pesan</label>
            <textarea name="message" id="message" rows="5" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-sky-600 text-white text-sm rounded-md hover:bg-sky-700">Kirim Pesan</button>
        </div>
    </form>
</div>
@endsection
