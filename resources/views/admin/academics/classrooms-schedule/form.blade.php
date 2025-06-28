<form action="{{ $formAction }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-6">
  @csrf
  @if ($isEdit)
    @method('PUT')
  @endif

  <!-- Classroom Name -->
  <div>
    <label for="name" class="block text-sm font-medium text-gray-700">Classroom Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $classroom->name ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
  </div>

  <!-- Level -->
  <div>
    <label for="level_id" class="block text-sm font-medium text-gray-700">Level</label>
    <select name="level_id" id="level_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Level --</option>
      @foreach ($levels as $level)
        <option value="{{ $level->id }}" {{ old('level_id', $classroom->level_id ?? '') == $level->id ? 'selected' : '' }}>
          {{ $level->name }}
        </option>
      @endforeach
    </select>
  </div>

  <!-- Academic Year -->
  <div>
    <label for="academic_year_id" class="block text-sm font-medium text-gray-700">Academic Year</label>
    <select name="academic_year_id" id="academic_year_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Academic Year --</option>
      @foreach ($academicYears as $year)
        <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id ?? '') == $year->id ? 'selected' : '' }}>
          {{ $year->name }}
        </option>
      @endforeach
    </select>
  </div>

  <!-- Curriculum -->
  <div>
    <label for="curriculum_id" class="block text-sm font-medium text-gray-700">Curriculum</label>
    <select name="curriculum_id" id="curriculum_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <option value="">-- Select Curriculum --</option>
      @foreach ($curriculums as $curriculum)
        <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $classroom->curriculum_id ?? '') == $curriculum->id ? 'selected' : '' }}>
          {{ $curriculum->name }}
        </option>
      @endforeach
    </select>
  </div>

  <!-- Room -->
  <div>
    <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
    <input type="text" name="room" id="room" value="{{ old('room', $classroom->room ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
  </div>

  <!-- Status -->
  <div class="flex items-center">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $classroom->is_active ?? true) ? 'checked' : '' }}
           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
  </div>

  <!-- Submit -->
  <div class="pt-4">
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
      {{ $isEdit ? 'Update Classroom' : 'Create Classroom' }}
    </button>
  </div>
</form>