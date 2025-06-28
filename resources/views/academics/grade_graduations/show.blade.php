@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kelulusan</h1>
        <a href="{{ route('grade-graduations.index') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="border-b md:border-b-0 pb-4 md:pb-0">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Siswa</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                        <p class="font-medium">{{ $grade_graduation->student->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">NIS</p>
                        <p class="font-medium">{{ $grade_graduation->student->nis }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Kelulusan</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Lulus</p>
                        <p class="font-medium">{{ $grade_graduation->graduation_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nomor Sertifikat</p>
                        <p class="font-medium">{{ $grade_graduation->certificate_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada</p>
                        <p class="font-medium">{{ $grade_graduation->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notes Section -->
        @if($grade_graduation->notes)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Catatan</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700">{{ $grade_graduation->notes }}</p>
            </div>
        </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('grade-graduations.edit', $grade_graduation->id) }}" 
               class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('grade-graduations.destroy', $grade_graduation->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 flex items-center"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data kelulusan ini?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection