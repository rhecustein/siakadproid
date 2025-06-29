@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Edit Inventaris
    </h1>
    <p class="text-gray-600 text-base">Perbarui detail barang inventaris ini.</p>
</div>

{{-- Success/Error Alert (consistent with other pages) --}}
@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <ul class="font-medium list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow-xl rounded-2xl p-8 mb-8 border border-gray-100">
    <form method="POST" action="{{ route('facility.inventories.update', $inventory->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $inventory->name) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Contoh: Proyektor Epson" required autofocus>
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="code" class="block text-sm font-semibold text-gray-800 mb-1">Kode Inventaris <span class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" value="{{ old('code', $inventory->code) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Contoh: INV-PRJ-001" required>
                @error('code') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Detail spesifik tentang barang ini, misal: 'Proyektor multimedia XGA, 3000 lumens'">{{ old('description', $inventory->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="inventory_type_id" class="block text-sm font-semibold text-gray-800 mb-1">Tipe Inventaris <span class="text-red-500">*</span></label>
                <select name="inventory_type_id" id="inventory_type_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Tipe —</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('inventory_type_id', $inventory->inventory_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('inventory_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="inventory_condition_id" class="block text-sm font-semibold text-gray-800 mb-1">Kondisi</label>
                <select name="inventory_condition_id" id="inventory_condition_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Kondisi —</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('inventory_condition_id', $inventory->inventory_condition_id) == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
                @error('inventory_condition_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="room_id" class="block text-sm font-semibold text-gray-800 mb-1">Ruangan</label>
                <select name="room_id" id="room_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Ruangan —</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $inventory->room_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('room_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="quantity" class="block text-sm font-semibold text-gray-800 mb-1">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $inventory->quantity) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       min="1" required>
                @error('quantity') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="purchase_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Perolehan (Opsional)</label>
                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', optional($inventory->purchase_date)->format('Y-m-d')) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
                @error('purchase_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Atribut Tambahan</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_electronic" id="is_electronic" value="1"
                           class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                           {{ old('is_electronic', $inventory->is_electronic) ? 'checked' : '' }}>
                    <label for="is_electronic" class="ml-2 text-sm text-gray-700 font-medium">Barang Elektronik</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_consumable" id="is_consumable" value="1"
                           class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                           {{ old('is_consumable', $inventory->is_consumable) ? 'checked' : '' }}>
                    <label for="is_consumable" class="ml-2 text-sm text-gray-700 font-medium">Barang Habis Pakai</label>
                </div>
            </div>
            @error('is_electronic') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            @error('is_consumable') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Catatan & Status</h4>
            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-800 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                          placeholder="Catatan khusus tentang inventaris ini">{{ old('notes', $inventory->notes) }}</textarea>
                @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center mt-4">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                       {{ old('is_active', $inventory->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700 font-medium">Aktifkan Inventaris ini</label>
            </div>
            @error('is_active') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('facility.inventories.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Perbarui Inventaris
            </button>
        </div>
    </form>
</div>
@endsection