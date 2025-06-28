@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">✏️ Edit Tipe Inventaris</h2>
            <a href="{{ route('facility.inventory-types.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        {{-- Tampilkan error validasi --}}
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

        <form method="POST" action="{{ route('facility.inventory-types.update', $inventoryType->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Tipe</label>
                <input type="text" name="name" value="{{ old('name', $inventoryType->name) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('name') border-red-500 @enderror"
                       required placeholder="Contoh: Elektronik, Furniture">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-2">
                <input type="hidden" name="is_electronic" value="0">
                <input type="checkbox" name="is_electronic" id="is_electronic" value="1"
                       class="h-4 w-4 text-blue-600"
                       {{ old('is_electronic', $inventoryType->is_electronic) ? 'checked' : '' }}>
                <label for="is_electronic" class="text-sm text-gray-700">Termasuk Barang Elektronik</label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Umur Ekonomis (tahun)</label>
                <input type="number" name="economic_life" value="{{ old('economic_life', $inventoryType->economic_life) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('economic_life') border-red-500 @enderror"
                       placeholder="Contoh: 5">
                @error('economic_life')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Perbarui Tipe Inventaris
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
