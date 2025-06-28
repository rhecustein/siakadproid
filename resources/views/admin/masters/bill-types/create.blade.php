@extends('layouts.app')

@section('content')
<div class="mb-6">
  <h2 class="text-2xl font-bold text-blue-700">{{ isset($billType) ? 'Edit' : 'Add' }} Bill Type</h2>
</div>

<div class="bg-white shadow rounded-xl p-6">
  <form method="POST"
        action="{{ isset($billType) ? route('finance.bill-types.update', $billType->id) : route('finance.bill-types.store') }}">
    @csrf
    @if(isset($billType)) @method('PUT') @endif

    <div class="space-y-4">
      <div>
        <label class="block text-sm text-gray-700">Name</label>
        <input type="text" name="name" required class="form-input w-full"
               value="{{ old('name', $billType->name ?? '') }}">
      </div>

      <div>
        <label class="block text-sm text-gray-700">Code</label>
        <input type="text" name="code" required class="form-input w-full"
               value="{{ old('code', $billType->code ?? '') }}">
      </div>

      <div>
        <label class="block text-sm text-gray-700">Description</label>
        <textarea name="description" rows="3" class="form-textarea w-full"
                  placeholder="Optional">{{ old('description', $billType->description ?? '') }}</textarea>
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="is_active" value="1" class="mr-2"
               {{ old('is_active', $billType->is_active ?? true) ? 'checked' : '' }}>
        <label>Active</label>
      </div>
    </div>

    <div class="mt-6 flex justify-between">
      <a href="{{ route('finance.bill-types.index') }}" class="text-sm text-gray-600 hover:underline">← Back</a>
      <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        {{ isset($billType) ? 'Update' : 'Save' }}
      </button>
    </div>
  </form>
</div>
@endsection
