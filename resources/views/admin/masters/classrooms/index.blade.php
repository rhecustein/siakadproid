@extends('layouts.app')

@section('content')
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Classroom List</h2>
      <p class="text-sm text-gray-500">All classrooms registered in the system.</p>
    </div>
    <a href="{{ route('academic.classrooms.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Classroom
    </a>
  </div>

  @if (session('success'))
    <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Filter/Search -->
  <form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search class name..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="level_id" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Levels</option>
      @foreach ($levels as $level)
        <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
      @endforeach
    </select>

    <select name="academic_year_id" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Years</option>
      @foreach ($academicYears as $year)
        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
      @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Filter
    </button>
  </form>

  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Nama Ruangan Kelas</th>
          <th class="px-6 py-3">Kelas</th>
          <th class="px-6 py-3">Tahun Ajaran</th>
          <th class="px-6 py-3">Kurikulum</th>
          <th class="px-6 py-3">Keterangan</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($classrooms as $index => $classroom)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $classrooms->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $classroom->name }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $classroom->level->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $classroom->academicYear->year ?? '—' }}</td>
            <td class="px-6 py-3">{{ $classroom->curriculum->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $classroom->room ?? '—' }}</td>
            <td class="px-6 py-3">
              @if ($classroom->is_active)
                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Active</span>
              @else
                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactive</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
              <a href="{{ route('academic.classrooms.edit', $classroom->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('academic.classrooms.destroy', $classroom->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Are you sure to delete this classroom?')">
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
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No classroom data available.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex justify-between text-sm text-gray-600">
    <p>Showing {{ $classrooms->firstItem() }} – {{ $classrooms->lastItem() }} of {{ $classrooms->total() }} classrooms</p>
    {{ $classrooms->appends(request()->query())->onEachSide(1)->links() }}
  </div>
@endsection
