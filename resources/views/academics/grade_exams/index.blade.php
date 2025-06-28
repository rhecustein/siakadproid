@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h3 class="text-2xl font-semibold mb-6">Pendataan Nilai Ujian Tengah / Akhir</h3>

    <form method="GET" action="{{ route('academic.grade-exams.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <select name="classroom_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">Semua Kelas</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="subject_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">Semua Mapel</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="exam_type_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">Jenis Ujian</option>
                    @foreach ($examTypes as $type)
                        <option value="{{ $type->id }}" {{ request('exam_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="academic_year_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">Tahun Ajaran</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 overflow-x-auto">
        <table class="w-full table-auto border border-gray-200 rounded-md">
            <thead class="bg-gray-100 text-left text-sm font-semibold">
                <tr>
                    <th class="border px-3 py-2">Siswa</th>
                    <th class="border px-3 py-2">Kelas</th>
                    <th class="border px-3 py-2">Mapel</th>
                    <th class="border px-3 py-2">Jenis Ujian</th>
                    <th class="border px-3 py-2">Nilai</th>
                    <th class="border px-3 py-2">Tahun Ajaran</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gradeExams as $item)
                    <tr class="text-sm">
                        <td class="border px-3 py-2">{{ $item->student->name }}</td>
                        <td class="border px-3 py-2">{{ $item->student->classroom->name }}</td>
                        <td class="border px-3 py-2">{{ $item->subject->name }}</td>
                        <td class="border px-3 py-2">{{ $item->examType->name }}</td>
                        <td class="border px-3 py-2">{{ $item->grade }}</td>
                        <td class="border px-3 py-2">{{ $item->academicYear->name }}</td>
                        <td class="border px-3 py-2 space-x-2">
                            <a href="{{ route('grade-exams.edit', $item->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <a href="{{ route('grade-exams.show', $item->id) }}"
                               class="text-green-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada data nilai ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
