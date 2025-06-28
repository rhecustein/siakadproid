@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-700">✏️ Edit Inventaris</h2>
            <a href="{{ route('facility.inventories.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
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

        <form method="POST" action="{{ route('facility.inventories.update', $inventory->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="name" value="{{ old('name', $inventory->name) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('name') border-red-500 @enderror"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode Inventaris</label>
                    <input type="text" name="code" value="{{ old('code', $inventory->code) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('code') border-red-500 @enderror"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Inventaris</label>
                    <select name="inventory_type_id" class="mt-1 w-full border rounded-md p-2 @error('inventory_type_id') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('inventory_type_id', $inventory->inventory_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kondisi</label>
                    <select name="inventory_condition_id" class="mt-1 w-full border rounded-md p-2 @error('inventory_condition_id') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ old('inventory_condition_id', $inventory->inventory_condition_id) == $condition->id ? 'selected' : '' }}>
                                {{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ruangan</label>
                    <select name="room_id" class="mt-1 w-full border rounded-md p-2 @error('room_id') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', $inventory->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $inventory->quantity) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('quantity') border-red-500 @enderror">
                </div>

                {{-- Checkbox dengan hidden input --}}
                <div class="flex items-center space-x-2 mt-6">
                    <input type="hidden" name="is_electronic" value="0">
                    <input type="checkbox" name="is_electronic" id="is_electronic" value="1"
                           class="h-4 w-4 text-blue-600"
                           {{ old('is_electronic', $inventory->is_electronic) ? 'checked' : '' }}>
                    <label for="is_electronic" class="text-sm text-gray-700">Barang Elektronik</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Perolehan</label>
                    <input type="date" name="acquired_at" value="{{ old('acquired_at', optional($inventory->acquired_at)->format('Y-m-d')) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('acquired_at') border-red-500 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Umur Ekonomis (tahun)</label>
                    <input type="number" name="economic_life" value="{{ old('economic_life', $inventory->economic_life) }}"
                           class="mt-1 w-full border rounded-md p-2 @error('economic_life') border-red-500 @enderror">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    Perbarui Inventaris
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
