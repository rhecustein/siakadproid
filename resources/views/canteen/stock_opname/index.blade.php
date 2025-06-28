@extends('layouts.canteen-admin')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Stok Opname Kantin</h1>
    <a href="{{ route('canteen.stock-opnames.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Tambah Opname</a>
  </div>

  <!-- Filter & Search -->
  <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm text-gray-600 mb-1">Tanggal Opname</label>
      <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2 border rounded">
    </div>
    <div>
      <label class="block text-sm text-gray-600 mb-1">Cari Produk</label>
      <input type="text" name="q" placeholder="Nama produk..." value="{{ request('q') }}" class="w-full px-3 py-2 border rounded">
    </div>
    <div class="flex items-end">
      <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition w-full">
        🔍 Cari
      </button>
    </div>
  </form>

  <!-- Table -->
  <div class="overflow-x-auto bg-white rounded shadow border">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Produk</th>
          <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Stok Sistem</th>
          <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Stok Nyata</th>
          <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Selisih</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Catatan</th>
          <th class="px-4 py-2 text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse ($opnames as $op)
        <tr>
          <td class="px-4 py-2 text-sm text-gray-800">{{ \Carbon\Carbon::parse($op->opname_date)->format('d M Y') }}</td>
          <td class="px-4 py-2 text-sm text-gray-900 font-medium">{{ $op->product->name }}</td>
          <td class="px-4 py-2 text-sm text-center">{{ $op->system_stock }}</td>
          <td class="px-4 py-2 text-sm text-center">{{ $op->real_stock }}</td>
          <td class="px-4 py-2 text-sm text-center font-bold {{ $op->difference < 0 ? 'text-red-600' : ($op->difference > 0 ? 'text-green-600' : 'text-gray-700') }}">
            {{ $op->difference }}
          </td>
          <td class="px-4 py-2 text-sm text-gray-700">{{ $op->note ?? '-' }}</td>
          <td class="px-4 py-2 text-sm">
            <a href="{{ route('canteen.stock-opname.show', $op->id) }}" class="text-blue-600 hover:underline">Detail</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">Tidak ada data opname.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $opnames->withQueryString()->links() }}
  </div>
</div>
@endsection
