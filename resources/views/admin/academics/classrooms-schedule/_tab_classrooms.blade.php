<!-- Filter & Search -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
  <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search classroom name..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="level" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Levels</option>
      @foreach ($levels as $lvl)
        <option value="{{ $lvl->id }}" {{ request('level') == $lvl->id ? 'selected' : '' }}>
          {{ $lvl->name }}
        </option>
      @endforeach
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Filter
    </button>
  </form>

  <a href="#"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
    + Add Classroom
  </a>
</div>

<!-- Classrooms Table -->
<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3">Level</th>
        <th class="px-6 py-3">Academic Year</th>
        <th class="px-6 py-3">Curriculum</th>
        <th class="px-6 py-3">Room</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($classrooms as $index => $classroom)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $classrooms->firstItem() + $index }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $classroom->name }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $classroom->level->name ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $classroom->academicYear->name ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $classroom->curriculum->name ?? '-' }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $classroom->room ?? '-' }}</td>
          <td class="px-6 py-3">
            @if ($classroom->is_active)
              <span class="text-green-500">Active</span>
            @else
              <span class="text-red-500">Inactive</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('academic.classrooms-schedule.show', $classroom) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
              View
            </a>
            <a href="{{ route('academic.classrooms-schedule.edit', $classroom) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="#" method="POST" class="inline" onsubmit="return confirm('Delete this classroom?')">
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
          <td colspan="8" class="px-6 py-4 text-center text-gray-500">No classrooms found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
  <p>
    Showing {{ $classrooms->firstItem() }} – {{ $classrooms->lastItem() }} of {{ $classrooms->total() }} classrooms
  </p>
  <div>
    {{ $classrooms->appends(request()->query())->onEachSide(1)->links() }}
  </div>
</div>
