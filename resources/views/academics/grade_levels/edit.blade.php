@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <div class="mb-8 text-center">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                Edit Kelas
            </h1>
            <p class="text-gray-600 text-base">Perbarui informasi kelas di bawah ini.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
                <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <strong class="font-semibold">Terjadi beberapa kesalahan:</strong>
                    <ul class="list-disc ml-5 mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('academic.grade-levels.update', $gradeLevel->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="level_id" class="block text-sm font-semibold text-gray-700 mb-2">Jenjang / Level <span class="text-red-500">*</span></label>
                <select name="level_id" id="level_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                        required>
                    <option value="">-- Pilih Jenjang --</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $gradeLevel->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }} ({{ $level->slug }})
                        </option>
                    @endforeach
                </select>
                @error('level_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="grade" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kelas (Grade) <span class="text-red-500">*</span></label>
                    <input type="number" name="grade" id="grade"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                           value="{{ old('grade', $gradeLevel->grade) }}" min="1" max="20" required placeholder="Contoh: 7 (Untuk kelas 7)">
                    @error('grade') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="label" class="block text-sm font-semibold text-gray-700 mb-2">Label / Kode <span class="text-red-500">*</span></label>
                    <input type="text" name="label" id="label"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                           value="{{ old('label', $gradeLevel->label) }}" required placeholder="Contoh: 7A, 7B, X-IPA">
                    @error('label') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                          placeholder="Deskripsi tambahan tentang kelas ini...">{{ old('description', $gradeLevel->description) }}</textarea>
                @error('description') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition duration-150 ease-in-out"
                       {{ old('is_active', $gradeLevel->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-base text-gray-700 select-none">Aktif</label>
                @error('is_active') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('academic.grade-levels.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Kelas
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-base font-semibold shadow-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-2-4l-4-4m0 0L8 7m4-4v3m0-3c1.333-1.333 3.333-1.333 4.667 0"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection