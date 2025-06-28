<div class="bg-white shadow-lg ring-1 ring-gray-200 rounded-xl p-6 space-y-6">

  {{-- Grup Tagihan --}}
  <div>
    <label for="bill_group_id" class="block text-sm font-semibold text-gray-800 mb-1">🎯 Grup Tagihan</label>
    <select name="bill_group_id" id="bill_group_id" required class="form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">-- Pilih Grup Tagihan --</option>
      @foreach($groups as $group)
        <option value="{{ $group->id }}"
            data-nominal="{{ $group->amount_per_tagihan }}"
            data-count="{{ $group->tagihan_count }}"
            data-description="{{ $group->description }}"
            data-year="{{ $group->academic_year }}"
            data-start="{{ $group->start_date }}"
            data-end="{{ $group->end_date }}"
            data-gender="{{ $group->gender }}"
            data-type="{{ $group->type->id ?? null }}">
            {{ $group->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div>
  <label for="bill_type_id" class="block text-sm font-semibold text-gray-800 mb-1">📑 Jenis Tagihan</label>
  <select name="bill_type_id" id="bill_type_id" required
          class="form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    <option value="">-- Pilih Jenis Tagihan --</option>
    @foreach($billTypes as $type)
      <option value="{{ $type->id }}" {{ request('bill_type_id') == $type->id ? 'selected' : '' }}>
        {{ $type->name }}
      </option>
    @endforeach
  </select>
</div>
  {{-- Jenis Generate --}}
  <div>
    <label class="block text-sm font-semibold text-gray-800 mb-1">⚙️ Jenis Generate</label>
    <div class="flex gap-6 items-center">
      <label class="inline-flex items-center space-x-2">
        <input type="radio" name="mode" value="filter" class="form-radio text-blue-600" checked onchange="toggleStudentPanel()">
        <span class="text-sm text-gray-700">Berdasarkan Filter</span>
      </label>
      <label class="inline-flex items-center space-x-2">
        <input type="radio" name="mode" value="manual" class="form-radio text-blue-600" onchange="toggleStudentPanel()">
        <span class="text-sm text-gray-700">Siswa Dipilih</span>
      </label>
    </div>
  </div>

  {{-- Filter Detail --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">🏫 Sekolah</label>
      <select name="school_id" class="form-select w-full rounded-md border-gray-300">
        <option value="">-- Semua --</option>
        @foreach($schools as $school)
          <option value="{{ $school->id }}">{{ $school->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">📚 Jenjang</label>
      <select name="level_id" class="form-select w-full rounded-md border-gray-300">
        <option value="">-- Semua --</option>
        @foreach($levels as $level)
          <option value="{{ $level->id }}">{{ $level->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">🏷️ Kelas / Grade</label>
      <select name="grade_id" class="form-select w-full rounded-md border-gray-300">
        <option value="">-- Semua --</option>
        @foreach($gradeLevels as $grade)
          <option value="{{ $grade->id }}">{{ $grade->label }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">📅 Tahun Ajaran</label>
      <select name="academic_year" class="form-select w-full rounded-md border-gray-300">
        <option value="">-- Semua --</option>
        @foreach($academicYears as $year)
          <option value="{{ $year->year }}" {{ request('academic_year') == $year->year ? 'selected' : '' }}>
            {{ $year->year }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">🗓️ Tanggal Mulai Tagihan</label>
      <input type="date" name="start_date" id="start_date" class="form-input w-full rounded-md border-gray-300" value="">
    </div>
  </div>

  {{-- Tombol --}}
  <div class="pt-4 flex gap-3">
    <button type="submit"
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2 rounded-md shadow">
      🚀 Generate Tagihan
    </button>
    <a href="{{ route('finance.bill-generates.index') }}"
       class="text-sm text-gray-500 hover:text-blue-600 hover:underline mt-2 inline-block">
      ↻ Reset Filter
    </a>
  </div>
</div>
