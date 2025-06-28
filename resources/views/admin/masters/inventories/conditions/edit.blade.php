@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">✏️ Edit Kondisi Inventaris</h2>
            <a href="{{ route('facility.inventory-conditions.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
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

        <form method="POST" action="{{ route('facility.inventory-conditions.update', $inventoryCondition->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kondisi</label>
                <input type="text" name="name" value="{{ old('name', $inventoryCondition->name) }}"
                       class="mt-1 w-full border rounded-md p-2 @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="mt-1 w-full border rounded-md p-2 @error('description') border-red-500 @enderror"
                          placeholder="Opsional">{{ old('description', $inventoryCondition->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Perbarui Kondisi
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
