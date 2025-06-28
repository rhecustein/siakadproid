@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow space-y-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Jadwal Pendaftaran</h1>

    <form action="{{ route('admission-schedules.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Nama Jadwal (Gelombang 1, dst)" class="w-full border rounded px-3 py-2" required>
        <input type="date" name="start_date" class="w-full border rounded px-3 py-2" required>
        <input type="date" name="end_date" class="w-full border rounded px-3 py-2" required>

        <div class="text-right">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan Jadwal
            </button>
        </div>
    </form>
</div>
@endsection
