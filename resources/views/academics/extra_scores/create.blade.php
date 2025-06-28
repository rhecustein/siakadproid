{{-- resources/views/academics/extra_scores/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Nilai Ekstrakurikuler</h1>
        <a href="{{ route('academic.grade-extracurriculars.index') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <form action="{{ route('academic.grade-extracurriculars.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Semester Selection --}}
                <div>
                    <label for="semester_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select id="semester_id" name="semester_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="" disabled selected>Pilih Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('semester_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Extracurricular Selection --}}
                <div>
                    <label for="extracurricular_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Ekstrakurikuler <span class="text-red-500">*</span>
                    </label>
                    <select id="extracurricular_id" name="extracurricular_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="" disabled selected>Pilih Ekstrakurikuler</option>
                        @foreach($extracurriculars as $extra)
                            <option value="{{ $extra->id }}" {{ old('extracurricular_id') == $extra->id ? 'selected' : '' }}>
                                {{ $extra->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('extracurricular_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Student Selection --}}
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Siswa <span class="text-red-500">*</span>
                    </label>
                    <select id="student_id" name="student_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Score Input --}}
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700 mb-2">
                        Nilai (0-100)
                    </label>
                    <div class="relative">
                        <input type="number" id="score" name="score" min="0" max="100" 
                               value="{{ old('score') }}" 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Masukkan nilai">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    @error('score')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            {{-- Note Input --}}
            <div class="mb-8">
                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan
                </label>
                <textarea id="note" name="note" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Tambahkan catatan (opsional)">{{ old('note') }}</textarea>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Simple validation to ensure score is between 0-100
    document.getElementById('score').addEventListener('change', function() {
        const score = parseInt(this.value);
        if (isNaN(score)) {
            this.value = '';
        } else if (score < 0) {
            this.value = 0;
        } else if (score > 100) {
            this.value = 100;
        }
    });
</script>
@endsection