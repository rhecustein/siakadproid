@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <div>
    <h2 class="text-2xl font-bold text-blue-700">Bill Types</h2>
    <p class="text-sm text-gray-500">Manage the types of school bills.</p>
  </div>
  <a href="{{ route('finance.bill-types.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">+ Add</a>
</div>

@if(session('success'))
  <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif

<div class="bg-white shadow rounded-xl overflow-x-auto">
  <table class="min-w-full text-sm divide-y divide-gray-200">
    <thead class="bg-gray-50 text-left font-semibold text-gray-700">
      <tr>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3">Code</th>
        <th class="px-6 py-3">Description</th>
        <th class="px-6 py-3">Status</th>
        <th class="px-6 py-3 text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($billTypes as $type)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-3">{{ $type->name }}</td>
          <td class="px-6 py-3">{{ $type->code }}</td>
          <td class="px-6 py-3">{{ $type->description ?? '-' }}</td>
          <td class="px-6 py-3">
            @if($type->is_active)
              <span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">Active</span>
            @else
              <span class="px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded-full">Inactive</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('finance.bill-types.edit', $type->id) }}"
               class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Edit</a>
            <form action="{{ route('finance.bill-types.destroy', $type->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Delete this bill type?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-6 text-gray-400">No bill types found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">
  {{ $billTypes->links() }}
</div>
@endsection
