@extends('layouts.app')

@section('content')
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Room List</h2>
      <p class="text-sm text-gray-500">All rooms registered in the system.</p>
    </div>
    <a href="{{ route('facility.rooms.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Room
    </a>
  </div>

  @if (session('success'))
    <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Name</th>
          <th class="px-6 py-3">School</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($rooms as $index => $room)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $rooms->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $room->name }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $room->school->name ?? '—' }}</td>
            <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
              <a href="{{ route('facility.rooms.edit', $room->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
                Inventaris 
              </a>
              <a href="{{ route('facility.rooms.edit', $room->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('facility.rooms.destroy', $room->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Are you sure to delete this room?')">
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
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No room data available.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex justify-between text-sm text-gray-600">
    <p>Showing {{ $rooms->firstItem() }} – {{ $rooms->lastItem() }} of {{ $rooms->total() }} rooms</p>
    {{ $rooms->appends(request()->query())->onEachSide(1)->links() }}
  </div>
@endsection
