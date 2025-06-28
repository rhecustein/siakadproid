@extends('layouts.app')

@section('content')
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Subject List</h2>
      <p class="text-sm text-gray-500">All subjects registered in the system.</p>
    </div>
    <a href="{{ route('academic.subjects.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Subject
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
  <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search subject name..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="type" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Types</option>
      <option value="wajib" {{ request('type') == 'wajib' ? 'selected' : '' }}>Wajib</option>
      <option value="pilihan" {{ request('type') == 'pilihan' ? 'selected' : '' }}>Pilihan</option>
    </select>

    <select name="status" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Status</option>
      <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
      <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
      Filter
    </button>
  </form>

  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Name</th>
          <th class="px-6 py-3">Tipe</th>
          <th class="px-6 py-3">Jenjang</th>
          <th class="px-6 py-3">Jurusan</th>
          <th class="px-6 py-3">Curriculum</th>
          <th class="px-6 py-3">KKM</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($subjects as $index => $subject)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $subjects->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $subject->name }}</td>
            <td class="px-6 py-3 capitalize">{{ $subject->type }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $subject->level->name ?? '—' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $subject->major->name ?? '—' }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $subject->curriculum->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $subject->kkm ?? '—' }}</td>
            <td class="px-6 py-3">
              @if ($subject->is_active)
                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Active</span>
              @else
                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactive</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
              <a href="{{ route('academic.subjects.edit', $subject->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('academic.subjects.destroy', $subject->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Are you sure to delete this subject?')">
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
            <td colspan="9" class="px-6 py-4 text-center text-gray-500">No subject data available.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex justify-between text-sm text-gray-600">
    <p>Showing {{ $subjects->firstItem() }} – {{ $subjects->lastItem() }} of {{ $subjects->total() }} subjects</p>
    {{ $subjects->appends(request()->query())->onEachSide(1)->links() }}
  </div>
@endsection
