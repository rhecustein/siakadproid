@extends('layouts.app')

@section('content')
<div class="p-4 max-w-3xl mx-auto">
    <a href="{{ route('finance.wallets.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Kembali</a>

    <h1 class="text-xl font-bold mb-6">Transfer Saldo Multi-Tujuan</h1>

    <form action="{{ route('finance.wallet.transfer.multi.store', $wallet->id) }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1">Jenis Tujuan</label>
            <select name="destination_type" id="destination_type" class="w-full border p-2 rounded" onchange="toggleDestination()">
                <option value="">-- Pilih Tujuan --</option>
                <option value="tagihan">Tagihan Siswa</option>
                <option value="saldo_anak">Saldo Anak</option>
                <option value="donasi">Donasi</option>
            </select>
        </div>

        {{-- Tagihan --}}
        <div id="tagihan_fields" class="hidden space-y-2">
            <div>
                <label class="block font-medium mb-1">Pilih Siswa</label>
                <select name="target_id" class="w-full border p-2 rounded">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Bisa tambahkan dropdown tagihan jika ada --}}
        </div>

        {{-- Saldo Anak --}}
        <div id="saldo_fields" class="hidden space-y-2">
            <label class="block font-medium mb-1">Pilih Siswa (Wallet Tujuan)</label>
            <select name="target_id" class="w-full border p-2 rounded">
                @foreach($students as $student)
                    @php $walletId = $student->wallet->id ?? null; @endphp
                    @if($walletId)
                        <option value="{{ $walletId }}">{{ $student->name }} (ID Wallet: {{ $walletId }})</option>
                    @endif
                @endforeach
            </select>
        </div>

        {{-- Donasi --}}
        <div id="donasi_fields" class="hidden space-y-2">
            <label class="block font-medium mb-1">Kategori Donasi</label>
            <select name="target_id" class="w-full border p-2 rounded">
                @foreach($donationCategories as $key => $label)
                    <option value="{{ $key }}">{{ ucfirst($label) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Jumlah (Rp)</label>
            <input type="number" name="amount" min="1000" required class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="2"></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Transfer</button>
        </div>
    </form>
</div>

<script>
    function toggleDestination() {
        const type = document.getElementById('destination_type').value;
        document.getElementById('tagihan_fields').classList.add('hidden');
        document.getElementById('saldo_fields').classList.add('hidden');
        document.getElementById('donasi_fields').classList.add('hidden');

        if (type === 'tagihan') {
            document.getElementById('tagihan_fields').classList.remove('hidden');
        } else if (type === 'saldo_anak') {
            document.getElementById('saldo_fields').classList.remove('hidden');
        } else if (type === 'donasi') {
            document.getElementById('donasi_fields').classList.remove('hidden');
        }
    }
</script>
@endsection
