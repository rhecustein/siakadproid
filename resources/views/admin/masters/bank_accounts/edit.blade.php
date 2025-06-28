@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">Edit Bank Account</h2>
  <p class="text-sm text-gray-500">Update details of the selected bank account.</p>
</div>

<div class="bg-white shadow rounded-xl p-6">
  <form action="{{ route('finance.bank-accounts.update', $account->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Account Number</label>
        <input type="text" name="account_number" value="{{ old('account_number', $account->account_number) }}"
               class="form-input w-full" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Account Holder</label>
        <input type="text" name="account_holder" value="{{ old('account_holder', $account->account_holder) }}"
               class="form-input w-full" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Bank Name</label>
        <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name) }}"
               class="form-input w-full" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Bank Code</label>
        <input type="text" name="bank_code" value="{{ old('bank_code', $account->bank_code) }}"
               class="form-input w-full">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">School</label>
        <input type="text" name="school" value="{{ old('school', $account->school) }}"
               class="form-input w-full">
      </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
      @foreach ([
        'online_payment' => 'Online Payment',
        'for_students' => 'For Students',
        'for_teachers' => 'For Teachers',
        'for_male' => 'Male',
        'for_female' => 'Female',
        'can_pay_bills' => 'For Bills',
        'can_save' => 'For Savings',
        'can_donate' => 'For Donation',
      ] as $name => $label)
      <div class="flex items-center">
        <input type="checkbox" name="{{ $name }}" value="1" class="mr-2"
               {{ old($name, $account->$name) ? 'checked' : '' }}>
        <label>{{ $label }}</label>
      </div>
      @endforeach
    </div>

    <div class="flex items-center">
      <input type="checkbox" name="is_active" value="1" class="mr-2"
             {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
      <label>Active</label>
    </div>

    <div class="flex justify-between items-center">
      <a href="{{ route('finance.bank-accounts.index') }}" class="text-sm text-gray-600 hover:underline">← Back</a>
      <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        Update Account
      </button>
    </div>
  </form>
</div>
@endsection
