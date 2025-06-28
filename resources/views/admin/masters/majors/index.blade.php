@extends('layouts.app')

@section('content')
<div class="mb-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div class="mb-4 sm:mb-0">
      <h2 class="text-2xl font-bold text-blue-700">Major List</h2>
      <p class="text-sm text-gray-500">All registered majors by level and type.</p>
    </div>
    <a href="{{ route('academic.majors.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Major
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

  <form method="GET" action="{{ route('academic.majors.index') }}" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-xl shadow">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, slug, or code"
      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

    <select name="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
      <option value="">All Types</option>
      <option value="umum" {{ request('type') == 'umum' ? 'selected' : '' }}>Umum</option>
      <option value="kejuruan" {{ request('type') == 'kejuruan' ? 'selected' : '' }}>Kejuruan</option>
    </select>

    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
      <option value="">All Status</option>
      <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
      <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="submit"
      class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 transition">
      Filter
    </button>
  </form>
</div>

<div class="bg-white shadow rounded-xl overflow-x-auto mt-6">
  <table class="min-w-full table-auto text-sm text-left border-collapse">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
      <tr>
        <th class="px-6 py-3">#</th>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3">Slug</th>
        <th class="px-6 py-3">Code</th>
        <th class="px-6 py-3">Level</th>
        <th class="px-6 py-3">School</th>
        <th class="px-6 py-3">Type</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($majors as $index => $major)
        <tr class="hover:bg-blue-50 transition">
          <td class="px-6 py-3">{{ $index + 1 }}</td>
          <td class="px-6 py-3 font-medium text-gray-900">{{ $major->name }}</td>
          <td class="px-6 py-3 text-gray-700">{{ $major->slug }}</td>
          <td class="px-6 py-3">{{ $major->code ?? '—' }}</td>
          <td class="px-6 py-3">{{ $major->level->name ?? '—' }}</td>
          <td class="px-6 py-3">{{ $major->school->name ?? '—' }}</td>
          <td class="px-6 py-3 capitalize">{{ $major->type }}</td>
          <td class="px-6 py-3">
            @if ($major->is_active)
              <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Active</span>
            @else
              <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactive</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
            <a href="{{ route('academic.majors.edit', $major->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
              Edit
            </a>
            <form action="{{ route('academic.majors.destroy', $major->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure to delete this major?')">
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
          <td colspan="9" class="px-6 py-4 text-center text-gray-500">No majors available.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
