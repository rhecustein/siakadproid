@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
        Tambah Siswa Baru
    </h1>
    <p class="text-gray-600 text-base">Isi data lengkap siswa dan hubungkan dengan akun pengguna serta orang tua yang sesuai.</p>
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
    <form action="{{ route('core.students.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        {{-- Section: Informasi Dasar Siswa --}}
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b pb-2">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i> Informasi Dasar Siswa
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: Ahmad Fauzi" required autofocus>
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-800 mb-1">Jenis Kelamin</label>
                <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih —</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="nis" class="block text-sm font-semibold text-gray-800 mb-1">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: 20240001">
                @error('nis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="nisn" class="block text-sm font-semibold text-gray-800 mb-1">NISN (Nomor Induk Siswa Nasional)</label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: 0081234567">
                @error('nisn') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-semibold text-gray-800 mb-1">Nomor HP Siswa (Opsional)</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: 0812xxxxxx">
                @error('phone_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="place_of_birth" class="block text-sm font-semibold text-gray-800 mb-1">Tempat Lahir</label>
                <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: Jakarta">
                @error('place_of_birth') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="date_of_birth" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
                @error('date_of_birth') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="religion" class="block text-sm font-semibold text-gray-800 mb-1">Agama</label>
                <input type="text" name="religion" id="religion" value="{{ old('religion') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                        placeholder="Misal: Islam">
                @error('religion') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-semibold text-gray-800 mb-1">Alamat Lengkap</label>
            <textarea name="address" id="address" rows="3"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Alamat lengkap siswa">{{ old('address') }}</textarea>
            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Section: Informasi Akademik --}}
        <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 flex items-center border-b pb-2">
            <i class="fas fa-book-reader mr-2 text-blue-600"></i> Informasi Akademik
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-1">Sekolah <span class="text-red-500">*</span></label>
                <select name="school_id" id="school_id" required
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Sekolah —</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="grade_id" class="block text-sm font-semibold text-gray-800 mb-1">Kelas <span class="text-red-500">*</span></label>
                <select name="grade_id" id="grade_id" required
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Kelas —</option>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
                @error('grade_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="admission_date" class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Masuk</label>
                <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date') }}"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200">
                @error('admission_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="student_status" class="block text-sm font-semibold text-gray-800 mb-1">Status Siswa <span class="text-red-500">*</span></label>
                <select name="student_status" id="student_status" required
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Status —</option>
                    <option value="aktif" {{ old('student_status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('student_status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="alumni" {{ old('student_status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="lulus" {{ old('student_status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
                @error('student_status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Section: Akun & Orang Tua --}}
        <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 flex items-center border-b pb-2">
            <i class="fas fa-users-cog mr-2 text-blue-600"></i> Akun Pengguna & Informasi Orang Tua
        </h3>
        <div class="p-6 bg-blue-50 rounded-xl border border-blue-200 shadow-inner mb-6">
            <h4 class="text-base font-bold text-blue-800 mb-3 flex items-center">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i> Hubungkan Akun Pengguna Siswa
            </h4>
            <p class="text-sm text-gray-700 mb-4">Pilih akun pengguna yang sudah ada untuk siswa ini, atau sistem akan membuatkan akun baru secara otomatis.</p>

            <div class="mb-4">
                <label for="user_id_option" class="block text-sm font-semibold text-gray-800 mb-1">Opsi Akun Pengguna</label>
                <select name="user_id_option" id="user_id_option" class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="create_new" {{ old('user_id_option') == 'create_new' ? 'selected' : '' }}>Buat Akun Baru Otomatis</option>
                    <option value="select_existing" {{ old('user_id_option') == 'select_existing' ? 'selected' : '' }}>Pilih Akun yang Sudah Ada</option>
                </select>
                @error('user_id_option') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="existing_user_section" class="{{ old('user_id_option') == 'select_existing' ? '' : 'hidden' }} mt-4">
                <label for="user_search" class="block text-sm font-semibold text-gray-800 mb-1">Cari Pengguna Berdasarkan Nama/Email</label>
                <input type="text" id="user_search" class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" placeholder="Ketik nama atau email pengguna...">

                <label for="user_id" class="block text-sm font-semibold text-gray-800 mt-4 mb-1">Pilih Pengguna</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Akun Pengguna —</option>
                    {{-- Options will be dynamically loaded/filtered by JS --}}
                    @foreach ($availableUsers as $user)
                        <option value="{{ $user->id }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div id="new_user_email_section" class="{{ old('user_id_option') == 'create_new' ? '' : 'hidden' }} mt-4">
                 <label for="email_new_user" class="block text-sm font-semibold text-gray-800 mb-1">Email Akun Baru <span class="text-red-500">*</span></label>
                 <input type="email" name="email_new_user" id="email_new_user" value="{{ old('email_new_user') }}"
                         class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                         placeholder="email.siswa@example.com">
                 @error('email_new_user') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="p-6 bg-blue-50 rounded-xl border border-blue-200 shadow-inner mb-6">
            <h4 class="text-base font-bold text-blue-800 mb-3 flex items-center">
                <i class="fas fa-users-line mr-2 text-blue-600"></i> Hubungkan dengan Orang Tua / Wali
            </h4>
            <p class="text-sm text-gray-700 mb-4">Pilih orang tua atau wali utama siswa ini dari daftar yang sudah ada.</p>
            <div>
                <label for="parent_search" class="block text-sm font-semibold text-gray-800 mb-1">Cari Orang Tua / Wali</label>
                <input type="text" id="parent_search" class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200" placeholder="Ketik nama orang tua...">
                <select name="parent_id" id="parent_id"
                        class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm text-sm py-2.5 px-4 pr-8 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                    <option value="">— Pilih Orang Tua —</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" data-name="{{ strtolower($parent->name) }}" data-relationship="{{ strtolower($parent->relationship) }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }} ({{ $parent->relationship }})
                        </option>
                    @endforeach
                </select>
                @error('parent_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Section: Lain-lain --}}
        <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 flex items-center border-b pb-2">
            <i class="fas fa-ellipsis-h mr-2 text-blue-600"></i> Informasi Lain-lain
        </h3>
        <div>
            <label for="notes" class="block text-sm font-semibold text-gray-800 mb-1">Catatan Tambahan</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-4 transition-all duration-200"
                      placeholder="Catatan khusus (jika ada)">{{ old('notes') }}</textarea>
            @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="photo" class="block text-sm font-semibold text-gray-800 mb-1">Foto Siswa (Opsional)</label>
            <input type="file" name="photo" id="photo"
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end items-center gap-4 pt-4">
            <a href="{{ route('core.students.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Siswa
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bearerToken = localStorage.getItem('sanctum_api_token');

        if (!bearerToken) {
            console.warn('Sanctum API Token not found in localStorage. API requests may fail.');
            // Optionally, you could display a user-friendly warning or redirect to login.
            // alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            // window.location.href = '{{ route('login') }}';
        }

        // --- User Account Section Logic ---
        const userIdOption = document.getElementById('user_id_option');
        const existingUserSection = document.getElementById('existing_user_section');
        const newUserEmailSection = document.getElementById('new_user_email_section');
        const userSearchInput = document.getElementById('user_search');
        const userIdSelect = document.getElementById('user_id');
        let availableUsersCache = []; // Cache for all available users

        function toggleUserSection() {
            if (userIdOption.value === 'select_existing') {
                existingUserSection.classList.remove('hidden');
                newUserEmailSection.classList.add('hidden');
                document.getElementById('email_new_user').removeAttribute('required'); // Make email_new_user NOT required
                userIdSelect.setAttribute('required', 'required'); // Make user_id required

                if (availableUsersCache.length === 0) {
                    fetchAvailableUsers(); // Fetch if not already cached
                } else {
                    filterUserOptions(); // Filter from cache
                }
            } else { // create_new
                existingUserSection.classList.add('hidden');
                newUserEmailSection.classList.remove('hidden');
                document.getElementById('email_new_user').setAttribute('required', 'required'); // Make email_new_user required
                userIdSelect.removeAttribute('required'); // Make user_id NOT required

                userSearchInput.value = ''; // Clear search when hiding
                userIdSelect.innerHTML = '<option value="">— Pilih Akun Pengguna —</option>'; // Clear options
            }
        }

        async function fetchAvailableUsers() {
            userIdSelect.innerHTML = '<option value="">Memuat pengguna...</option>';
            userSearchInput.disabled = true;

            try {
                if (!bearerToken) {
                    throw new Error("Token autentikasi tidak tersedia untuk permintaan API.");
                }
                const response = await fetch('/api/available-users-for-student', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Authorization': `Bearer ${bearerToken}` // Gunakan token dari localStorage
                    }
                });
                if (!response.ok) {
                    const errorBody = await response.json();
                    throw new Error(`Gagal memuat pengguna: ${errorBody.message || response.statusText}`);
                }
                availableUsersCache = await response.json();
                renderUserOptions(availableUsersCache);
            } catch (err) {
                console.error('Error fetching available users:', err.message);
                userIdSelect.innerHTML = `<option value="">${err.message}. Coba lagi.</option>`;
            } finally {
                userSearchInput.disabled = false;
            }
        }

        function filterUserOptions() {
            const searchTerm = userSearchInput.value.toLowerCase();
            const filteredOptions = availableUsersCache.filter(user => {
                const userName = user.name ? user.name.toLowerCase() : '';
                const userEmail = user.email ? user.email.toLowerCase() : '';
                return userName.includes(searchTerm) || userEmail.includes(searchTerm);
            });
            renderUserOptions(filteredOptions);
        }

        function renderUserOptions(usersToRender) {
            userIdSelect.innerHTML = '<option value="">— Pilih Akun Pengguna —</option>';
            usersToRender.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.name} (${user.email})`;
                option.dataset.name = user.name ? user.name.toLowerCase() : '';
                option.dataset.email = user.email ? user.email.toLowerCase() : '';
                userIdSelect.appendChild(option);
            });
            const oldUserId = "{{ old('user_id') }}";
            if (oldUserId && userIdSelect.querySelector(`option[value="${oldUserId}"]`)) {
                userIdSelect.value = oldUserId;
            }
        }

        // --- Parent Search Logic ---
        const parentSearchInput = document.getElementById('parent_search');
        const parentIdSelect = document.getElementById('parent_id');
        let availableParentsCache = [];

        async function fetchAvailableParents() {
            parentIdSelect.innerHTML = '<option value="">Memuat orang tua...</option>';
            parentSearchInput.disabled = true;

            try {
                if (!bearerToken) {
                    throw new Error("Token autentikasi tidak tersedia untuk permintaan API.");
                }
                const response = await fetch('/api/available-parents-for-student', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Authorization': `Bearer ${bearerToken}` // Gunakan token dari localStorage
                    }
                });
                if (!response.ok) {
                    const errorBody = await response.json();
                    throw new Error(`Gagal memuat orang tua: ${errorBody.message || response.statusText}`);
                }
                availableParentsCache = await response.json();
                renderParentOptions(availableParentsCache);
            } catch (err) {
                console.error('Error fetching available parents:', err.message);
                parentIdSelect.innerHTML = `<option value="">${err.message}. Coba lagi.</option>`;
            } finally {
                parentSearchInput.disabled = false;
            }
        }

        function filterParentOptions() {
            const searchTerm = parentSearchInput.value.toLowerCase();
            const filteredOptions = availableParentsCache.filter(parent => {
                const parentName = parent.name ? parent.name.toLowerCase() : '';
                const parentRelationship = parent.relationship ? parent.relationship.toLowerCase() : '';
                return parentName.includes(searchTerm) || parentRelationship.includes(searchTerm);
            });
            renderParentOptions(filteredOptions);
        }

        function renderParentOptions(parentsToRender) {
            parentIdSelect.innerHTML = '<option value="">— Pilih Orang Tua —</option>';
            parentsToRender.forEach(parent => {
                const option = document.createElement('option');
                option.value = parent.id;
                option.textContent = `${parent.name} (${parent.relationship})`;
                option.dataset.name = parent.name ? parent.name.toLowerCase() : '';
                option.dataset.relationship = parent.relationship ? parent.relationship.toLowerCase() : '';
                parentIdSelect.appendChild(option);
            });
            const oldParentId = "{{ old('parent_id') }}";
            if (oldParentId && parentIdSelect.querySelector(`option[value="${oldParentId}"]`)) {
                parentIdSelect.value = oldParentId;
            }
        }

        // Event Listeners
        userIdOption.addEventListener('change', toggleUserSection);
        userSearchInput.addEventListener('input', filterUserOptions);
        parentSearchInput.addEventListener('input', filterParentOptions);

        // Initial calls on page load
        toggleUserSection(); // For user account section, also triggers initial user fetch
        fetchAvailableParents(); // For parent search dropdown
    });
</script>
@endpush