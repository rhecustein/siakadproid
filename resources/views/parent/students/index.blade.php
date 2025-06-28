@extends('layouts.app')

@section('title', 'My Children')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Children</h2>
        <a href="{{ route('parent.students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Child</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
    @forelse($children as $child)
      <div class="bg-white shadow-md rounded-xl p-6 flex flex-col sm:flex-row gap-6 border-l-4 {{ $child->gender === 'L' ? 'border-blue-500' : 'border-pink-500' }} max-w-4xl w-full hover:shadow-lg transition">
    <!-- Avatar -->
    <img src="{{ $child->photo ? asset('storage/' . $child->photo) : asset('images/avatar-' . strtolower($child->gender ?? 'n') . '.png') }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Header Info -->
        <div class="flex justify-between items-start">
            <div>
                <div class="text-2xl font-bold text-gray-800">
                    {{ $child->name }} <span class="text-base text-gray-500">({{ $child->nis ?? '-' }})</span>
                </div>
                <div class="text-sm text-gray-600 mt-1">Class: {{ $child->grade->name ?? '-' }} - {{ $child->school->name ?? '-' }}</div>
                <div class="text-sm text-gray-500">Phone: {{ $child->phone ?? '-' }}</div>
                <div class="text-sm text-gray-500 mt-1">Status: 
                    <span class="font-semibold {{ $child->student_status == 'aktif' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ ucfirst($child->student_status) }}
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col space-y-2">
                <a href="{{ route('parent.students.show', $child->id) }}" class="text-blue-600 hover:text-blue-800" title="View">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
                <a href="{{ route('parent.students.edit', $child->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Academic, Attendance & Score Summary -->
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-md">
                <div class="text-sm text-blue-800 font-medium">Semester Attendance</div>
                <div class="text-lg font-bold text-blue-900">
                    {{ $child->attendance_semester_percentage ?? 0 }}%
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-md">
                <div class="text-sm text-green-800 font-medium">Overall Attendance</div>
                <div class="text-lg font-bold text-green-900">
                    {{ $child->attendance_total_percentage ?? 0 }}%
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-md">
                <div class="text-sm text-purple-800 font-medium">Average Score</div>
                <div class="text-lg font-bold text-purple-900">
                    {{ $child->average_score ?? '-' }}
                </div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-md">
                <div class="text-sm text-yellow-800 font-medium">Class Ranking</div>
                <div class="text-lg font-bold text-yellow-900">
                    #{{ $child->class_rank ?? '-' }}
                </div>
            </div>
            <div class="bg-pink-50 p-4 rounded-md">
                <div class="text-sm text-pink-800 font-medium">Total Points</div>
                <div class="text-lg font-bold text-pink-900">
                    {{ $child->total_points ?? '0' }}
                </div>
            </div>
            <div class="bg-amber-50 p-4 rounded-md">
                <div class="text-sm text-amber-800 font-medium">Point Status</div>
                <div class="text-lg font-bold text-amber-900">
                    {{ $child->point_category ?? 'Cukup' }}
                </div>
            </div>
            <div class="bg-indigo-50 p-4 rounded-md col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="text-sm text-indigo-800 font-medium mb-1">Top Subjects</div>
                <div class="text-sm text-gray-700">
                    @foreach(($child->top_subjects ?? []) as $subject)
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full mr-2 mb-2">{{ $subject }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 mt-4 pt-4">
            <!-- Achievements -->
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Achievements</h4>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                <li><span class="mr-2">🏆</span> Juara 1 Olimpiade Matematika</li>
                <li><span class="mr-2">🎖️</span> Hafalan 5 Juz Al-Qur'an</li>
                <li><span class="mr-2">🥇</span> Lomba Tahfidz Nasional</li>
            </ul>
        </div>

        <!-- Additional Actions -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('parent.messages.index', $child->id) }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-md hover:bg-sky-700">
                💬 Inbox Wali Kelas
            </a>
            <a href="{{ route('parent.permissions.create', $child->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                📝 Buat Izin Pulang
            </a>
        </div>
    </div>
</div>



    @empty
        <div class="col-span-full text-center text-gray-500">
            No children data found.
        </div>
    @endforelse
</div>

</div>
@endsection
