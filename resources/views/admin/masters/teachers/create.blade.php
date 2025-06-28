@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Guru Baru
    </h1>
    <p class="text-gray-600 text-base">Masukkan data lengkap guru dan hubungkan dengan akun pengguna yang sesuai.</p>
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
    <form action="{{ route('academic.teachers.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Budi Santoso" required autofocus>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-sm font-semibold text-gray-800 mb-1">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Nomor Induk Pegawai">
                @error('nip')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Jenis Kelamin --}}
            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Kelamin</label>
                <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih —</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-800 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="email@example.com" required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Sekolah --}}
            <div>
                <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-1">Sekolah <span class="text-red-500">*</span></label>
                <select name="school_id" id="school_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Sekolah —</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- USER ACCOUNT SECTION --}}
        <div class="p-6 bg-blue-50 rounded-xl border border-blue-200 shadow-inner">
            <h4 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i> Hubungkan Akun Pengguna
            </h4>
            <p class="text-sm text-gray-700 mb-4">Pilih akun pengguna yang sudah ada untuk guru ini, atau sistem akan membuatkan akun baru secara otomatis.</p>

            <div class="mb-4">
                <label for="user_id_option" class="block text-sm font-semibold text-gray-800 mb-1">Opsi Akun Pengguna</label>
                <select name="user_id_option" id="user_id_option" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="create_new" {{ old('user_id_option') == 'create_new' ? 'selected' : '' }}>Buat Akun Baru Otomatis</option>
                    <option value="select_existing" {{ old('user_id_option') == 'select_existing' ? 'selected' : '' }}>Pilih Akun yang Sudah Ada</option>
                </select>
            </div>

            <div id="existing_user_section" class="{{ old('user_id_option') == 'select_existing' ? '' : 'hidden' }} mt-4">
                <label for="user_search" class="block text-sm font-semibold text-gray-800 mb-1">Cari Pengguna Berdasarkan Nama/Email</label>
                <input type="text" id="user_search" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" placeholder="Ketik nama atau email pengguna...">

                <label for="user_id" class="block text-sm font-semibold text-gray-800 mt-4 mb-1">Pilih Pengguna</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Akun Pengguna —</option>
                    {{-- Options will be dynamically loaded/filtered by JS --}}
                    @foreach ($availableUsers as $user)
                        <option value="{{ $user->id }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        {{-- END USER ACCOUNT SECTION --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Posisi --}}
            <div>
                <label for="position" class="block text-sm font-semibold text-gray-800 mb-1">Posisi</label>
                <input type="text" name="position" id="position" value="{{ old('position') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Contoh: Wali Kelas, Guru Tahfidz, Waka">
                @error('position')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Status Kepegawaian --}}
            <div>
                <label for="employment_status" class="block text-sm font-semibold text-gray-800 mb-1">Status Kepegawaian</label>
                <select name="employment_status" id="employment_status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Status —</option>
                    <option value="Tetap" {{ old('employment_status') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Kontrak" {{ old('employment_status') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="Honorer" {{ old('employment_status') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                </select>
                @error('employment_status')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Jenis Guru --}}
        <div>
            <label for="type" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Guru</label>
            <select name="type" id="type"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                <option value="">— Pilih Jenis —</option>
                <option value="Formal" {{ old('type') == 'Formal' ? 'selected' : '' }}>Formal</option>
                <option value="Pondok" {{ old('type') == 'Pondok' ? 'selected' : '' }}>Pondok</option>
                <option value="Diniyah" {{ old('type') == 'Diniyah' ? 'selected' : '' }}>Diniyah</option>
            </select>
            @error('type')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('academic.teachers.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Guru
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userIdOption = document.getElementById('user_id_option');
        const existingUserSection = document.getElementById('existing_user_section');
        const userSearchInput = document.getElementById('user_search');
        const userIdSelect = document.getElementById('user_id');
        const originalUserOptions = Array.from(userIdSelect.options).filter(option => option.value !== ""); // Keep original options excluding the placeholder

        function toggleUserSection() {
            if (userIdOption.value === 'select_existing') {
                existingUserSection.classList.remove('hidden');
                // Re-apply filter in case it was hidden and search input had value
                filterUserOptions();
            } else {
                existingUserSection.classList.add('hidden');
                // Clear search and reset options when hiding
                userSearchInput.value = '';
                renderUserOptions(originalUserOptions);
            }
        }

        function filterUserOptions() {
            const searchTerm = userSearchInput.value.toLowerCase();
            const filteredOptions = originalUserOptions.filter(option => {
                const userName = option.dataset.name || '';
                const userEmail = option.dataset.email || '';
                return userName.includes(searchTerm) || userEmail.includes(searchTerm);
            });
            renderUserOptions(filteredOptions);
        }

        function renderUserOptions(optionsToRender) {
            userIdSelect.innerHTML = '<option value="">— Pilih Akun Pengguna —</option>'; // Reset dropdown
            optionsToRender.forEach(option => {
                userIdSelect.appendChild(option.cloneNode(true)); // Append cloned option
            });

            // Re-select old value if it exists after filtering
            const oldUserId = "{{ old('user_id') }}";
            if (oldUserId && userIdSelect.querySelector(`option[value="${oldUserId}"]`)) {
                userIdSelect.value = oldUserId;
            } else if (oldUserId) {
                 // If old value is not in filtered options, add it back as selected but disabled
                 const selectedOption = originalUserOptions.find(opt => opt.value === oldUserId);
                 if (selectedOption) {
                    const tempOption = selectedOption.cloneNode(true);
                    tempOption.disabled = true;
                    tempOption.selected = true;
                    userIdSelect.prepend(tempOption); // Add to top temporarily
                 }
            }
        }


        userIdOption.addEventListener('change', toggleUserSection);
        userSearchInput.addEventListener('input', filterUserOptions); // Listen to input for filtering

        // Initial check on page load
        toggleUserSection();

        // If 'select_existing' was old value, ensure the search filter is applied
        if (userIdOption.value === 'select_existing') {
            filterUserOptions();
        }
    });
</script>
@endpush