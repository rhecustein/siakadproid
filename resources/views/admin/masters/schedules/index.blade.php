@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Jadwal Pelajaran</h2>
  <p class="text-sm text-gray-500">Klik pada sel kosong untuk menambahkan jadwal atau klik jadwal yang ada untuk mengedit.</p>
</div>

<!-- Filters -->
<div class="mb-4 flex flex-wrap items-center gap-2">
  <select name="school_id" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
    <option value="">Pilih Sekolah</option>
    @foreach($schools as $school)
      <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
    @endforeach
  </select>
  <select name="classroom_id" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
    <option value="">Pilih Kelas</option>
    @foreach($classrooms as $classroom)
      <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
    @endforeach
  </select>
  <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Tampilkan</button>
</div>

<!-- Jadwal Grid -->
<div class="overflow-auto">
  <table class="min-w-full table-auto border text-sm">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-2 py-1">Hari</th>
        <th class="border px-2 py-1">Jam</th>
        @foreach($days as $day)
          <th class="border px-2 py-1 capitalize">{{ $day }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($lessonTimes as $time)
        <tr>
          <td class="border px-2 py-1 text-center align-middle" rowspan="1">Jam {{ $time->order }}</td>
          <td class="border px-2 py-1 text-center align-middle">{{ substr($time->start, 0, 5) }} - {{ substr($time->end, 0, 5) }}</td>
          @foreach($days as $day)
            @php
              $slot = $schedules->firstWhere(fn($s) => $s->day == $day && $s->lesson_time_id == $time->id);
            @endphp
            <td class="border px-2 py-1 h-20 cursor-pointer hover:bg-blue-50 text-xs"
                onclick="openScheduleModal('{{ $day }}', {{ $time->id }}, '{{ $slot ? $slot->id : '' }}')">
              @if($slot)
                <div class="font-semibold text-blue-700">{{ $slot->subject->name ?? '-' }}</div>
                <div class="text-gray-600">{{ $slot->teacher->name ?? '-' }}</div>
                <div class="text-gray-500">{{ $slot->room->name ?? '-' }}</div>
              @else
                <span class="text-gray-400 italic">(kosong)</span>
              @endif
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal Jadwal -->
<div id="scheduleModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
  <div class="bg-white rounded-lg w-full max-w-lg p-6 relative">
    <button onclick="closeScheduleModal()" class="absolute top-2 right-2 text-gray-400 hover:text-red-500">&times;</button>
    <h3 class="text-lg font-bold text-blue-700 mb-4">Atur Jadwal</h3>
    <form method="POST" action="{{ route('schedule.store') }}" id="scheduleForm">
      @csrf
      <input type="hidden" name="day" id="modalDay">
      <input type="hidden" name="lesson_time_id" id="modalLessonTime">
      <div class="space-y-4">
        <select name="classroom_id" class="w-full border rounded px-3 py-2 text-sm">
          <option value="">Pilih Kelas</option>
          @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
          @endforeach
        </select>

        <select name="subject_id" class="w-full border rounded px-3 py-2 text-sm">
          <option value="">Pilih Mata Pelajaran</option>
          @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
          @endforeach
        </select>

        <select name="teacher_id" class="w-full border rounded px-3 py-2 text-sm">
          <option value="">Pilih Guru</option>
          @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
          @endforeach
        </select>

        <select name="room_id" class="w-full border rounded px-3 py-2 text-sm">
          <option value="">Pilih Ruangan</option>
          @foreach($rooms as $room)
            <option value="{{ $room->id }}">{{ $room->name }}</option>
          @endforeach
        </select>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="closeScheduleModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">Batal</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function openScheduleModal(day, timeId, scheduleId = null) {
  document.getElementById('modalDay').value = day;
  document.getElementById('modalLessonTime').value = timeId;
  document.getElementById('scheduleModal').classList.remove('hidden');
}
function closeScheduleModal() {
  document.getElementById('scheduleModal').classList.add('hidden');
}
</script>
@endsection
