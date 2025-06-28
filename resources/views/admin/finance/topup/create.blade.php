@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manual Top-Up</h1>
        <a href="{{ route('finance.topups.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← Back to Top-Up List
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form & Preview Panel --}}
    <form method="POST" action="{{ route('finance.topups.store') }}" enctype="multipart/form-data"
          class="grid md:grid-cols-2 gap-6">
        @csrf

        {{-- Left Column: Form --}}
        <div class="bg-white shadow rounded p-6 space-y-5">

            {{-- Select Wallet --}}
            <div>
                <label class="block text-sm font-medium mb-1">Select Wallet <span class="text-red-500">*</span></label>
                <select name="wallet_id" id="walletSelect" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Choose Wallet --</option>
                    @foreach($wallets as $wallet)
                        <option value="{{ $wallet->id }}"
                            data-name="{{ $wallet->owner->name ?? '-' }}"
                            data-uuid="{{ $wallet->uuid }}"
                            data-balance="{{ $wallet->balance }}"
                            {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                            {{ $wallet->owner->name ?? '-' }} ({{ $wallet->uuid }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Amount --}}
            <div>
                <label class="block text-sm font-medium mb-1">Amount (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="amount" id="amountInput"
                       class="w-full border rounded px-3 py-2" min="1000" step="1000"
                       value="{{ old('amount') }}" placeholder="e.g. 50000" required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <input type="text" name="description"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('description') }}" placeholder="Optional note...">
            </div>

            {{-- Receipt File Upload --}}
            <div>
                <label class="block text-sm font-medium mb-1">Upload Transfer Proof (JPG, PNG, PDF)</label>
                <input type="file" name="receipt"
                       class="w-full border rounded px-3 py-2 file:border-none file:bg-blue-100 file:text-sm"
                       accept=".jpg,.jpeg,.png,.pdf">
                <p class="text-xs text-gray-500 mt-1">Max 2MB</p>
            </div>

            {{-- Submit --}}
            <div class="text-right pt-4">
                <button type="submit"
                        class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition">
                    Submit Top-Up
                </button>
            </div>
        </div>

        {{-- Right Column: Confirmation Panel --}}
        <div class="bg-gray-50 shadow-inner rounded p-6 space-y-4">
            <h2 class="text-lg font-semibold mb-2 border-b pb-2">Confirmation Panel</h2>

            <div class="text-sm space-y-2">
                <div><strong>Recipient Name:</strong> <span id="previewName" class="text-gray-700">-</span></div>
                <div><strong>Wallet UUID:</strong> <span id="previewUUID" class="text-gray-700">-</span></div>
                <div><strong>Current Balance:</strong> Rp <span id="previewBalance" class="text-gray-700">0</span></div>
                <div><strong>Top-Up Amount:</strong> Rp <span id="previewAmount" class="text-gray-700">0</span></div>
                <hr>
                <div class="text-green-800 font-semibold">
                    <strong>Balance After:</strong> Rp <span id="previewTotal" class="text-green-900">0</span>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Preview Logic --}}
<script>
    const walletSelect = document.getElementById('walletSelect');
    const amountInput = document.getElementById('amountInput');

    function updatePreview() {
        const selected = walletSelect.options[walletSelect.selectedIndex];
        const name = selected.getAttribute('data-name') || '-';
        const uuid = selected.getAttribute('data-uuid') || '-';
        const balance = parseInt(selected.getAttribute('data-balance')) || 0;
        const amount = parseInt(amountInput.value) || 0;

        document.getElementById('previewName').textContent = name;
        document.getElementById('previewUUID').textContent = uuid;
        document.getElementById('previewBalance').textContent = balance.toLocaleString();
        document.getElementById('previewAmount').textContent = amount.toLocaleString();
        document.getElementById('previewTotal').textContent = (balance + amount).toLocaleString();
    }

    walletSelect.addEventListener('change', updatePreview);
    amountInput.addEventListener('input', updatePreview);

    window.addEventListener('DOMContentLoaded', updatePreview);
</script>
@endsection
