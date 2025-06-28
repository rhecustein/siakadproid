@extends('layouts.app')

@section('title', 'Input Penilaian Harian')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Input Penilaian Harian</h2>

    <form action="{{ route('academic.daily-assessments.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="mt-1 w-full rounded border-gray-300">
                    <option value="">-- Pilih --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="classroom_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="classroom_id" id="classroom_id" class="mt-1 w-full rounded border-gray-300">
                    <option value="">-- Pilih --</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="date" id="date"
                       class="mt-1 w-full rounded border-gray-300" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        @if(isset($students) && count($students))
        <div class="bg-white shadow rounded-md p-4">
            <h3 class="text-md font-semibold mb-4 text-gray-800">Daftar Siswa</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama Siswa</th>
                            <th class="px-4 py-2">Nilai</th>
                            <th class="px-4 py-2">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $student->name }}</td>
                            <td class="px-4 py-2">
                                <input type="number" name="scores[{{ $student->id }}][score]" step="0.01"
                                       class="w-24 rounded border-gray-300">
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" name="scores[{{ $student->id }}][description]"
                                       class="w-full rounded border-gray-300">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="mt-6 text-right">
            <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Simpan Nilai
            </button>
        </div>
    </form>
</div>
@endsection
