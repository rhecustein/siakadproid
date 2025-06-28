@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto py-8 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📋 Generate Tagihan Masal</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="mb-6 flex flex-col md:flex-row md:items-center gap-3">
        <input type="text" name="search" placeholder="Cari nama/NISN..." value="{{ request('search') }}"
               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 shadow-sm" />
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm shadow">
            🔍 Terapkan Filter
        </button>
    </form>

    {{-- Form Utama --}}
    <form action="{{ route('finance.bill-generates.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Panel Siswa --}}
            <div class="bg-white rounded-xl shadow-lg p-5 flex flex-col h-full">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">✅ Pilih Siswa</h2>
                <div class="flex-1 overflow-y-auto max-h-[500px] space-y-2 pr-1">
                    @forelse($students as $student)
                        <label class="flex items-center justify-between text-sm bg-gray-50 border rounded-lg px-3 py-2 hover:bg-gray-100 transition">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox rounded border-gray-300 focus:ring-blue-500">
                                <span>{{ $student->name }} ({{ $student->nisn ?? '-' }} | {{ $student->grade->label ?? '-' }})</span>
                            </div>
                            <button type="button" onclick="showStudentModal({{ $student->id }})"
                                    class="text-blue-500 text-xs hover:underline">Detail</button>
                        </label>

                        {{-- Modal Siswa --}}
                        <div id="student-modal-{{ $student->id }}" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
                                <button onclick="hideStudentModal({{ $student->id }})" class="absolute top-3 right-4 text-gray-600 hover:text-red-500 text-2xl">×</button>
                                <div class="text-center">
                                    <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/avatar.png') }}"
                                         class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border" />
                                    <h3 class="text-xl font-bold">{{ $student->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $student->nisn ?? '-' }} | {{ $student->grade->label ?? '-' }}</p>
                                </div>
                                <div class="mt-4 text-sm text-gray-700 space-y-1">
                                    <p><strong>NIS:</strong> {{ $student->nis ?? '-' }}</p>
                                    <p><strong>Sekolah:</strong> {{ $student->school->name ?? '-' }}</p>
                                    <p><strong>Jenis Kelamin:</strong> {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    <p><strong>Tanggal Masuk:</strong> {{ $student->admission_date ?? '-' }}</p>
                                    @if ($student->notes)
                                        <hr class="my-2">
                                        <p class="italic text-gray-600">{{ $student->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Tidak ada siswa ditemukan.</p>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="pt-3 border-t mt-4">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>

            {{-- Filter Panel --}}
            @include('admin.finance.bill._filter-panel')

            {{-- Summary Panel --}}
            @include('admin.finance.bill._summary-panel')

        </div>

        <div class="text-right mt-8">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md">
                🚀 Proses Generate Tagihan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateSummary() {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        const studentCount = document.getElementById('studentCount');
        const totalEl = document.getElementById('totalTagihan');
        const nominalEl = document.getElementById('nominal');
        const countEl = document.getElementById('count');
        const billGroupSelect = document.querySelector('select[name="bill_group_id"]');
        const selected = billGroupSelect.options[billGroupSelect.selectedIndex];

        const nominal = parseFloat(selected.getAttribute('data-nominal')) || 0;
        const jumlah = parseInt(selected.getAttribute('data-count')) || 1;
        const total = checked.length * nominal * jumlah;

        studentCount.innerText = checked.length;
        nominalEl.innerText = nominal.toLocaleString('id-ID');
        countEl.innerText = jumlah;
        totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');

        const desc = selected.getAttribute('data-description') || '-';
        const year = selected.getAttribute('data-year') || '-';
        const gender = selected.getAttribute('data-gender') || '-';
        const start = selected.getAttribute('data-start') || '';
        const end = selected.getAttribute('data-end') || '';

        document.getElementById('groupDetail').classList.remove('hidden');
        document.getElementById('descText').innerText = desc;
        document.getElementById('yearText').innerText = year;
        document.getElementById('genderText').innerText = gender === 'male' ? 'Laki-laki' : (gender === 'female' ? 'Perempuan' : '-');
        document.getElementById('periodText').innerText = start && end ? `${start} s.d ${end}` : '-';
    }

    function showStudentModal(id) {
        document.getElementById(`student-modal-${id}`)?.classList.remove('hidden');
    }

    function hideStudentModal(id) {
        document.getElementById(`student-modal-${id}`)?.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.student-checkbox').forEach(cb => cb.addEventListener('change', updateSummary));
        document.querySelector('select[name="bill_group_id"]')?.addEventListener('change', updateSummary);
        updateSummary();
    });
</script>
@endpush
@endsection
