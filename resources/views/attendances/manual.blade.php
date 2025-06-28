@extends('layouts.app')

@section('title', 'Input Absensi Manual')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">

    <h1 class="text-xl font-bold mb-6">Input Absensi Manual</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @include('attendances._form', [
        'action' => route('core.attendances.store'),
        'method' => 'POST',
        'attendance' => null,
        'users' => $users,
        'units' => $units,
    ])

</div>
@endsection
