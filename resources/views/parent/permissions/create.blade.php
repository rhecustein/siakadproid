@extends('layouts.app')

@section('title', 'Buat Izin Pulang')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Formulir Izin Pulang</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('parent.permissions.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        <input type="hidden" name="child_id" value="{{ $childId }}">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Pulang</label>
            <input type="date" name="leave_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
            <input type="date" name="return_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alasan</label>
            <textarea name="reason" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Kirim Izin</button>
        </div>
    </form>
</div>
@endsection
