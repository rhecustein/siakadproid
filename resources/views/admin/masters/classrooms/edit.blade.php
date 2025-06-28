@extends('layouts.app')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

        <div class="mb-8 text-center">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                Edit Ruangan Kelas
            </h1>
            <p class="text-gray-600 text-base">Perbarui informasi ruangan kelas seperti nama, jenjang, atau ruangan fisik.</p>
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

        <form action="{{ route('academic.classrooms.update', $classroom->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Ruangan Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                       value="{{ old('name', $classroom->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                       placeholder="Contoh: Kelas 7A, X-IPA">
                @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="alias" class="block text-sm font-semibold text-gray-700 mb-2">Alias (Opsional)</label>
                <input type="text" name="alias" id="alias"
                       value="{{ old('alias', $classroom->alias) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                       placeholder="Nama pendek atau kode kelas">
                @error('alias') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="room_id" class="block text-sm font-semibold text-gray-700 mb-2">Ruangan Fisik <span class="text-red-500">*</span></label>
                <select name="room_id" id="room_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="">— Pilih Ruangan Fisik —</option>
                    @foreach ($rooms as $r) {{-- Assuming $rooms is passed from controller, for physical rooms --}}
                        <option value="{{ $r->id }}" {{ old('room_id', $classroom->room_id) == $r->id ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
                @error('room_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="level_id" class="block text-sm font-semibold text-gray-700 mb-2">Jenjang <span class="text-red-500">*</span></label>
                <select name="level_id" id="level_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="">— Pilih Jenjang —</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $classroom->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('level_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="grade_level_id" class="block text-sm font-semibold text-gray-700 mb-2">Tingkat Kelas <span class="text-red-500">*</span></label>
                <select name="grade_level_id" id="grade_level_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="">— Pilih Tingkat —</option>
                    @foreach ($gradeLevels as $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_level_id', $classroom->grade_level_id) == $grade->id ? 'selected' : '' }}>
                            {{ $grade->label }}
                        </option>
                    @endforeach
                </select>
                @error('grade_level_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="academic_year_id" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                <select name="academic_year_id" id="academic_year_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="">— Pilih Tahun Ajaran —</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id) == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="curriculum_id" class="block text-sm font-semibold text-gray-700 mb-2">Kurikulum <span class="text-red-500">*</span></label>
                <select name="curriculum_id" id="curriculum_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="">— Pilih Kurikulum —</option>
                    @foreach ($curriculums as $curriculum)
                        <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $classroom->curriculum_id) == $curriculum->id ? 'selected' : '' }}>
                            {{ $curriculum->name }}
                        </option>
                    @endforeach
                </select>
                @error('curriculum_id') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                <input type="number" name="order" id="order"
                       value="{{ old('order', $classroom->order) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm placeholder-gray-400
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                       placeholder="Urutan tampilan">
                @error('order') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">Status Aktif <span class="text-red-500">*</span></label>
                <select name="is_active" id="is_active" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base shadow-sm appearance-none bg-white pr-8
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                    <option value="1" {{ old('is_active', $classroom->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $classroom->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('is_active') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('academic.classrooms.index') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 hover:underline mb-4 sm:mb-0 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Ruangan Kelas
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-base font-semibold shadow-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-2-4l-4-4m0 0L8 7m4-4v3m0-3c1.333-1.333 3.333-1.333 4.667 0"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2m-2 4h2m-4 0h2"></path></svg>
                    Perbarui Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection