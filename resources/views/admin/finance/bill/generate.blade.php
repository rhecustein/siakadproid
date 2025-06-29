@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Generate Tagihan Masal
    </h1>
    <p class="text-gray-600 text-base">Buat tagihan pembayaran untuk banyak siswa sekaligus dengan pengaturan yang fleksibel.</p>
</div>

{{-- Success/Error Alert (consistent with other pages) --}}
@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 flex items-start gap-3 shadow-md animate-fade-in-down">
        <svg class="w-5 h-5 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@elseif(session('error'))
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

<form action="{{ route('finance.bill-generates.store') }}" method="POST" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Panel Kriteria Siswa & Daftar Siswa --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-lg p-6 space-y-5 border border-gray-100 flex flex-col">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                <i class="fas fa-filter mr-2 text-blue-600"></i> Filter Siswa
            </h2>

            <div>
                <label for="filter_academic_year_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                <select name="filter_academic_year_id" id="filter_academic_year_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Tahun Ajaran —</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('filter_academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                    @endforeach
                </select>
                @error('filter_academic_year_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="filter_school_id" class="block text-sm font-medium text-gray-700 mb-1">Sekolah (Opsional)</label>
                <select name="filter_school_id" id="filter_school_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Semua Sekolah —</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ request('filter_school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('filter_school_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="filter_grade_level_id" class="block text-sm font-medium text-gray-700 mb-1">Jenjang/Kelas (Opsional)</label>
                <select name="filter_grade_level_id" id="filter_grade_level_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Semua Jenjang —</option>
                    @foreach($gradeLevels as $grade)
                        <option value="{{ $grade->id }}" {{ request('filter_grade_level_id') == $grade->id ? 'selected' : '' }}>{{ $grade->label }}</option>
                    @endforeach
                </select>
                @error('filter_grade_level_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="filter_student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa (Opsional)</label>
                <select name="filter_student_status" id="filter_student_status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Semua Status —</option>
                    <option value="aktif" {{ request('filter_student_status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('filter_student_status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="lulus" {{ request('filter_student_status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="alumni" {{ request('filter_student_status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
                @error('filter_student_status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <input type="text" name="filter_search" id="filter_search" placeholder="Cari nama, NIS, atau NISN..." value="{{ request('filter_search') }}"
                   class="flex-1 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" />

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="apply-filter-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md flex items-center justify-center gap-1">
                    <i class="fas fa-search mr-2"></i> Terapkan Filter
                </button>
                <button type="button" id="reset-filter-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md flex items-center justify-center gap-1">
                    <i class="fas fa-redo mr-2"></i> Reset
                </button>
            </div>

            {{-- Hasil Filter Siswa --}}
            <div class="flex-1 overflow-y-auto max-h-[400px] space-y-2 pr-1 pt-4 border-t mt-4 custom-scrollbar">
                <div class="text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-users mr-1"></i> Siswa Terpilih: <span id="selected-student-count">0</span> / <span id="total-filtered-students">0</span>
                </div>
                <div id="student-list-container">
                    {{-- Students loaded from initial controller request will be rendered here --}}
                    @forelse($students as $student)
                        <label class="flex items-center justify-between text-sm bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox rounded border-gray-300 focus:ring-blue-500" {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}>
                                <span>{{ $student->name }} ({{ $student->nisn ?? '-' }} | {{ optional(optional($student->currentClassroomAssignment)->classroom)->name ?? '-' }})</span>
                            </div>
                            <button type="button" class="text-blue-500 text-xs hover:underline view-student-detail" data-student-id="{{ $student->id }}"
                                data-student-name="{{ $student->name }}"
                                data-student-nisn="{{ $student->nisn ?? 'N/A' }}"
                                data-student-school="{{ optional($student->school)->name ?? 'N/A' }}"
                                data-student-class="{{ optional(optional($student->currentClassroomAssignment)->classroom)->name ?? 'N/A' }}"
                                data-student-admission-date="{{ optional($student->admission_date)->translatedFormat('d M Y') ?? 'N/A' }}"
                                data-student-gender="{{ $student->gender == 'L' ? 'Laki-laki' : ($student->gender == 'P' ? 'Perempuan' : 'N/A') }}"
                                data-student-status="{{ ucfirst($student->student_status) }}"
                                data-student-notes="{{ $student->notes ?? 'N/A' }}"
                                >Detail</button>
                        </label>
                    @empty
                        <p class="text-gray-500 text-sm text-center">Tidak ada siswa ditemukan.</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    {{ $students->links() }}
                </div>
            </div>
        </div>

        {{-- Panel Detail Tagihan & Ringkasan --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 space-y-5 border border-gray-100 flex flex-col">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                <i class="fas fa-dollar-sign mr-2 text-green-600"></i> Detail Tagihan
            </h2>
            <div>
                <label for="bill_type_id" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Tagihan <span class="text-red-500">*</span></label>
                <select name="bill_type_id" id="bill_type_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Jenis Tagihan —</option>
                    @foreach($billTypes as $type)
                        <option value="{{ $type->id }}" {{ old('bill_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('bill_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="bill_group_id" class="block text-sm font-semibold text-gray-700 mb-1">Grup Tagihan (Opsional) <span class="text-red-500">*</span></label>
                <select name="bill_group_id" id="bill_group_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Grup Tagihan —</option>
                    @foreach($billGroups as $group)
                        <option value="{{ $group->id }}" {{ old('bill_group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
                @error('bill_group_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="amount_per_item" class="block text-sm font-semibold text-gray-700 mb-1">Nominal per Item (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="amount_per_item" id="amount_per_item" value="{{ old('amount_per_item') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       min="0" step="0.01" required>
                @error('amount_per_item') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="number_of_items" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Item (misal: bulan) <span class="text-red-500">*</span></label>
                <input type="number" name="number_of_items" id="number_of_items" value="{{ old('number_of_items', 1) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       min="1" required>
                @error('number_of_items') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="due_date_per_item" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Jatuh Tempo Item Awal <span class="text-red-500">*</span></label>
                <input type="date" name="due_date_per_item" id="due_date_per_item" value="{{ old('due_date_per_item') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" required>
                @error('due_date_per_item') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="2"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                          placeholder="Deskripsi singkat untuk semua tagihan yang digenerate.">{{ old('description') }}</textarea>
                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="2"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                          placeholder="Catatan internal untuk tagihan ini.">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Ringkasan Generate --}}
            <div class="border-t pt-4 mt-4 text-gray-700 col-span-full"> {{-- col-span-full to make it span all columns --}}
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-calculator mr-2 text-blue-600"></i> Ringkasan Generate
                </h3>
                <p class="text-sm">Siswa Terpilih: <span id="summary-student-count" class="font-semibold">0</span> siswa</p>
                <p class="text-sm">Nominal per Siswa: Rp <span id="summary-nominal-per-student" class="font-semibold">0</span></p>
                <p class="text-sm">Jumlah Item per Siswa: <span id="summary-items-per-student" class="font-semibold">0</span></p>
                <p class="text-lg mt-2 font-bold">Total Estimasi: Rp <span id="summary-total-estimate" class="text-green-700">0</span></p>
            </div>
        </div>

    </div>

    <div class="text-right mt-8">
        <a href="{{ route('finance.bills.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold shadow-md hover:bg-gray-300 transition-colors duration-200 mr-2">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
        <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md">
            <i class="fas fa-check-circle mr-2"></i> Proses Generate Tagihan
        </button>
    </div>
</form>

{{-- Modal Detail Siswa (Re-use from students.index or define here) --}}
{{-- Make sure this modal HTML is defined ONCE in the Blade file, outside the main form --}}
<div id="studentDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Siswa: <span id="detailStudentName"></span></h3>
            <button type="button" id="closeStudentDetailModal" class="text-gray-500 hover:text-gray-800 focus:outline-none text-2xl">
                &times;
            </button>
        </div>

        <div class="text-gray-700 space-y-3">
            <p><strong>Nama Lengkap:</strong> <span id="detailName"></span></p>
            <p><strong>NIS:</strong> <span id="detailNis"></span></p>
            <p><strong>NISN:</strong> <span id="detailNisn"></span></p>
            <p><strong>Sekolah:</strong> <span id="detailSchool"></span></p>
            <p><strong>Kelas Aktif:</strong> <span id="detailClass"></span></p>
            <p><strong>Orang Tua/Wali:</strong> <span id="detailParentName"></span></p>
            <p><strong>Jenis Kelamin:</strong> <span id="detailGender"></span></p>
            <p><strong>Tanggal Lahir:</strong> <span id="detailBirthDate"></span></p>
            <p><strong>Tempat Lahir:</strong> <span id="detailBirthPlace"></span></p>
            <p><strong>Alamat:</strong> <span id="detailAddress"></span></p>
            <p><strong>Nomor Telepon:</strong> <span id="detailPhone"></span></p>
            <p><strong>Tanggal Masuk:</strong> <span id="detailAdmissionDate"></span></p>
            <p><strong>Status Siswa:</strong> <span id="detailStatus"></span></p>
            <p><strong>Catatan:</strong> <span id="detailNotes"></span></p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const academicYearSelect = document.getElementById('filter_academic_year_id');
        const schoolSelect = document.getElementById('filter_school_id');
        const gradeLevelSelect = document.getElementById('filter_grade_level_id');
        const studentStatusSelect = document.getElementById('filter_student_status');
        const searchInput = document.getElementById('filter_search'); // Filter search input
        const applyFilterBtn = document.getElementById('apply-filter-btn');
        const resetFilterBtn = document.getElementById('reset-filter-btn');

        const studentListContainer = document.getElementById('student-list-container');
        const selectedStudentCountSpan = document.getElementById('selected-student-count');
        const totalFilteredStudentsSpan = document.getElementById('total-filtered-students');

        const billTypeSelect = document.getElementById('bill_type_id');
        const billGroupSelect = document.getElementById('bill_group_id');
        const amountPerItemInput = document.getElementById('amount_per_item');
        const numberOfItemsInput = document.getElementById('number_of_items');
        const dueDatePerItemInput = document.getElementById('due_date_per_item'); // For initial summary calculation

        const summaryStudentCount = document.getElementById('summary-student-count');
        const summaryNominalPerStudent = document.getElementById('summary-nominal-per-student');
        const summaryItemsPerStudent = document.getElementById('summary-items-per-student');
        const summaryTotalEstimate = document.getElementById('summary-total-estimate');

        let allFilteredStudents = []; // Cache for students returned by API filter

        // --- Fetch Students based on Filters ---
        async function fetchFilteredStudents() {
            studentListContainer.innerHTML = '<p class="text-gray-500 text-sm text-center">Memuat siswa...</p>';
            selectedStudentCountSpan.textContent = '0';
            totalFilteredStudentsSpan.textContent = '0';
            allFilteredStudents = [];
            updateSummary(); // Update summary to 0 while loading

            const params = new URLSearchParams();
            if (academicYearSelect.value) params.append('academic_year_id', academicYearSelect.value);
            if (schoolSelect.value) params.append('school_id', schoolSelect.value);
            if (gradeLevelSelect.value) params.append('grade_level_id', gradeLevelSelect.value);
            if (studentStatusSelect.value) params.append('student_status', studentStatusSelect.value);
            if (searchInput.value) params.append('search', searchInput.value);

            const bearerToken = localStorage.getItem('sanctum_api_token');
            if (!bearerToken) {
                studentListContainer.innerHTML = '<p class="text-red-500 text-sm text-center">Token autentikasi tidak ditemukan. Silakan login ulang.</p>';
                return;
            }

            try {
                const response = await fetch(`/api/finance/bills/filter-students-for-generate?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${bearerToken}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    const errorBody = await response.json();
                    throw new Error(`Gagal memuat siswa: ${errorBody.message || response.statusText}`);
                }

                const data = await response.json();
                allFilteredStudents = data.students; // Assuming API returns { students: [...] }

                renderStudentCheckboxes(allFilteredStudents);
                updateTotalFilteredStudentsCount();
                updateSummary();

            } catch (error) {
                console.error('Error fetching filtered students:', error);
                studentListContainer.innerHTML = `<p class="text-red-500 text-sm text-center">${error.message}. Gagal memuat siswa.</p>`;
            }
        }

        function renderStudentCheckboxes(students) {
            studentListContainer.innerHTML = ''; // Clear previous list
            if (students.length === 0) {
                studentListContainer.innerHTML = '<p class="text-gray-500 text-sm text-center">Tidak ada siswa yang cocok dengan filter.</p>';
                return;
            }

            students.forEach(student => {
                const label = document.createElement('label');
                label.className = 'flex items-center justify-between text-sm bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-100 transition-colors duration-150 cursor-pointer';
                
                // Construct classroom display safely
                const classroomName = student.current_classroom && student.current_classroom.name ? student.current_classroom.name : '-';

                label.innerHTML = `
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="student_ids[]" value="${student.id}" class="student-checkbox rounded border-gray-300 focus:ring-blue-500" data-student-id="${student.id}">
                        <span>${student.name} (${student.nisn || '-'} | ${classroomName})</span>
                    </div>
                    <button type="button" class="text-blue-500 text-xs hover:underline view-student-detail" data-student-id="${student.id}">Detail</button>
                `;
                studentListContainer.appendChild(label);

                // Add event listener for checkbox to update count
                label.querySelector('.student-checkbox').addEventListener('change', updateSelectedStudentsCount);
                // Add event listener for detail button
                label.querySelector('.view-student-detail').addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default button behavior
                    // Call a separate function to show the modal using the data (you'll need to define this function)
                    // Or populate the modal directly if all data is in student object
                    // For now, let's just alert the ID
                    // alert('Show detail for student ID: ' + student.id);
                    showStudentDetailModal(student); // Call the new detail modal function
                });
            });
        }

        function updateSelectedStudentsCount() {
            const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
            selectedStudentCountSpan.textContent = checkedCount;
            updateSummary();
        }

        function updateTotalFilteredStudentsCount() {
            totalFilteredStudentsSpan.textContent = allFilteredStudents.length;
        }

        // --- Summary Update Logic ---
        function updateSummary() {
            const selectedStudents = document.querySelectorAll('.student-checkbox:checked').length;
            const nominal = parseFloat(amountPerItemInput.value) || 0;
            const jumlahItem = parseInt(numberOfItemsInput.value) || 0;

            const totalEstimate = selectedStudents * nominal * jumlahItem;

            summaryStudentCount.textContent = selectedStudents;
            summaryNominalPerStudent.textContent = nominal.toLocaleString('id-ID'); // Format mata uang
            summaryItemsPerStudent.textContent = jumlahItem;
            summaryTotalEstimate.textContent = totalEstimate.toLocaleString('id-ID'); // Format mata uang
        }

        // --- Event Listeners for Filter Panel ---
        applyFilterBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            fetchFilteredStudents();
        });

        resetFilterBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            academicYearSelect.value = '';
            schoolSelect.value = '';
            gradeLevelSelect.value = '';
            studentStatusSelect.value = '';
            searchInput.value = '';
            fetchFilteredStudents(); // Refetch with empty filters
        });

        // --- Event Listeners for Summary Inputs ---
        amountPerItemInput.addEventListener('input', updateSummary);
        numberOfItemsInput.addEventListener('input', updateSummary);
        // Also add listeners for main selects to update summary immediately
        billTypeSelect.addEventListener('change', updateSummary);
        billGroupSelect.addEventListener('change', updateSummary);
        dueDatePerItemInput.addEventListener('change', updateSummary); // For completeness

        // --- Student Detail Modal Logic (HTML needs to be in this file) ---
        const studentDetailModal = document.getElementById('studentDetailModal'); // Assuming this ID exists
        const closeStudentDetailModalBtn = document.getElementById('closeStudentDetailModal');

        // Elements within the modal
        const detailStudentName = document.getElementById('detailStudentName');
        const detailNis = document.getElementById('detailNis');
        const detailNisn = document.getElementById('detailNisn');
        const detailName = document.getElementById('detailName'); // Full name field inside modal
        const detailSchool = document.getElementById('detailSchool');
        const detailClass = document.getElementById('detailClass');
        const detailParentName = document.getElementById('detailParentName');
        const detailGender = document.getElementById('detailGender');
        const detailAdmissionDate = document.getElementById('detailAdmissionDate');
        const detailStatus = document.getElementById('detailStatus');
        const detailBirthDate = document.getElementById('detailBirthDate');
        const detailBirthPlace = document.getElementById('detailBirthPlace');
        const detailAddress = document.getElementById('detailAddress');
        const detailPhone = document.getElementById('detailPhone');
        const detailNotes = document.getElementById('detailNotes');
        const modalContent = studentDetailModal ? studentDetailModal.querySelector('.transform') : null;

        function showStudentDetailModal(studentData) {
            if (!studentDetailModal || !modalContent) return;

            // Populate the modal with studentData
            detailStudentName.textContent = studentData.name;
            detailNis.textContent = studentData.nis || 'N/A';
            detailNisn.textContent = studentData.nisn || 'N/A';
            detailName.textContent = studentData.name;
            detailSchool.textContent = studentData.school?.name || 'N/A';
            detailClass.textContent = studentData.current_classroom?.name || 'N/A';
            detailParentName.textContent = studentData.parent?.name || 'N/A'; // Assuming parent relation is eager loaded or available
            detailGender.textContent = studentData.gender === 'L' ? 'Laki-laki' : (studentData.gender === 'P' ? 'Perempuan' : '—');
            detailAdmissionDate.textContent = studentData.admission_date ? new Date(studentData.admission_date).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'}) : 'N/A';
            detailStatus.textContent = studentData.student_status ? studentData.student_status.charAt(0).toUpperCase() + studentData.student_status.slice(1) : 'N/A';
            detailBirthDate.textContent = studentData.date_of_birth ? new Date(studentData.date_of_birth).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'}) : 'N/A';
            detailBirthPlace.textContent = studentData.place_of_birth || 'N/A';
            detailAddress.textContent = studentData.address || 'N/A';
            detailPhone.textContent = studentData.phone_number || 'N/A'; // Assuming phone_number field
            detailNotes.textContent = studentData.notes || 'N/A';

            openModal(studentDetailModal, modalContent);
        }

        if (closeStudentDetailModalBtn) {
            closeStudentDetailModalBtn.addEventListener('click', () => closeModal(studentDetailModal, modalContent));
        }
        if (studentDetailModal) {
            studentDetailModal.addEventListener('click', function(event) {
                if (event.target === studentDetailModal) {
                    closeModal(studentDetailModal, modalContent);
                }
            });
        }


        // --- Initial Load ---
        fetchFilteredStudents(); // Initial fetch when page loads
        updateSummary(); // Initial summary calculation
    });
</script>
@endpush