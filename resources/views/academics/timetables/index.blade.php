@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Jadwal Pelajaran Semua Kelas</h1>

    {{-- Filter --}}
    <form method="GET" action="{{ route('academic.timetables.index') }}" class="grid md:grid-cols-3 gap-4 mb-6">
        <div>
            <label class="block font-medium">Pilih Sekolah:</label>
            <select name="school_id" class="w-full border rounded px-3 py-2">
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium">Tahun Ajaran:</label>
            <select name="academic_year_id" class="w-full border rounded px-3 py-2">
                @foreach ($academic_years as $year)
                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tampilkan</button>
        </div>
    </form>

    {{-- Tabel Jadwal --}}
    <div class="overflow-auto border rounded bg-white">
        <table class="w-full text-xs text-center">
         <thead>
    <tr>
        <th rowspan="2" class="border">Hari</th>
        <th rowspan="2" class="border">Jam Ke</th>
        <th rowspan="2" class="border">Waktu</th>
        @foreach ($gradeLevels as $grade)
            <th colspan="{{ $grade->classrooms->count() }}" class="border font-bold">{{ $grade->label }}</th>
        @endforeach
    </tr>
    <tr>
        @foreach ($gradeLevels as $grade)
            @foreach ($grade->classrooms as $classroom)
                <th class="border">{{ $classroom->name }}</th>
            @endforeach
        @endforeach
    </tr>
</thead>
           <tbody>
    @foreach ($days as $day)
        @php $jam_ke = 1; @endphp
        @foreach ($lesson_times as $slot)
            <tr>
                @if ($loop->first)
                    <td rowspan="{{ $lesson_times->count() }}" class="border align-top font-semibold">{{ $day }}</td>
                @endif
                <td class="border">{{ $jam_ke }}</td>
                <td class="border">{{ $slot->start_time }}<br>–<br>{{ $slot->end_time }}</td>

                @foreach ($gradeLevels as $grade)
                    @foreach ($grade->classrooms as $classroom)
                        @php
                            $data = $timetables->firstWhere(fn($t) =>
                                $t->classroom_id == $classroom->id &&
                                $t->day == $day &&
                                $t->lesson_time_id == $slot->id
                            );
                        @endphp
                        <td class="border px-2 py-1 text-left cursor-pointer hover:bg-blue-50"
                            onclick="openModal('{{ $day }}', '{{ $classroom->id }}', '{{ $slot->id }}')">
                            @if ($data)
                                <div class="font-semibold text-xs">{{ $data->subject->short_name ?? $data->subject->name }}</div>
                                <div class="text-[10px] text-gray-600">{{ $data->teacher->short_name ?? $data->teacher->name }}</div>
                                <div class="text-[10px] italic text-blue-600">{{ $data->room->name ?? '' }}</div>
                            @else
                                <span class="text-gray-400 text-xs italic">+ Tambah</span>
                            @endif
                        </td>
                    @endforeach
                @endforeach
            </tr>
            @php $jam_ke++; @endphp
        @endforeach
    @endforeach
</tbody>

        </table>
    </div>
</div>

{{-- Modal Tambah Jadwal --}}
<div id="timetableModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-6 space-y-6 relative">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">🗓️ Tambah Jadwal Pelajaran</h2>

        <form method="POST" action="{{ route('academic.timetables.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="day" id="modalDay">
            <input type="hidden" name="lesson_time_id" id="modalLessonTimeId">

            {{-- Info Jadwal --}}
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium">Kelas (Paralel):</label>
                    <select name="classroom_ids[]" class="w-full border border-gray-300 rounded-lg px-3 py-2" multiple>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium">Hari:</label>
                    <input type="text" id="modalDayDisplay" class="w-full bg-gray-100 border rounded-lg px-3 py-2" readonly>
                </div>
                <div>
                    <label class="text-sm font-medium">Jam Ke:</label>
                    <input type="text" id="modalOrderDisplay" class="w-full bg-gray-100 border rounded-lg px-3 py-2" readonly>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Waktu:</label>
                    <input type="text" id="modalTimeDisplay" class="w-full bg-gray-100 border rounded-lg px-3 py-2" readonly>
                </div>
                <div>
                    <label class="text-sm font-medium">Ruangan:</label>
                    <select name="room_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Mata Pelajaran & Guru --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Mata Pelajaran:</label>
                    <select name="subject_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium">Guru:</label>
                    <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Checkbox Options --}}
            <div class="grid grid-cols-2 gap-4 items-center mt-2">
                <div class="flex flex-col gap-2">
                    <label class="inline-flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="is_combined" class="rounded border-gray-300">
                        <span>Kelas Gabungan</span>
                    </label>
                    <label class="inline-flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="is_start" checked class="rounded border-gray-300">
                        <span>Sesi Mulai</span>
                    </label>
                    <label class="inline-flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="is_end" checked class="rounded border-gray-300">
                        <span>Sesi Selesai</span>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeModal()" class="text-sm px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">Batal</button>
                <button type="submit" class="text-sm px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">💾 Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>


{{-- Script --}}
<script>
    const lessonTimes = @json($lesson_times->keyBy('id'));

    function openModal(day, classroomId, lessonTimeId) {
        const slot = lessonTimes[lessonTimeId];

        document.getElementById('modalDay').value = day;
        document.getElementById('modalLessonTimeId').value = lessonTimeId;
        document.getElementById('modalDayDisplay').value = day;
        document.getElementById('modalOrderDisplay').value = slot.order;
        document.getElementById('modalTimeDisplay').value = `${slot.start_time} - ${slot.end_time}`;

        document.getElementById('timetableModal').classList.remove('hidden');
        document.getElementById('timetableModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('timetableModal').classList.remove('flex');
        document.getElementById('timetableModal').classList.add('hidden');
    }
</script>
@endsection
