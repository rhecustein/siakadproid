@extends('layouts.app')

@section('title', 'Edit Kelas Paralel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Kelas Paralel</h1>
    </div>

    <form method="POST" action="{{ route('academic.classroom-assignments.update', $assignment->id) }}" class="bg-white p-6 rounded shadow-md space-y-6">
        @csrf
        @method('PUT')

        {{-- Jenjang --}}
        <div>
            <label for="grade_level_id" class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
            <select name="grade_level_id" id="grade_level_id" required
                    class="w-full border-gray-300 rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Jenjang --</option>
                @foreach($gradeLevels as $level)
                    <option value="{{ $level->id }}" {{ $assignment->grade_level_id == $level->id ? 'selected' : '' }}>
                        {{ $level->label }}
                    </option>
                @endforeach
            </select>
            @error('grade_level_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Label Paralel --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Label Kelas</label>
            <input type="text" name="name" id="name" value="{{ old('name', $assignment->name) }}" required
                   class="w-full border-gray-300 rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Wali Kelas --}}
        <div>
            <label for="homeroom_teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
            <select name="homeroom_teacher_id" id="homeroom_teacher_id"
                    class="w-full border-gray-300 rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Wali Kelas --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $assignment->homeroom_teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            @error('homeroom_teacher_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('academic.classroom-assignments.index') }}"
               class="inline-block text-gray-600 hover:text-gray-900 text-sm px-4 py-2">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2 rounded shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
