<!-- Filter by Classroom -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
  <form method="GET" class="flex items-center gap-2">
    <label for="classroom_id" class="text-sm text-gray-700">Select Classroom:</label>
    <select name="classroom_id" id="classroom_id" onchange="this.form.submit()"
            class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">-- All Classrooms --</option>
      @foreach ($classrooms->pluck('name', 'id') as $id => $name)
        <option value="{{ $id }}" {{ request('classroom_id') == $id ? 'selected' : '' }}>
          {{ $name }}
        </option>
      @endforeach
    </select>
  </form>

  <a href="#"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
    + Add Schedule
  </a>
</div>

<!-- Schedule Table -->
<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Day</th>
        <th class="px-6 py-3">Start</th>
        <th class="px-6 py-3">End</th>
        <th class="px-6 py-3">Teacher</th>
        <th class="px-6 py-3">Class</th>
        <th class="px-6 py-3">Room</th>
        <th class="px-6 py-3">School</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @php
        $filteredSchedules = request('classroom_id')
          ? $schedules->where('grade_id', request('classroom_id'))
          : $schedules;
      @endphp
      @forelse ($filteredSchedules as $index => $schedule)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $loop->iteration }}</td>
          <td class="px-6 py-3">{{ ucfirst($schedule->day) }}</td>
          <td class="px-6 py-3">{{ $schedule->start_time }}</td>
          <td class="px-6 py-3">{{ $schedule->end_time }}</td>
          <td class="px-6 py-3">{{ $schedule->teacher->name ?? '-' }}</td>
          <td class="px-6 py-3">{{ $schedule->grade->name ?? '-' }}</td>
          <td class="px-6 py-3">{{ $schedule->room ?? '-' }}</td>
          <td class="px-6 py-3">{{ $schedule->school->name ?? '-' }}</td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="#"
               class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
              View
            </a>
            <a href="#"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="#" method="POST" class="inline" onsubmit="return confirm('Delete this schedule?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" class="px-6 py-4 text-center text-gray-500">No schedules found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>