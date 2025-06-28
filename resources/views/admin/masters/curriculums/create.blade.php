@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Add Curriculum</h2>
    <p class="text-sm text-gray-500">Fill in the details of the new curriculum.</p>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('academic.curriculums.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Curriculum Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
               required>
        @error('name')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
        <input type="text" id="code" name="code" value="{{ old('code') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
        @error('code')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">{{ old('description') }}</textarea>
        @error('description')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="start_year" class="block text-sm font-medium text-gray-700">Start Year</label>
          <input type="number" id="start_year" name="start_year" value="{{ old('start_year') }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="e.g. 2024">
        </div>

        <div>
          <label for="end_year" class="block text-sm font-medium text-gray-700">End Year (optional)</label>
          <input type="number" id="end_year" name="end_year" value="{{ old('end_year') }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="e.g. 2026">
        </div>
      </div>

      <div>
        <label for="level_group" class="block text-sm font-medium text-gray-700">Level Group</label>
        <select id="level_group" name="level_group"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
          <option value="">— Select Level —</option>
          <option value="sd" {{ old('level_group') == 'sd' ? 'selected' : '' }}>SD</option>
          <option value="smp" {{ old('level_group') == 'smp' ? 'selected' : '' }}>SMP</option>
          <option value="sma" {{ old('level_group') == 'sma' ? 'selected' : '' }}>SMA</option>
          <option value="ponpes" {{ old('level_group') == 'ponpes' ? 'selected' : '' }}>Pondok</option>
        </select>
        @error('level_group')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="applicable_grades" class="block text-sm font-medium text-gray-700">Applicable Grades</label>
        <input type="text" name="applicable_grades[]" value="{{ old('applicable_grades.0') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
               placeholder="e.g. 10,11,12 (use multiple inputs or JSON)">
        @error('applicable_grades')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="regulation_number" class="block text-sm font-medium text-gray-700">Regulation Number</label>
        <input type="text" name="regulation_number" value="{{ old('regulation_number') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm">
      </div>

      <div>
        <label for="reference_document" class="block text-sm font-medium text-gray-700">Reference Document</label>
        <input type="text" name="reference_document" value="{{ old('reference_document') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm"
               placeholder="https://drive.google.com/… or document name">
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('academic.curriculums.index') }}" class="text-sm text-gray-600 hover:underline">
          ← Back to Curriculum List
        </a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Save Curriculum
        </button>
      </div>
    </form>
  </div>
@endsection
