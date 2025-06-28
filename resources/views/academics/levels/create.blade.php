@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">➕ Tambah Jenjang Pendidikan</h2>
            <a href="{{ route('academic.levels.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        {{-- Global error (optional) --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('academic.levels.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Jenjang</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="mt-1 w-full border rounded-md p-2 @error('name') border-red-500 @enderror"
                           required placeholder="Contoh: SD">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           class="mt-1 w-full border rounded-md p-2 @error('slug') border-red-500 @enderror"
                           required placeholder="Contoh: sd">
                    @error('slug')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe</label>
                    <select name="type" class="mt-1 w-full border rounded-md p-2 @error('type') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="formal" {{ old('type') == 'formal' ? 'selected' : '' }}>Formal</option>
                        <option value="non-formal" {{ old('type') == 'non-formal' ? 'selected' : '' }}>Non-Formal</option>
                        <option value="pesantren" {{ old('type') == 'pesantren' ? 'selected' : '' }}>Pesantren</option>
                    </select>
                    @error('type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimal Kelas</label>
                    <input type="number" name="min_grade" value="{{ old('min_grade') }}"
                           class="mt-1 w-full border rounded-md p-2 @error('min_grade') border-red-500 @enderror" placeholder="Contoh: 1">
                    @error('min_grade')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Maksimal Kelas</label>
                    <input type="number" name="max_grade" value="{{ old('max_grade') }}"
                           class="mt-1 w-full border rounded-md p-2 @error('max_grade') border-red-500 @enderror" placeholder="Contoh: 6">
                    @error('max_grade')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2 mt-4">
                    <input type="checkbox" name="is_active" id="is_active"
                           class="h-4 w-4 text-blue-600" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="mt-1 w-full border rounded-md p-2 @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi tambahan...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Simpan Jenjang
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
