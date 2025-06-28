@extends('layouts.app')

@section('title', 'Detail Kelas Paralel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📄 Detail Kelas Paralel</h1>
    </div>

    <div class="bg-white p-6 rounded shadow-md space-y-6">
        {{-- Jenjang --}}
        <div>
            <p class="text-sm text-gray-500">Jenjang</p>
            <p class="text-lg font-medium text-gray-800">
                {{ $assignment->gradeLevel->label ?? '-' }}
            </p>
        </div>

        {{-- Label Kelas --}}
        <div>
            <p class="text-sm text-gray-500">Label Paralel</p>
            <p class="text-lg font-semibold text-gray-900">
                {{ $assignment->name }}
            </p>
        </div>

        {{-- Wali Kelas --}}
        <div>
            <p class="text-sm text-gray-500">Wali Kelas</p>
            <p class="text-lg text-gray-800">
                {{ $assignment->homeroomTeacher->name ?? '-' }}
            </p>
        </div>

        {{-- Tanggal Dibuat & Diperbarui --}}
        <div class="text-sm text-gray-500">
            <p>Dibuat: {{ $assignment->created_at->format('d M Y, H:i') }}</p>
            <p>Diperbarui: {{ $assignment->updated_at->format('d M Y, H:i') }}</p>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('academic.classroom-assignments.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2">
                ← Kembali
            </a>
            <a href="{{ route('academic.classroom-assignments.edit', $assignment->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded">
                ✏️ Edit
            </a>
            <form method="POST" action="{{ route('academic.classroom-assignments.destroy', $assignment->id) }}"
                  onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
