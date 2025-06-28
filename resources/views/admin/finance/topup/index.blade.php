@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Top-Up Transactions</h1>
        <a href="{{ route('finance.topups.create') }}"
           class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
            + Manual Top-Up
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('finance.topups.index') }}" class="bg-white shadow rounded p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Owner Name</label>
                <input type="text" name="name" value="{{ request('name') }}"
                       class="w-full border rounded px-3 py-2" placeholder="Search by name...">
            </div>
            <div>
                <label class="block text-sm font-medium">Channel</label>
                <select name="channel" class="w-full border rounded px-3 py-2">
                    <option value="">All</option>
                    <option value="manual" {{ request('channel') == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="va_bank" {{ request('channel') == 'va_bank' ? 'selected' : '' }}>VA Bank</option>
                    <option value="gateway" {{ request('channel') == 'gateway' ? 'selected' : '' }}>Gateway</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">All</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Date From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Date To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-3">Recent Top-Ups</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left text-xs font-semibold uppercase">
                        <th class="py-2 px-3 border">Date</th>
                        <th class="py-2 px-3 border">Owner</th>
                        <th class="py-2 px-3 border">Amount</th>
                        <th class="py-2 px-3 border">Channel</th>
                        <th class="py-2 px-3 border">Status</th>
                        <th class="py-2 px-3 border">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topups as $tx)
                        <tr class="border-t">
                            <td class="py-2 px-3">{{ $tx->created_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-3">{{ $tx->wallet->owner->name ?? '-' }}</td>
                            <td class="py-2 px-3">Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                            <td class="py-2 px-3 capitalize">{{ $tx->channel }}</td>
                            <td class="py-2 px-3">
                                <span class="
                                    px-2 py-1 rounded text-xs font-medium
                                    {{ $tx->status === 'success' ? 'bg-green-100 text-green-800' :
                                       ($tx->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">{{ $tx->description ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-500">No top-up transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $topups->appends(request()->all())->links() }}
        </div>
    </div>
</div>
@endsection
