@extends('layouts.app')

@section('content')
<div class="p-4">
    <a href="{{ route('finance.wallets.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Kembali ke Riwayat</a>

    <h1 class="text-xl font-bold mb-6 text-gray-800">Tambah Transfer Multi-Tujuan</h1>

    <form action="{{ route('finance.wallet.transfer.multi.store', $wallet->id) }}" method="POST" class="grid md:grid-cols-3 gap-6">
        @csrf

        {{-- LEFT SIDE: FORM INPUT --}}
        <div class="bg-white shadow rounded p-6 space-y-4 md:col-span-2">
            <div>
                <label class="block font-medium mb-1">Jenis Tujuan</label>
                <select name="destination_type" id="destination_type" class="w-full border p-2 rounded" onchange="toggleFields(); updateSummary();">
                    <option value="">-- Pilih Jenis Tujuan --</option>
                    <option value="tagihan">Tagihan Siswa</option>
                    <option value="saldo_anak">Saldo Anak</option>
                    <option value="donasi">Donasi</option>
                </select>
            </div>

            {{-- Tagihan --}}
            <div id="tagihan_fields" class="hidden">
                <label class="block font-medium mb-1">Pilih Siswa</label>
                <select name="target_id" class="w-full border p-2 rounded" onchange="updateSummary(this)">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Saldo Anak --}}
            <div id="saldo_fields" class="hidden">
                <label class="block font-medium mb-1">Pilih Wallet Siswa</label>
                <select name="target_id" class="w-full border p-2 rounded" onchange="updateSummary(this)">
                    @foreach ($students as $student)
                        @if ($student->wallet)
                            <option value="{{ $student->wallet->id }}">{{ $student->name }} (ID: {{ $student->wallet->id }})</option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Donasi --}}
            <div id="donasi_fields" class="hidden">
                <label class="block font-medium mb-1">Kategori Donasi</label>
                <select name="target_id" class="w-full border p-2 rounded" onchange="updateSummary(this)">
                    @foreach ($donationCategories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block font-medium mb-1">Jumlah (Rp)</label>
                <input type="number" name="amount" min="1000" id="amount_input" class="w-full border p-2 rounded" oninput="updateSummary()" required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block font-medium mb-1">Keterangan</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="2"></textarea>
            </div>
        </div>

        {{-- RIGHT SIDE: RINGKASAN & OTP --}}
        <div class="bg-gray-50 shadow rounded p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-700">Konfirmasi Transfer</h2>

            <div class="text-sm text-gray-600">
                <p><strong>Tujuan:</strong> <span id="summary_type" class="text-gray-800">-</span></p>
                <p><strong>Untuk:</strong> <span id="summary_target" class="text-gray-800">-</span></p>
                <p><strong>Jumlah:</strong> <span id="summary_amount" class="text-gray-800">Rp 0</span></p>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium mb-1">Kode OTP</label>
                <input type="text" name="otp" class="w-full border p-2 rounded" maxlength="6" placeholder="Masukkan OTP dari WhatsApp">
            </div>

            <div class="text-right pt-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Konfirmasi & Transfer
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleFields() {
        const type = document.getElementById('destination_type').value;
        document.getElementById('tagihan_fields').classList.add('hidden');
        document.getElementById('saldo_fields').classList.add('hidden');
        document.getElementById('donasi_fields').classList.add('hidden');

        if (type === 'tagihan') document.getElementById('tagihan_fields').classList.remove('hidden');
        if (type === 'saldo_anak') document.getElementById('saldo_fields').classList.remove('hidden');
        if (type === 'donasi') document.getElementById('donasi_fields').classList.remove('hidden');
    }

    function updateSummary(select = null) {
        const type = document.getElementById('destination_type').value;
        const amount = document.getElementById('amount_input').value;
        const target = select ? select.options[select.selectedIndex].text : '';

        document.getElementById('summary_type').innerText = type ? type.replace('_', ' ').toUpperCase() : '-';
        if (target) document.getElementById('summary_target').innerText = target;
        document.getElementById('summary_amount').innerText = "Rp " + parseInt(amount || 0).toLocaleString('id-ID');
    }
</script>
@endsection
