@props(['type' => 'success', 'message'])

@php
  $types = [
      'success' => ['bg' => 'bg-emerald-100', 'border' => 'border-emerald-300', 'text' => 'text-emerald-800'],
      'error' => ['bg' => 'bg-red-100', 'border' => 'border-red-300', 'text' => 'text-red-800'],
      'warning' => ['bg' => 'bg-yellow-100', 'border' => 'border-yellow-300', 'text' => 'text-yellow-800'],
      'info' => ['bg' => 'bg-blue-100', 'border' => 'border-blue-300', 'text' => 'text-blue-800'],
  ];
  $style = $types[$type] ?? $types['success'];
@endphp

<div class="mb-4 px-4 py-3 rounded-lg shadow {{ $style['bg'] }} {{ $style['border'] }} {{ $style['text'] }}">
  {{ $message }}
</div>
