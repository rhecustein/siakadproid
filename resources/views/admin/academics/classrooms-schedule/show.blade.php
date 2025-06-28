@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-xl p-6 space-y-6">
  <h2 class="text-xl font-bold text-blue-700 mb-4">Classroom Details</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
      <p class="text-gray-500">Name</p>
      <p class="font-medium text-gray-900">{{ $classroom->name }}</p>
    </div>
    <div>
      <p class="text-gray-500">Alias</p>
      <p class="font-medium text-gray-900">{{ $classroom->alias ?? '-' }}</p>
    </div>
    <div>
      <p class="text-gray-500">Level</p>
      <p class="font-medium text-gray-900">{{ $classroom->level->name ?? '-' }}</p>
    </div>
    <div>
      <p class="text-gray-500">Academic Year</p>
      <p class="font-medium text-gray-900">{{ $classroom->academicYear->name ?? '-' }}</p>
    </div>
    <div>
      <p class="text-gray-500">Curriculum</p>
      <p class="font-medium text-gray-900">{{ $classroom->curriculum->name ?? '-' }}</p>
    </div>
    <div>
      <p class="text-gray-500">Room</p>
      <p class="font-medium text-gray-900">{{ $classroom->room ?? '-' }}</p>
    </div>
    <div>
      <p class="text-gray-500">Order</p>
      <p class="font-medium text-gray-900">{{ $classroom->order }}</p>
    </div>
    <div>
      <p class="text-gray-500">Status</p>
      <p class="font-medium {{ $classroom->is_active ? 'text-green-600' : 'text-red-600' }}">
        {{ $classroom->is_active ? 'Active' : 'Inactive' }}
      </p>
    </div>
  </div>

  <div class="pt-4">
    <a href="{{ route('academic.classrooms-schedule.index') }}"
       class="text-sm text-blue-600 hover:underline">&larr; Back to list</a>
  </div>
</div>
@endsection