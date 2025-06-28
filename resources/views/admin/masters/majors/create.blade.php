@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <h2 class="text-2xl font-bold text-blue-700 mb-1">Add New Major</h2>
  <p class="text-sm text-gray-500 mb-6">Fill in the form to add a new major.</p>

  <form action="{{ route('academic.majors.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-6">
    @csrf

    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
      <input type="text" name="name" id="name" value="{{ old('name') }}"
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      @error('name')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
      <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
      @error('slug')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
      <input type="text" name="code" id="code" value="{{ old('code') }}"
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
      @error('code')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
      <textarea name="description" id="description" rows="3"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
    </div>

    <div>
      <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
      <select name="type" id="type"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">— Select Type —</option>
        <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Academic</option>
        <option value="vocational" {{ old('type') == 'vocational' ? 'selected' : '' }}>Vocational</option>
        <option value="religious" {{ old('type') == 'religious' ? 'selected' : '' }}>Religious</option>
        <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special</option>
      </select>
      @error('type')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="level_id" class="block text-sm font-medium text-gray-700">Level</label>
      <select name="level_id" id="level_id"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">— Select Level —</option>
        @foreach ($levels as $level)
          <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
            {{ $level->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="school_id" class="block text-sm font-medium text-gray-700">School</label>
      <select name="school_id" id="school_id"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">— Select School —</option>
        @foreach ($schools as $school)
          <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
            {{ $school->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
      <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="flex justify-end space-x-2">
      <a href="{{ route('academic.majors.index') }}"
         class="inline-block px-4 py-2 text-sm bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
        Cancel
      </a>
      <button type="submit"
              class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Save
      </button>
    </div>
  </form>
</div>
@endsection
