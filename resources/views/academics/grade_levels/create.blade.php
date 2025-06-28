@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">Tambah Kelas (Grade Level)</h1>
        <a href="{{ route('academic.grade-levels.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar Kelas
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('academic.grade-levels.store') }}" method="POST"
          class="bg-white shadow rounded p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Jenjang / Level</label>
            <select name="level_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Jenjang --</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                        {{ $level->name }} ({{ $level->slug }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nomor Kelas (Grade)</label>
                <input type="number" name="grade" class="w-full border rounded px-3 py-2"
                       value="{{ old('grade') }}" min="1" max="20" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Label / Kode</label>
                <input type="text" name="label" class="w-full border rounded px-3 py-2"
                       value="{{ old('label') }}" placeholder="Contoh: SMP7" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi (Opsional)</label>
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"
                      placeholder="Contoh: Kelas 7 untuk SMP Al Bahjah">{{ old('description') }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" value="1"
                   class="mr-2" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="text-sm text-gray-700">Aktif</label>
        </div>

        <div class="text-right pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Simpan Kelas
            </button>
        </div>
    </form>
</div>
@endsection
