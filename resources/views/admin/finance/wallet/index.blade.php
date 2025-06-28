@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Wallet Overview</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white shadow rounded p-4">
        <div class="text-gray-500 text-sm">Total Wallet Balance</div>
        <div class="text-xl font-bold text-green-700">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white shadow rounded p-4">
        <div class="text-gray-500 text-sm">Today's Transactions</div>
        <div class="text-xl font-bold text-blue-700">Rp {{ number_format($totalTodayTransactions, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white shadow rounded p-4">
        <div class="text-gray-500 text-sm">Pending Transactions</div>
        <div class="text-xl font-bold text-yellow-600">Rp {{ number_format($totalPending, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white shadow rounded p-4">
        <div class="text-gray-500 text-sm">Active Wallets</div>
        <div class="text-xl font-bold text-gray-800">{{ $totalActiveWallet }}</div>
    </div>
</div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('finance.wallets.index') }}" class="bg-white shadow rounded p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="">All</option>
                    <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Parent</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Owner Name</label>
                <input type="text" name="name" value="{{ request('name') }}" class="w-full border rounded px-3 py-2" placeholder="Search name...">
            </div>
            <div>
                <label class="block text-sm font-medium">Min Balance</label>
                <input type="number" name="min" value="{{ request('min') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Max Balance</label>
                <input type="number" name="max" value="{{ request('max') }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>
        <div class="mt-4 text-right">
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Filter</button>
        </div>
    </form>

    <!-- Wallet Table -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-3">Wallet List</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-3 border">Owner Name</th>
                        <th class="py-2 px-3 border">Role</th>
                        <th class="py-2 px-3 border">Wallet ID</th>
                        <th class="py-2 px-3 border">Balance</th>
                        <th class="py-2 px-3 border">Last Updated</th>
                        <th class="py-2 px-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($wallets as $wallet)
    <tr class="border-t">
        <td class="py-2 px-3">{{ $wallet->owner->name ?? '-' }}</td>

        <td class="py-2 px-3">
            @php
                $roleName = match(optional($wallet->owner->user)->role_id) {
                    9 => 'Student',
                    10 => 'Parent',
                    default => '-'
                };
            @endphp
            <span class="inline-block px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                {{ $roleName }}
            </span>
        </td>

        <td class="py-2 px-3 font-mono text-sm text-gray-700">
            {{ $wallet->uuid }}
        </td>

        <td class="py-2 px-3 font-semibold text-green-700">
            Rp {{ number_format($wallet->balance, 0, ',', '.') }}
        </td>

        <td class="py-2 px-3 text-gray-500 text-sm">
            {{ $wallet->updated_at?->format('d M Y H:i') ?? '-' }}
        </td>

        <td class="py-2 px-3 flex flex-wrap gap-2">
            <a href="{{ route('finance.wallet.topup', $wallet->id) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                💰 Top-Up
            </a>

            <a href="{{ route('finance.wallet.transfer.multi', $wallet->id) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition">
                🔄 Transfer Multi
            </a>
             <a href="{{ route('finance.wallet.transfer', $wallet->id) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition">
                🔄 Transfer
            </a>

            <a href="{{ route('finance.wallet.transactions', $wallet->id) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full border border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white transition">
                📜 History
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-3 text-gray-500">No wallet data found.</td>
    </tr>
@endforelse


                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $wallets->appends(request()->all())->links() }}
        </div>
    </div>
</div>
@endsection
