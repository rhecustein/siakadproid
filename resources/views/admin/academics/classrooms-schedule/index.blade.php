@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Classroom & Schedule Management</h2>
    <p class="text-sm text-gray-500">Manage all classrooms and their subject schedules.</p>
  </div>

  @if (session('success'))
    <div class="mb-6 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
      <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Summary Cards --> 
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    @php $cardStyles = 'bg-white border-l-4 rounded-xl px-4 py-3 shadow hover:scale-[1.01] transition'; @endphp

    <div class="{{ $cardStyles }} border-blue-500">
      <p class="text-xs text-gray-500">Total Classrooms</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['classrooms'] ?? 0 }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-emerald-500">
      <p class="text-xs text-gray-500">Total Schedules</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['schedules'] ?? 0 }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-indigo-500">
      <p class="text-xs text-gray-500">Active Levels</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['levels'] ?? 0 }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-pink-500">
      <p class="text-xs text-gray-500">Subjects</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['subjects'] ?? 0 }}</h3>
    </div>
  </div>

  <!-- Tabs -->
  <div>
    <div class="mb-4 border-b border-gray-200">
      <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs" role="tablist">
        <li class="me-2">
          <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-classrooms" data-tab="classrooms" type="button">Classrooms</button>
        </li>
        <li class="me-2">
          <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-schedule" data-tab="schedule" type="button">Schedule</button>
        </li>
      </ul>
    </div>
    <div>
      <div id="content-classrooms">
        @include('admin.academics.classrooms-schedule._tab_classrooms')
      </div>
      <div id="content-schedule" class="hidden">
        @include('admin.academics.classrooms-schedule._tab_schedule')
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tabs = document.querySelectorAll('[data-tab]');
      const contents = {
        'classrooms': document.getElementById('content-classrooms'),
        'schedule': document.getElementById('content-schedule')
      };

      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('border-blue-500', 'text-blue-600'));
          tab.classList.add('border-blue-500', 'text-blue-600');

          Object.values(contents).forEach(c => c.classList.add('hidden'));
          contents[tab.dataset.tab].classList.remove('hidden');
        });
      });

      // Set default tab
      document.getElementById('tab-classrooms').click();
    });
  </script>
@endsection