@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Orang Tua / Wali
    </h1>
    <p class="text-gray-600 text-base">Isi data lengkap orang tua atau wali yang akan dihubungkan dengan siswa.</p>
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
    <form action="{{ route('core.parents.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                   placeholder="Misal: Bapak Budi Santoso" required autofocus>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
            {{-- Hubungan --}}
            <div>
                <label for="relationship" class="block text-sm font-semibold text-gray-800 mb-1">Hubungan</label>
                <select name="relationship" id="relationship"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih —</option>
                    <option value="ayah" {{ old('relationship') == 'ayah' ? 'selected' : '' }}>Ayah</option>
                    <option value="ibu" {{ old('relationship') == 'ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="wali" {{ old('relationship') == 'wali' ? 'selected' : '' }}>Wali</option>
                </select>
                @error('relationship')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Nomor HP --}}
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-800 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="Misal: 081234567890" required>
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Email (opsional) --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-800 mb-1">Email (opsional)</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                       placeholder="email@example.com">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-800 mb-1">Alamat</label>
            <textarea name="address" id="address" rows="3"
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Alamat lengkap">{{ old('address') }}</textarea>
            @error('address')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- USER ACCOUNT SECTION --}}
        <div class="p-6 bg-blue-50 rounded-xl border border-blue-200 shadow-inner">
            <h4 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i> Hubungkan Akun Pengguna
            </h4>
            <p class="text-sm text-gray-700 mb-4">Pilih akun pengguna yang sudah ada untuk orang tua ini, atau sistem akan membuatkan akun baru secara otomatis.</p>

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

        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('core.parents.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Orang Tua
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
        let availableUsersCache = []; // Cache for all available users

        // Function to toggle visibility of existing user section
        function toggleUserSection() {
            if (userIdOption.value === 'select_existing') {
                existingUserSection.classList.remove('hidden');
                // Ensure options are loaded/filtered when section becomes visible
                if (availableUsersCache.length === 0) {
                    fetchAvailableUsers(); // Fetch if not already cached
                } else {
                    filterUserOptions(); // Filter from cache
                }
            } else {
                existingUserSection.classList.add('hidden');
                userSearchInput.value = ''; // Clear search when hiding
                userIdSelect.innerHTML = '<option value="">— Pilih Akun Pengguna —</option>'; // Clear options
            }
        }

        // Function to fetch available users from API
        async function fetchAvailableUsers() {
            // Optional: Show loading indicator
            userIdSelect.innerHTML = '<option value="">Memuat pengguna...</option>';
            userSearchInput.disabled = true;

            try {
                // Adjust this route to your actual API route for searching users
                const response = await fetch('/api/available-users-for-parent', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (!response.ok) {
                    throw new Error('Gagal memuat pengguna yang tersedia.');
                }
                availableUsersCache = await response.json();
                renderUserOptions(availableUsersCache); // Render initial options
            } catch (error) {
                console.error('Error fetching available users:', error);
                userIdSelect.innerHTML = '<option value="">Gagal memuat. Coba lagi.</option>';
            } finally {
                userSearchInput.disabled = false;
            }
        }

        // Function to filter user options based on search input
        function filterUserOptions() {
            const searchTerm = userSearchInput.value.toLowerCase();
            const filteredOptions = availableUsersCache.filter(user => {
                const userName = user.name ? user.name.toLowerCase() : '';
                const userEmail = user.email ? user.email.toLowerCase() : '';
                return userName.includes(searchTerm) || userEmail.includes(searchTerm);
            });
            renderUserOptions(filteredOptions);
        }

        // Function to render options into the select dropdown
        function renderUserOptions(usersToRender) {
            userIdSelect.innerHTML = '<option value="">— Pilih Akun Pengguna —</option>'; // Clear current options
            usersToRender.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.name} (${user.email})`;
                option.dataset.name = user.name ? user.name.toLowerCase() : ''; // For filtering
                option.dataset.email = user.email ? user.email.toLowerCase() : ''; // For filtering
                userIdSelect.appendChild(option);
            });

            // Re-select old value if it exists after filtering
            const oldUserId = "{{ old('user_id') }}";
            if (oldUserId && userIdSelect.querySelector(`option[value="${oldUserId}"]`)) {
                userIdSelect.value = oldUserId;
            }
        }

        // Event Listeners
        userIdOption.addEventListener('change', toggleUserSection);
        userSearchInput.addEventListener('input', filterUserOptions); // Live search

        // Initial check on page load
        toggleUserSection(); // This will trigger fetch if 'select_existing' is active
    });
</script>
@endpush