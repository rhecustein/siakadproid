@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Tagihan Manual
    </h1>
    <p class="text-gray-600 text-base">Lengkapi formulir berikut untuk membuat tagihan pembayaran secara manual.</p>
</div>

{{-- Success/Error Alert (consistent with other pages) --}}
@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <ul class="font-medium list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow-xl rounded-2xl p-8 mb-8 border border-gray-100">
    <form action="{{ route('finance.bills.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Siswa --}}
        <div>
            <label for="student_search" class="block text-sm font-semibold text-gray-800 mb-1">Cari Siswa <span class="text-red-500">*</span></label>
            <input type="text" id="student_search" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" placeholder="Ketik nama atau NIS siswa...">
            <select name="student_id" id="student_id" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Siswa —</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" data-name="{{ strtolower($student->name) }}" data-nis="{{ strtolower($student->nis ?? '') }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->nis ?? 'NIS kosong' }})
                    </option>
                @endforeach
            </select>
            @error('student_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Grup Tagihan (Opsional) --}}
        <div>
            <label for="bill_group_id" class="block text-sm font-semibold text-gray-800 mb-1">Kelompok Tagihan (Opsional)</label>
            <select name="bill_group_id" id="bill_group_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Tidak Dikelompokkan —</option>
                @foreach ($billGroups as $group)
                    <option value="{{ $group->id }}" {{ old('bill_group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            @error('bill_group_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Jenis Tagihan --}}
        <div>
            <label for="bill_type_id" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Tagihan <span class="text-red-500">*</span></label>
            <select name="bill_type_id" id="bill_type_id" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Jenis —</option>
                @foreach ($billTypes as $type)
                <option value="{{ $type->id }}" {{ old('bill_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </select>
            @error('bill_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Judul Tagihan --}}
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-800 mb-1">Judul Tagihan <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: SPP Juli 2024" required>
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Jumlah Tagihan --}}
        <div>
            <label for="total_amount" class="block text-sm font-semibold text-gray-800 mb-1">Jumlah Tagihan (Rp) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   min="0" required>
            @error('total_amount') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div>
            <label for="start_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Mulai (Opsional)</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
            @error('start_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Jatuh Tempo --}}
        <div>
            <label for="due_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" required>
            @error('due_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-800 mb-1">Status Tagihan</label>
            <select name="status" id="status"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="unpaid" {{ old('status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>Sebagian</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
            @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Petugas Input --}}
        <div>
            <label for="created_by" class="block text-sm font-semibold text-gray-800 mb-1">Petugas Input (Opsional)</label>
            <select name="created_by" id="created_by"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih User —</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('created_by') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('created_by') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Catatan --}}
        <div class="md:col-span-2">
            <label for="notes" class="block text-sm font-semibold text-gray-800 mb-1">Catatan (Opsional)</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Catatan tambahan mengenai tagihan ini.">{{ old('notes') }}</textarea>
            @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('finance.bills.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Tagihan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentSearchInput = document.getElementById('student_search');
        const studentIdSelect = document.getElementById('student_id');
        let studentsCache = [];

        async function fetchStudents() {
            studentIdSelect.innerHTML = '<option value="">Memuat siswa...</option>';
            studentSearchInput.disabled = true;
            const bearerToken = localStorage.getItem('sanctum_api_token'); // Ambil token dari localStorage

            try {
                if (!bearerToken) {
                    throw new Error("Token autentikasi tidak tersedia.");
                }
                const response = await fetch('/api/search-students', { // Ganti dengan rute API Anda
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Authorization': `Bearer ${bearerToken}` // Kirim token
                    }
                });
                if (!response.ok) {
                    const errorBody = await response.json();
                    throw new Error(`Gagal memuat siswa: ${errorBody.message || response.statusText}`);
                }
                studentsCache = await response.json();
                renderStudentOptions(studentsCache);
            } catch (err) {
                console.error('Error fetching students:', err.message);
                studentIdSelect.innerHTML = `<option value="">${err.message}. Coba lagi.</option>`;
            } finally {
                studentSearchInput.disabled = false;
            }
        }

        function filterStudentOptions() {
            const searchTerm = studentSearchInput.value.toLowerCase();
            const filteredOptions = studentsCache.filter(student => {
                const studentName = student.name ? student.name.toLowerCase() : '';
                const studentNis = student.nis ? student.nis.toLowerCase() : '';
                return studentName.includes(searchTerm) || studentNis.includes(searchTerm);
            });
            renderStudentOptions(filteredOptions);
        }

        function renderStudentOptions(studentsToRender) {
            studentIdSelect.innerHTML = '<option value="">— Pilih Siswa —</option>';
            studentsToRender.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = `${student.name} (${student.nis || 'NIS kosong'})`;
                option.dataset.name = student.name ? student.name.toLowerCase() : '';
                option.dataset.nis = student.nis ? student.nis.toLowerCase() : '';
                studentIdSelect.appendChild(option);
            });
            const oldStudentId = "{{ old('student_id') }}";
            if (oldStudentId && studentIdSelect.querySelector(`option[value="${oldStudentId}"]`)) {
                studentIdSelect.value = oldStudentId;
            }
        }

        // Event Listener
        studentSearchInput.addEventListener('input', filterStudentOptions);

        // Initial fetch on page load
        fetchStudents();
    });
</script>
@endpush