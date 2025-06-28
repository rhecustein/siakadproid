@extends('layouts.canteen-admin')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Permintaan Pembelian Kantin</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter dan Search --}}
    <form method="GET" action="{{ route('canteen.purchase_requests.index') }}" class="flex flex-col sm:flex-row items-center gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
            class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-400">

        <select name="status" class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-md shadow-sm">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Filter</button>

        <a href="{{ route('canteen.purchase_requests.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            + Tambah Permintaan
        </a>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Kantin</th>
                    <th class="px-4 py-3">Permintaan Dari</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Harga Total</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Dibuat</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($requests as $index => $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $request->canteen->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $request->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $request->quantity ?? '-' }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($request->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $request->description ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded 
                                {{ $request->status == 'approved' ? 'bg-green-100 text-green-700' : ($request->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($request->requested_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $request->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-2">
                            <div class="flex flex-wrap gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('canteen.purchase_requests.edit', $request->id) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm underline" title="Edit">Edit</a>

                                {{-- Hapus --}}
                                <form action="{{ route('canteen.purchase_requests.destroy', $request->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus permintaan ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm underline" title="Hapus">Hapus</button>
                                </form>

                                {{-- Lihat --}}
                                <a href="{{ route('canteen.purchase_requests.show', $request->id) }}"
                                   class="text-gray-700 hover:text-black text-sm underline" title="Lihat Detail">Lihat</a>

                                {{-- Approve --}}
                                @if ($request->status === 'pending')
                                <button onclick="openApproveModal({{ $request->id }})"
                                        class="text-green-600 hover:text-green-800 text-sm underline"
                                        title="Setujui Permintaan">
                                    Approve
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-4 text-center text-gray-500">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Approve --}}
    <div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Persetujuan</h2>
            <p class="mb-6 text-gray-700">Yakin ingin menyetujui permintaan ini?</p>
            <form id="approveForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white hover:bg-green-700 rounded">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Modal --}}
<script>
    function openApproveModal(requestId) {
        const modal = document.getElementById('approveModal');
        const form = document.getElementById('approveForm');
        form.action = `/canteen/purchase-requests/${requestId}/approve`; // sesuaikan jika route beda
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeApproveModal() {
        const modal = document.getElementById('approveModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
