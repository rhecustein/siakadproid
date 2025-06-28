@extends('layouts.app')

@section('content')
<div class="mb-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div class="mb-4 sm:mb-0">
      <h2 class="text-2xl font-bold text-blue-700">Daftar Kurikulum</h2>
      <p class="text-sm text-gray-500">Semua kurikulum yang terdaftar dalam sistem.</p>
    </div>
    <a href="{{ route('academic.curriculums.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Tambah Kurikulum  
    </a>
  </div>

  <form method="GET" action="{{ route('academic.curriculums.index') }}" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-xl shadow">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or level..."
      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
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
        <th class="px-6 py-3">Level</th>
        <th class="px-6 py-3">Start</th>
        <th class="px-6 py-3">End</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse ($curriculums as $index => $curriculum)
      <tr class="hover:bg-blue-50 transition">
        <td class="px-6 py-3">{{ $index + 1 }}</td>
        <td class="px-6 py-3 font-medium text-gray-900">{{ $curriculum->name }}</td>
        <td class="px-6 py-3 text-gray-700 capitalize">
          {{ $curriculum->level_group ? strtoupper($curriculum->level_group) : '—' }}
        </td>
        <td class="px-6 py-3">{{ $curriculum->start_year ?? '—' }}</td>
        <td class="px-6 py-3">{{ $curriculum->end_year ?? 'Now' }}</td>
        <td class="px-6 py-3">
          @if ($curriculum->is_active)
            <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">
              Active
            </span>
          @else
            <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">
              Inactive
            </span>
          @endif
        </td>
              <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
          @if ($curriculum->is_active)
            <a href="{{ route('academic.curriculums.deactivate', $curriculum->id) }}"
              class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200">
              Nonaktifkan
            </a>
          @elseif ($curriculum->level_group)
            <a href="{{ route('academic.curriculums.activate', $curriculum->id) }}"
              class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
              Aktifkan
            </a>
          @endif

          <a href="{{ route('academic.curriculums.edit', $curriculum->id) }}"
            class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
            Edit
          </a>

          <form action="{{ route('academic.curriculums.destroy', $curriculum->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Are you sure to delete this curriculum?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
              Hapus
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No curriculum data available.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
