@extends('layouts.app')

@section('content')
<div class="max-w-screen-xl mx-auto py-8 px-6">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">💵 Pembayaran Manual Tagihan Siswa</h1>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
      ✅ {{ session('success') }}
    </div>
  @elseif(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">
      ⚠️ {{ session('error') }}
    </div>
  @endif

  {{-- Pilih Siswa --}}
  <form method="GET" class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Siswa</label>
    <div class="flex gap-3">
      <select name="student_id" class="form-select w-full md:w-1/3 border-gray-300 rounded">
        <option value="">-- Pilih Siswa --</option>
        @foreach($students as $student)
          <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
            {{ $student->name }} ({{ $student->nisn ?? '-' }})
          </option>
        @endforeach
      </select>
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Tampilkan
      </button>
    </div>
  </form>

  {{-- Form Pembayaran --}}
  @if($selectedStudent)
    <div class="mb-6">
      <h2 class="text-lg font-semibold text-gray-800">📄 Tagihan untuk: {{ $selectedStudent->name }}</h2>
    </div>

    @if($bills->count())
      <form action="{{ route('finance.bill-manuals.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-5">
        @csrf
        <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">

        {{-- Tampilkan semua tagihan dan item --}}
        @foreach($bills as $bill)
          <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 mb-4">
            <p class="font-semibold text-gray-700">{{ $bill->title }} (Rp {{ number_format($bill->total_amount, 0, ',', '.') }})</p>
            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
            <div class="mt-2 space-y-2">
              @foreach($bill->items as $item)
                <label class="flex items-center space-x-2">
                  <input type="checkbox" name="item_ids[]" value="{{ $item->id }}"
                         class="rounded border-gray-300 text-blue-600" />
                  <span class="text-sm text-gray-700">
                    {{ $item->label }} - Rp {{ number_format($item->amount, 0, ',', '.') }} ({{ $item->status }})
                  </span>
                </label>
              @endforeach
            </div>
          </div>
        @endforeach

        {{-- Form Pembayaran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🗓️ Tanggal Pembayaran</label>
            <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}"
                   class="form-input w-full border-gray-300 rounded" required>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">💰 Jumlah Bayar (Rp)</label>
            <input type="number" name="amount" step="1000" min="1000"
                   class="form-input w-full border-gray-300 rounded" required>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">💳 Metode</label>
            <select name="method" class="form-select w-full border-gray-300 rounded" required>
              <option value="manual">Manual</option>
              <option value="transfer">Transfer</option>
              <option value="tunai">Tunai</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📝 Catatan</label>
            <input type="text" name="notes" class="form-input w-full border-gray-300 rounded" placeholder="Opsional">
          </div>
        </div>

        <div class="text-right pt-4">
          <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2 rounded">
            💾 Simpan Pembayaran
          </button>
        </div>
      </form>
    @else
      <p class="text-gray-600">Tidak ada tagihan aktif untuk siswa ini.</p>
    @endif
  @endif
</div>
@endsection
