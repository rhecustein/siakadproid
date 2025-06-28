@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Daftar Ruangan Kelas
    </h1>
    <p class="text-gray-600 text-base">Semua ruangan kelas yang terdaftar dalam sistem.</p>
</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
    <form method="GET" class="flex flex-col md:flex-row md:items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama ruangan kelas..."
               class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm" />

        <select name="level_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
            <option value="">Semua Jenjang</option>
            @foreach ($levels as $level)
                <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
            @endforeach
        </select>

        <select name="academic_year_id" class="rounded-lg px-4 py-2.5 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm appearance-none bg-white pr-8">
            <option value="">Semua Tahun Ajaran</option>
            @foreach ($academicYears as $year)
                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option> {{-- Assuming $year->name for academic year --}}
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter
        </button>
        <a href="{{ route('academic.classrooms.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 13a8 8 0 00-6.762-7.948m-7.058 1.948A8.001 8.001 0 003 13a8 8 0 006.762 7.948m-7.058-1.948h-3v-5m3 5h3"></path></svg>
            Reset
        </a>
    </form>
</div>

<div class="flex justify-end mb-8">
    <a href="{{ route('academic.classrooms.create') }}"
       class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-md hover:bg-green-700 transition-colors duration-200 flex items-center gap-1 min-w-max">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Ruangan Kelas
    </a>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Nama Ruangan Kelas</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Jenjang</th> {{-- Changed from 'Kelas' to 'Jenjang' --}}
                    <th class="px-6 py-3 border-b-2 border-gray-200">Tahun Ajaran</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Kurikulum</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200">Ruangan Fisik</th> {{-- Changed from 'Keterangan' to 'Ruangan Fisik' --}}
                    <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($classrooms as $index => $classroom)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4">{{ $classrooms->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $classroom->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $classroom->level->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $classroom->academicYear->name ?? '—' }}</td> {{-- Changed from $year->year to $year->name --}}
                        <td class="px-6 py-4 text-gray-700">{{ $classroom->curriculum->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $classroom->room->name ?? '—' }}</td> {{-- Changed from $classroom->room to $classroom->room->name --}}
                        <td class="px-6 py-4">
                            @if ($classroom->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="inline-flex space-x-2">
                                <a href="{{ route('academic.classrooms.edit', $classroom->id) }}" title="Edit Ruangan Kelas"
                                   class="p-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-150 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"></path></svg>
                                </a>
                                <form action="{{ route('academic.classrooms.destroy', $classroom->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus ruangan kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Ruangan Kelas"
                                            class="p-2 text-xs font-semibold text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-150 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data ruangan kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
        Menampilkan <span class="font-semibold">{{ $classrooms->firstItem() }}</span> – <span class="font-semibold">{{ $classrooms->lastItem() }}</span> dari total <span class="font-semibold">{{ $classrooms->total() }}</span> ruangan kelas
    </p>
    <div>
        {{ $classrooms->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>
@endsection