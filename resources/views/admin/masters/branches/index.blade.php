@extends('layouts.app')

@section('content')
<div class="mb-8"> {{-- Increased margin-bottom for better spacing from previous section --}}
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight"> {{-- Consistent page title styling --}}
        Daftar Cabang
    </h1>
    <p class="text-gray-600 text-base">Semua cabang aktif yang terdaftar dalam sistem.</p> {{-- Consistent description styling --}}
</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down"> {{-- Consistent success alert styling --}}
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

{{-- Contoh struktur filter, jika Anda punya filter khusus cabang --}}
{{--
<div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
    <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama cabang..."
               class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />
        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
        <a href="{{ route('shared.branches.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
            Reset
        </a>
    </form>
</div>
--}}

<div class="flex flex-wrap gap-3 mb-8 justify-end"> {{-- Adjusted flex and margin for buttons --}}
    <a href="{{ route('shared.branches.create') }}"
       class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Cabang
    </a>
    <a href="{{ route('shared.schools.index') }}"
       class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-gray-300 transition-colors duration-200 flex items-center gap-1 min-w-max">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15.75L7.5 12.25l3.5-3.5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8.25L20.5 11.75l-3.5 3.5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.5v13"></path></svg>
        Kembali ke Sekolah
    </a>
</div>

<div class="mb-10">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Cabang</h3> {{-- Consistent heading style --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100"> {{-- Consistent table container styling --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold"> {{-- Consistent table header styling --}}
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Nama Cabang</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200">Alamat</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100"> {{-- Consistent table body divider --}}
                    @forelse ($branches as $index => $branch)
                        <tr class="hover:bg-blue-50 transition-colors duration-150"> {{-- Consistent row hover effect --}}
                            <td class="px-6 py-4">{{ $branches->firstItem() + $index }}</td> {{-- Increased padding --}}
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $branch->name }}</td> {{-- Increased padding --}}
                            <td class="px-6 py-4 text-gray-700">{{ $branch->address ?? '-' }}</td> {{-- Increased padding --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="inline-flex space-x-2"> {{-- Group action buttons --}}
                                    <a href="{{ route('shared.branches.edit', $branch->id) }}" title="Edit Cabang"
                                       class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center"> {{-- Consistent button styling with icons --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                    </a>
                                    <form action="{{ route('shared.branches.destroy', $branch->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data cabang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Cabang"
                                                class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data cabang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600"> {{-- Consistent pagination info styling --}}
        <p>
            Menampilkan <span class="font-semibold">{{ $branches->firstItem() }}</span> - <span class="font-semibold">{{ $branches->lastItem() }}</span> dari <span class="font-semibold">{{ $branches->total() }}</span> cabang
        </p>
        <div>
            {{ $branches->appends(request()->query())->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection