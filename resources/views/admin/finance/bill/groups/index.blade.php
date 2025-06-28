@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Grup Tagihan</h1>
        <a href="{{ route('finance.bill-groups.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Tambah Grup
        </a>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4 text-sm">
        <input type="text" name="search" placeholder="Cari Nama Tagihan" value="{{ request('search') }}"
               class="border rounded px-3 py-2 w-full" />

        <select name="type" class="border rounded px-3 py-2 w-full">
            <option value="">Jenis Tagihan</option>
            @foreach(App\Models\BillGroup::TYPES as $key => $label)
                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <select name="school_id" class="border rounded px-3 py-2 w-full">
            <option value="">Semua Sekolah</option>
            @foreach($schools as $school)
                <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                    {{ $school->name }}
                </option>
            @endforeach
        </select>

        <select name="level_id" class="border rounded px-3 py-2 w-full">
            <option value="">Semua Level</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="academic_year" placeholder="Tahun Ajaran (cth: 2024-2025)"
               value="{{ request('academic_year') }}" class="border rounded px-3 py-2 w-full" />
    </form>

    {{-- Data Table --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Jenis</th>
                    <th class="p-3">Sekolah</th>
                    <th class="p-3">Jenjang</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">T.A.</th>
                    <th class="p-3">Gender</th>
                    <th class="p-3">Periode</th>
                    <th class="p-3">Nominal</th>
                    <th class="p-3">Periode</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($billGroups as $group)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($billGroups->currentPage() - 1) * $billGroups->perPage() }}</td>
                    <td class="p-3 font-semibold text-gray-800">{{ $group->name }}</td>
                    <td class="p-3 text-gray-600">{{ \App\Models\BillGroup::TYPES[$group->type] ?? $group->type }}</td>
                    <td class="p-3 text-gray-700">{{ $group->school->name ?? '-' }}</td>
                    <td class="p-3 text-gray-700">{{ $group->level->name ?? '-' }}</td>
                    <td class="p-3 text-gray-700">{{ $group->grade ?? '-' }}</td>
                    <td class="p-3 text-gray-700">{{ $group->academic_year ?? '-' }}</td>
                    <td class="p-3 text-gray-700 capitalize">
                        {{ $group->gender ? ($group->gender == 'male' ? 'Laki-laki' : 'Perempuan') : '-' }}
                    </td>
                    <td class="p-3 text-center">{{ $group->tagihan_count ?? '-' }}</td>
                    <td class="p-3 text-right">Rp {{ number_format($group->amount_per_tagihan, 0, ',', '.') }}</td>
                    <td class="p-3 text-gray-600">
                        @if($group->start_date)
                            {{ \Carbon\Carbon::parse($group->start_date)->format('d M Y') }}
                            - {{ \Carbon\Carbon::parse($group->end_date)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-3 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('finance.bill-groups.edit', $group->id) }}"
                            class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('finance.bill-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus grup ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="11" class="p-4 text-center text-gray-500">Tidak ada grup tagihan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $billGroups->withQueryString()->links() }}
    </div>
</div>
@endsection
