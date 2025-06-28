@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Edit Subject</h2>
  <p class="text-sm text-gray-500">Update the subject information below.</p>
</div>

<form action="{{ route('academic.subjects.update', $subject) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-6">
  @csrf
  @method('PUT')

  <div>
    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
  </div>

  <div>
    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
    <select name="type" id="type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
      <option value="wajib" {{ old('type', $subject->type) == 'wajib' ? 'selected' : '' }}>Wajib</option>
      <option value="pilihan" {{ old('type', $subject->type) == 'pilihan' ? 'selected' : '' }}>Pilihan</option>
    </select>
  </div>

  <div>
    <label for="kkm" class="block text-sm font-medium text-gray-700">KKM</label>
    <input type="number" name="kkm" id="kkm" value="{{ old('kkm', $subject->kkm) }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="0" max="100">
  </div>

  <div>
    <label for="level_id" class="block text-sm font-medium text-gray-700">Level</label>
    <select name="level_id" id="level_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Level --</option>
      @foreach ($levels as $level)
        <option value="{{ $level->id }}" {{ old('level_id', $subject->level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label for="curriculum_id" class="block text-sm font-medium text-gray-700">Curriculum</label>
    <select name="curriculum_id" id="curriculum_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Curriculum --</option>
      @foreach ($curriculums as $curriculum)
        <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $subject->curriculum_id) == $curriculum->id ? 'selected' : '' }}>{{ $curriculum->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label for="major_id" class="block text-sm font-medium text-gray-700">Major</label>
    <select name="major_id" id="major_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Major --</option>
      @foreach ($majors as $major)
        <option value="{{ $major->id }}" {{ old('major_id', $subject->major_id) == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="flex items-center">
    <input type="checkbox" name="is_religious" id="is_religious" value="1" {{ old('is_religious', $subject->is_religious) ? 'checked' : '' }}
           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
    <label for="is_religious" class="ml-2 block text-sm text-gray-700">Religious Subject</label>
  </div>

  <div class="pt-4 flex justify-between items-center">
    <a href="{{ route('academic.subjects.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to list</a>
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
      Update Subject
    </button>
  </div>
</form>
@endsection
