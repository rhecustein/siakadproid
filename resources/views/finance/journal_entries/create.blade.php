@extends('layouts.app')

@section('title', 'Tambah Jurnal Umum')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tambah Jurnal Umum</h1>
        <p class="text-gray-600">Silakan isi detail jurnal berikut. Pastikan total debit = total kredit.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
            <ul class="text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('finance.journal-entries.store') }}" method="POST">
        @csrf

        {{-- Tanggal --}}
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                   class="w-full border rounded px-3 py-2 mt-1">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border rounded px-3 py-2 mt-1">{{ old('description') }}</textarea>
        </div>

        {{-- Baris Jurnal --}}
        <h2 class="text-lg font-semibold mb-2">Baris Jurnal</h2>

        <div id="journal-lines">
            @php $lines = old('lines', [['account_code'=>'', 'account_name'=>'', 'debit'=>'', 'credit'=>'']]); @endphp
            @foreach ($lines as $i => $line)
                <div class="grid grid-cols-6 gap-4 mb-2">
                    <input type="text" name="lines[{{ $i }}][account_code]" placeholder="Kode Akun"
                           class="col-span-1 border rounded px-2 py-1" value="{{ $line['account_code'] }}">
                    <input type="text" name="lines[{{ $i }}][account_name]" placeholder="Nama Akun"
                           class="col-span-2 border rounded px-2 py-1" value="{{ $line['account_name'] }}">
                    <input type="number" step="0.01" name="lines[{{ $i }}][debit]" placeholder="Debit"
                           class="col-span-1 border rounded px-2 py-1" value="{{ $line['debit'] }}">
                    <input type="number" step="0.01" name="lines[{{ $i }}][credit]" placeholder="Kredit"
                           class="col-span-1 border rounded px-2 py-1" value="{{ $line['credit'] }}">
                    <input type="text" name="lines[{{ $i }}][note]" placeholder="Catatan"
                           class="col-span-1 border rounded px-2 py-1" value="{{ $line['note'] ?? '' }}">
                </div>
            @endforeach
        </div>

        {{-- Tombol Tambah Baris --}}
        <div class="mb-4">
            <button type="button" onclick="addLine()" class="text-sm text-blue-600 hover:underline">
                + Tambah Baris Jurnal
            </button>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end">
            <a href="{{ route('finance.journal-entries.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Jurnal</button>
        </div>
    </form>
</div>

{{-- Template baris baru --}}
<template id="line-template">
    <div class="grid grid-cols-6 gap-4 mb-2">
        <input type="text" name="__REPLACE__[account_code]" placeholder="Kode Akun" class="col-span-1 border rounded px-2 py-1">
        <input type="text" name="__REPLACE__[account_name]" placeholder="Nama Akun" class="col-span-2 border rounded px-2 py-1">
        <input type="number" step="0.01" name="__REPLACE__[debit]" placeholder="Debit" class="col-span-1 border rounded px-2 py-1">
        <input type="number" step="0.01" name="__REPLACE__[credit]" placeholder="Kredit" class="col-span-1 border rounded px-2 py-1">
        <input type="text" name="__REPLACE__[note]" placeholder="Catatan" class="col-span-1 border rounded px-2 py-1">
    </div>
</template>

{{-- JS Add Line --}}
<script>
    let lineIndex = {{ count($lines) }};
    function addLine() {
        const tmpl = document.querySelector('#line-template').innerHTML;
        const replaced = tmpl.replace(/__REPLACE__/g, `lines[${lineIndex}]`);
        document.querySelector('#journal-lines').insertAdjacentHTML('beforeend', replaced);
        lineIndex++;
    }
</script>
@endsection
