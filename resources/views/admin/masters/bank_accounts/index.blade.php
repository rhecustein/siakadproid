@extends('layouts.app')

@section('content')
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-bold text-blue-700">Bank Accounts</h2>
      <p class="text-sm text-gray-500">List of bank accounts used for school payments and donations.</p>
    </div>
    <a href="{{ route('finance.bank-accounts.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
      + Add Account
    </a>
  </div>

  @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white shadow rounded-xl">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr class="text-sm font-semibold text-gray-700 text-left">
          <th class="px-6 py-3">Account Number</th>
          <th class="px-6 py-3">Holder</th>
          <th class="px-6 py-3">Bank</th>
          <th class="px-6 py-3">School</th>
          <th class="px-6 py-3">Uses</th>
          <th class="px-6 py-3">Active</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 text-sm">
        @forelse ($accounts as $account)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3">{{ $account->account_number }}</td>
            <td class="px-6 py-3">{{ $account->account_holder }}</td>
            <td class="px-6 py-3">{{ $account->bank_name }} <span class="text-xs text-gray-400">({{ $account->bank_code }})</span></td>
            <td class="px-6 py-3">{{ $account->school ?? '-' }}</td>
           <td class="px-6 py-3 space-x-1">
                @if($account->online_payment)
                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Online</span>
                @endif
                @if($account->can_pay_bills)
                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Bills</span>
                @endif
                @if($account->can_save)
                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">Savings</span>
                @endif
                @if($account->can_donate)
                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">Donation</span>
                @endif
                </td>
            <td class="px-6 py-3">
              @if ($account->is_active)
                <span class="text-green-600 font-semibold">Yes</span>
              @else
                <span class="text-gray-400">No</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center space-x-2">
              <a href="{{ route('finance.bank-accounts.edit', $account->id) }}"
                 class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('finance.bank-accounts.destroy', $account->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Are you sure you want to delete this account?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center py-6 text-gray-400">No bank accounts found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $accounts->links() }}
  </div>
@endsection
