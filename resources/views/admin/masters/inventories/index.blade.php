@extends('layouts.app')

@section('content')
 <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 flex-wrap">
  <div>
    <h2 class="text-2xl font-bold text-blue-700">Inventory List</h2>
    <p class="text-sm text-gray-500">All inventories registered in the system.</p>
  </div>

  <div class="flex gap-2 flex-wrap">
    <a href="{{ route('facility.inventories.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Inventory
    </a>

    <a href="{{ route('facility.inventory-types.index') }}"
       class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
      Inventory Types
    </a>

    <a href="{{ route('facility.inventory-conditions.index') }}"
       class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-600 transition">
      Inventory Conditions
    </a>
  </div>
</div>

  @if (session('success'))
    <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Filter/Search -->
  <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search name/code..."
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

    <select name="type" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Types</option>
      @foreach($types as $type)
        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
      @endforeach
    </select>

    <select name="condition" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
      <option value="">All Conditions</option>
      @foreach($conditions as $condition)
        <option value="{{ $condition->id }}" {{ request('condition') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
      @endforeach
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
          <th class="px-6 py-3">Code</th>
          <th class="px-6 py-3">Room</th>
          <th class="px-6 py-3">Type</th>
          <th class="px-6 py-3">Condition</th>
          <th class="px-6 py-3">Qty</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($inventories as $index => $inv)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $index + 1 }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $inv->name }}</td>
            <td class="px-6 py-3">{{ $inv->code }}</td>
            <td class="px-6 py-3">{{ $inv->room->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $inv->type->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $inv->condition->name ?? '—' }}</td>
            <td class="px-6 py-3">{{ $inv->quantity }}</td>
            <td class="px-6 py-3 text-center space-x-2">
              <a href="{{ route('facility.inventories.edit', $inv->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('facility.inventories.destroy', $inv->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Are you sure to delete this item?')">
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
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No inventory data available.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
