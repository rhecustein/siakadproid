@extends('layouts.app')

@section('title', 'Tambah Kelas Paralel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">➕ Tambah Kelas Paralel</h1>

    <form method="POST" action="{{ route('academic.classroom-assignments.store') }}"
          class="bg-white p-6 rounded shadow space-y-6">
        @csrf

        {{-- Jenjang --}}
        <div>
            <label for="grade_level_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="grade_level_id" id="grade_level_id" required
                    class="w-full border-gray-300 rounded px-3 py-2 text-sm">
                <option value="">-- Pilih Kelas --</option>
                @foreach($gradeLevels as $level)
                    <option value="{{ $level->id }}" {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                        {{ $level->label }}
                    </option>
                @endforeach
            </select>
            @error('grade_level_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Entri Penempatan --}}
        <div>
            <label for="class_enrollments_id" class="block text-sm font-medium text-gray-700 mb-1">
                Entri Penempatan Siswa
            </label>
            <select name="class_enrollments_id" id="class_enrollments_id" required
                    class="w-full border-gray-300 rounded px-3 py-2 text-sm">
                <option value="">-- Pilih Entri --</option>
                @foreach($classEnrollments as $enroll)
                    <option value="{{ $enroll->id }}" {{ old('class_enrollments_id') == $enroll->id ? 'selected' : '' }}>
                        ID #{{ $enroll->id }} - {{ $enroll->academicYear->year ?? '' }} / {{ $enroll->semester->name ?? '' }}
                    </option>
                @endforeach
            </select>
            @error('class_enrollments_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ruangan --}}
        <div>
            <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-1">Ruang Kelas</label>
            <select name="classroom_id" id="classroom_id" required
                    class="w-full border-gray-300 rounded px-3 py-2 text-sm">
                <option value="">-- Pilih Ruangan --</option>
                @foreach($classrooms as $room)
                    <option value="{{ $room->id }}" {{ old('classroom_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
            @error('classroom_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Label Paralel --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Label Kelas (contoh: A, B)</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full border-gray-300 rounded px-3 py-2 text-sm">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Wali Kelas --}}
        <div>
            <label for="homeroom_teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
            <select name="homeroom_teacher_id" id="homeroom_teacher_id"
                    class="w-full border-gray-300 rounded px-3 py-2 text-sm">
                <option value="">-- Pilih Guru (opsional) --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id') == $teacher->id ? 'selected' : '' }}>
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
               class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded shadow">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
