@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Permintaan Pembelian</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('canteen.purchase_requests.update', $requestItem->id) }}" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        {{-- Pilih Kantin --}}
        <div>
            <label for="canteen_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kantin</label>
            <select name="canteen_id" id="canteen_id" required disabled
                    class="w-full border border-gray-300 px-3 py-2 rounded bg-gray-100 text-gray-600">
                @foreach ($canteens as $canteen)
                    <option value="{{ $canteen->id }}" {{ $requestItem->canteen_id == $canteen->id ? 'selected' : '' }}>
                        {{ $canteen->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500 text-xs">Kantin tidak dapat diubah setelah permintaan dibuat.</small>
        </div>

        {{-- Tanggal Permintaan --}}
        <div>
            <label for="requested_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Permintaan</label>
            <input type="date" name="requested_date" id="requested_date"
                   value="{{ old('requested_date', $requestItem->requested_date) }}"
                   required class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- Jumlah --}}
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Barang</label>
            <input type="number" name="quantity" id="quantity" min="1"
                   value="{{ old('quantity', $requestItem->quantity) }}"
                   required class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- Harga Total --}}
        <div>
            <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Total Harga (Rp)</label>
            <input type="number" name="total_price" id="total_price" min="0"
                   value="{{ old('total_price', $requestItem->total_price) }}"
                   required class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400">{{ old('description', $requestItem->description) }}</textarea>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" required
                    class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400">
                <option value="pending" {{ $requestItem->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $requestItem->status === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $requestItem->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('canteen.purchase_requests.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                Perbarui Permintaan
            </button>
        </div>
    </form>
</div>
@endsection
