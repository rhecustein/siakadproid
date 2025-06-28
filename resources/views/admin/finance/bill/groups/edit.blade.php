@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">Edit Grup Tagihan</h1>
        <a href="{{ route('finance.bill-groups.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('finance.bill-groups.update', $billGroup->id) }}" method="POST" class="bg-white shadow rounded p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Tagihan</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                    @foreach(App\Models\BillGroup::TYPES as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $billGroup->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Tagihan</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2"
                       value="{{ old('name', $billGroup->name) }}" required>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Sekolah</label>
                <select name="school_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id', $billGroup->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Level / Kelas</label>
                <select name="level_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Level --</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $billGroup->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
                <input type="text" name="academic_year" class="w-full border rounded px-3 py-2"
                       value="{{ old('academic_year', $billGroup->academic_year) }}" placeholder="cth: 2024-2025">
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">-- Semua --</option>
                    <option value="male" {{ old('gender', $billGroup->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $billGroup->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Tagihan</label>
                <input type="number" name="tagihan_count" class="w-full border rounded px-3 py-2"
                       value="{{ old('tagihan_count', $billGroup->tagihan_count) }}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nominal / Tagihan (Rp)</label>
                <input type="number" name="amount_per_tagihan" class="w-full border rounded px-3 py-2"
                       value="{{ old('amount_per_tagihan', $billGroup->amount_per_tagihan) }}" step="1000">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border rounded px-3 py-2"
    value="{{ old('start_date', $billGroup->start_date ? \Carbon\Carbon::parse($billGroup->start_date)->format('Y-m-d') : '') }}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border rounded px-3 py-2"
    value="{{ old('end_date', $billGroup->end_date ? \Carbon\Carbon::parse($billGroup->end_date)->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $billGroup->description) }}</textarea>
        </div>

        <div class="text-right pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
