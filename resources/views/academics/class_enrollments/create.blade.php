@extends('layouts.app')

@section('title', 'Penempatan Kelas Siswa')

@section('content')
<div class="max-w-8xl mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🧾 Penempatan Kelas Siswa</h1>

    <form id="enrollment-form" action="{{ route('academic.class-enrollments.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Sisi Kiri: Daftar Siswa --}}
            <div class="bg-white p-4 rounded shadow h-[500px] overflow-y-auto border">
                <h2 class="text-lg font-semibold mb-3">📋 Daftar Siswa</h2>
                <input type="text" placeholder="Cari siswa..." class="w-full mb-3 border px-3 py-2 rounded text-sm">

                @foreach($students as $student)
                    <div class="flex items-center space-x-2 mb-2">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                               id="student_{{ $student->id }}"
                               class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded student-checkbox">
                        <label for="student_{{ $student->id }}" class="text-sm text-gray-700">{{ $student->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- Tengah: Form Penempatan --}}
            <div class="bg-white p-6 rounded shadow border">
                <h2 class="text-lg font-semibold mb-4">📚 Form Penempatan</h2>

                {{-- Jenjang --}}
                <div class="mb-4">
                    <label for="level_id" class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                    <select name="level_id" id="level_id" required
                            class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kelas --}}
                <div class="mb-4">
                    <label for="grade_level_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="grade_level_id" id="grade_level_id" required
                            class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($gradeLevels as $gradeLevel)
                            <option value="{{ $gradeLevel->id }}">{{ $gradeLevel->label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Ruang Kelas --}}
                <div class="mb-4">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-1">Ruang Kelas</label>
                    <select name="classroom_id" id="classroom_id" required
                            class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                        <option value="">-- Pilih Ruang Kelas --</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Ajaran --}}
                <div class="mb-4">
                    <label for="academic_year_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <select name="academic_year_id" id="academic_year_id" required
                            class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Semester --}}
                <div class="mb-6">
                    <label for="semester_id" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester_id" id="semester_id"
                            class="w-full border-gray-300 rounded-md text-sm px-3 py-2">
                        <option value="">-- Pilih Semester --</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end">
                    <a href="{{ route('academic.class-enrollments.index') }}"
                       class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 text-sm font-semibold rounded-md shadow transition">
                        Simpan Penempatan
                    </button>
                </div>
            </div>

            {{-- Kanan: Preview Pilihan --}}
            <div class="bg-white p-4 rounded shadow h-[500px] overflow-y-auto border">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold">✅ Siswa Dipilih</h2>
                    <span id="count-selected" class="text-sm text-gray-500">(0 siswa)</span>
                </div>

                <div id="form-info" class="mb-4 text-sm text-gray-700 space-y-1">
                    <p><strong>Jenjang:</strong> <span id="info-level" class="text-gray-900">-</span></p>
                    <p><strong>Kelas:</strong> <span id="info-grade" class="text-gray-900">-</span></p>
                    <p><strong>Ruang Kelas:</strong> <span id="info-classroom" class="text-gray-900">-</span></p>
                    <p><strong>Tahun Ajaran:</strong> <span id="info-academic-year" class="text-gray-900">-</span></p>
                    <p><strong>Semester:</strong> <span id="info-semester" class="text-gray-900">-</span></p>
                </div>

                <div id="selected-list" class="space-y-2">
                    <div class="text-sm text-gray-400 italic">Belum ada yang dipilih</div>
                </div>
            </div>
        </div>
    </form>

    {{-- Overlay loading --}}
    <div id="loading-overlay" class="fixed inset-0 bg-white bg-opacity-80 z-50 hidden flex items-center justify-center">
        <div class="text-center">
            <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <p class="text-sm font-medium text-gray-700">Menyimpan penempatan siswa...</p>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const list = document.getElementById('selected-list');
    const count = document.getElementById('count-selected');

    const levelSelect = document.getElementById('level_id');
    const gradeLevelSelect = document.getElementById('grade_level_id');
    const classroomSelect = document.getElementById('classroom_id');
    const academicYearSelect = document.getElementById('academic_year_id');
    const semesterSelect = document.getElementById('semester_id');

    const infoLevel = document.getElementById('info-level');
    const infoGrade = document.getElementById('info-grade');
    const infoClassroom = document.getElementById('info-classroom');
    const infoAcademicYear = document.getElementById('info-academic-year');
    const infoSemester = document.getElementById('info-semester');

    function updateList() {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => ({
                id: cb.value,
                name: cb.nextElementSibling.textContent.trim()
            }));

        if (selected.length === 0) {
            list.innerHTML = `<div class="text-sm text-gray-400 italic">Belum ada yang dipilih</div>`;
            count.textContent = `(0 siswa)`;
        } else {
            list.innerHTML = selected.map((s, i) => `
                <div class="bg-green-50 border border-green-200 rounded px-3 py-2 text-sm flex items-center gap-2">
                    <span class="text-green-600 font-semibold">${i + 1}.</span>
                    <span class="text-gray-800">${s.name}</span>
                </div>
            `).join('');
            count.textContent = `(${selected.length} siswa)`;
        }
    }

    function updateFormInfo() {
        infoLevel.textContent = levelSelect.selectedOptions[0]?.text || '-';
        infoGrade.textContent = gradeLevelSelect.selectedOptions[0]?.text || '-';
        infoClassroom.textContent = classroomSelect.selectedOptions[0]?.text || '-';
        infoAcademicYear.textContent = academicYearSelect.selectedOptions[0]?.text || '-';
        infoSemester.textContent = semesterSelect.selectedOptions[0]?.text || '-';
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateList));
    [levelSelect, gradeLevelSelect, classroomSelect, academicYearSelect, semesterSelect]
        .forEach(select => select.addEventListener('change', updateFormInfo));

    document.addEventListener('DOMContentLoaded', function () {
        updateList();
        updateFormInfo();

        const form = document.getElementById('enrollment-form');
        const overlay = document.getElementById('loading-overlay');

        form.addEventListener('submit', function () {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        });
    });
</script>
@endsection
