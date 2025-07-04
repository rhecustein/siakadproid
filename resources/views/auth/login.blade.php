<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk • SIAKAD Al-Bahjah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-neutral-50 to-blue-50 text-neutral-800 antialiased font-sans relative overflow-hidden">
    <div class="login-bg-animation"></div> {{-- Latar belakang animasi --}}

    <div class="flex min-h-screen relative z-10 lg:p-0"> {{-- Hapus p-4 sm:p-8 dari sini karena container di dalamnya akan memiliki padding --}}
        {{-- Konten Formulir Login (Sisi Kiri) --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 bg-white bg-opacity-95 lg:bg-opacity-90 backdrop-blur-sm lg:rounded-none shadow-2xl lg:shadow-none transition-all duration-300 relative z-20 rounded-3xl"> {{-- Tambahkan z-20 dan rounded-3xl di sini --}}
            <div class="w-full max-w-md p-6 sm:p-8 bg-white rounded-3xl shadow-xl border border-gray-100 transform -translate-y-4 animate-fade-in-up animate-delay-200">
                <div class="mb-8 text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Bahjah" class="w-24 mx-auto mb-5 ai-logo-glow">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-3">Selamat Datang</h1>
                    <p class="text-base text-gray-600">Silakan masuk untuk mengakses sistem SIAKAD Anda.</p>
                </div>

                <div>
                    <div class="flex mb-8 border-b border-gray-200">
                        <button id="tab-email" class="flex-1 py-4 text-center font-semibold text-blue-600 tab-active-underline transition-colors duration-200 focus:outline-none">Email</button>
                        <button id="tab-wa" class="flex-1 py-4 text-center font-semibold text-gray-500 hover:text-blue-600 transition-colors duration-200 focus:outline-none">WhatsApp</button>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="form-email">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input id="email" name="email" type="email" required autocomplete="email" autofocus class="block w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none" placeholder="alamat@contoh.com">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none" placeholder="********">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <label class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200 cursor-pointer select-none">
                                <input type="checkbox" name="remember" class="form-radio-checkbox">
                                <span class="ml-2">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-medium transition-colors duration-200">Lupa Password?</a>
                            @endif
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3.5 rounded-lg text-lg font-semibold shadow-md hover:shadow-lg hover:bg-blue-700 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Masuk
                            <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                        <div id="login-error-message" class="text-red-600 text-sm mt-2 hidden"></div>
                    </form>

                    <div id="form-wa" class="space-y-6 hidden">
                        <form id="wa-form" class="space-y-6">
                            <div id="wa-step1">
                                <label for="phone_wa" class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="tel" id="phone_wa" name="phone" placeholder="Contoh: 081234567890" class="block w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 outline-none">
                                <button type="button" onclick="sendOtp()" class="w-full bg-green-600 text-white py-3.5 rounded-lg text-lg font-semibold shadow-md hover:shadow-lg mt-4 hover:bg-green-700 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    Kirim Kode Akses
                                </button>
                            </div>
                            <div id="wa-step2" class="hidden">
                                <label for="otp_wa" class="block text-sm font-semibold text-gray-700 mb-2">Kode Akses</label>
                                <input type="text" id="otp_wa" name="otp" maxlength="6" placeholder="Masukkan kode 6 digit" class="block w-full rounded-lg border-gray-300 px-4 py-3 text-base text-center tracking-widest shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 outline-none">
                                <div class="space-y-2 mt-4">
                                    <label class="flex items-center text-gray-600 cursor-pointer">
                                        <input type="radio" name="remember_wa" value="1" checked class="form-radio-checkbox">
                                        <span class="ml-2">1 Hari</span>
                                    </label>
                                    <label class="flex items-center text-gray-600 cursor-pointer">
                                        <input type="radio" name="remember_wa" value="3" class="form-radio-checkbox">
                                        <span class="ml-2">3 Hari</span>
                                    </label>
                                    <label class="flex items-center text-gray-600 cursor-pointer">
                                        <input type="radio" name="remember_wa" value="7" class="form-radio-checkbox">
                                        <span class="ml-2">7 Hari</span>
                                    </label>
                                </div>
                                <button type="submit" class="w-full bg-green-700 text-white py-3.5 rounded-lg text-lg font-semibold shadow-md hover:shadow-lg mt-4 hover:bg-green-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    Masuk dengan WhatsApp
                                </button>
                            </div>
                            <div id="wa-error-message" class="text-red-600 text-sm mt-2 hidden"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visual Panel (Sisi Kanan) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-700 to-indigo-800 login-visual-panel items-center justify-center">
            {{-- Background Grid/Lines --}}
            <div class="visual-grid-overlay"></div>

            {{-- Abstract Shapes / Blobs --}}
            <div class="visual-circle-1"></div>
            <div class="visual-circle-2"></div>

            {{-- Main Content / Icon (centered) --}}
            <div class="relative z-10 text-center">
                <svg class="w-48 h-48 mx-auto mb-6 text-white visual-pulse-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
                <h2 class="text-4xl font-extrabold text-white mb-4 drop-shadow-md animate-fade-in animate-delay-300">
                    SIAKAD Modern<br>Berbasis AI
                </h2>
                <p class="text-lg text-white text-opacity-80 max-w-sm mx-auto animate-fade-in animate-delay-400">
                    Platform cerdas untuk mengelola pendidikan dengan efisiensi dan insight data.
                </p>
            </div>
        </div>
    </div>

    <script>
        const tabEmail = document.getElementById('tab-email');
        const tabWA = document.getElementById('tab-wa');
        const formEmail = document.getElementById('form-email');
        const formWA = document.getElementById('form-wa');
        const waStep1 = document.getElementById('wa-step1');
        const waStep2 = document.getElementById('wa-step2');
        const waForm = document.getElementById('wa-form');
        const loginErrorMessage = document.getElementById('login-error-message');
        const waErrorMessage = document.getElementById('wa-error-message');

        function setActiveTab(activeTabElement, inactiveTabElement, activeFormElement, inactiveFormElement) {
            activeFormElement.classList.remove('hidden');
            inactiveFormElement.classList.add('hidden');
            activeTabElement.classList.add('tab-active-underline', 'text-blue-600');
            inactiveTabElement.classList.remove('tab-active-underline', 'text-blue-600');
            inactiveTabElement.classList.add('text-gray-500');
        }

        tabEmail.onclick = () => setActiveTab(tabEmail, tabWA, formEmail, formWA);
        tabWA.onclick = () => setActiveTab(tabWA, tabEmail, formWA, formEmail);

        function showOtpForm() {
            waStep1.classList.add('hidden');
            waStep2.classList.remove('hidden');
        }

        async function sendOtp() {
            waErrorMessage.classList.add('hidden');
            waErrorMessage.textContent = '';

            const phone = document.getElementById('phone_wa').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Tambahkan loading state
            const sendButton = waStep1.querySelector('button');
            sendButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...';
            sendButton.disabled = true;

            try {
                const response = await fetch('/api/whatsapp/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone })
                });
                const data = await response.json();
                if (response.ok) {
                    alert('Kode akses telah dikirim ke WhatsApp Anda!');
                    showOtpForm();
                } else {
                    waErrorMessage.textContent = data.message || 'Gagal mengirim kode akses. Coba lagi.';
                    waErrorMessage.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error sending OTP:', error);
                waErrorMessage.textContent = 'Tidak dapat mengirim kode. Periksa koneksi Anda.';
                waErrorMessage.classList.remove('hidden');
            } finally {
                sendButton.innerHTML = 'Kirim Kode Akses';
                sendButton.disabled = false;
            }
        }

        waForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            waErrorMessage.classList.add('hidden');
            waErrorMessage.textContent = '';

            const phone = document.getElementById('phone_wa').value;
            const otp = document.getElementById('otp_wa').value;
            const rememberWa = document.querySelector('input[name="remember_wa"]:checked').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Tambahkan loading state
            const verifyButton = waStep2.querySelector('button[type="submit"]');
            verifyButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memverifikasi...';
            verifyButton.disabled = true;

            try {
                const response = await fetch('/api/whatsapp/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone, otp, remember: rememberWa })
                });
                const data = await response.json();
                if (response.ok && data.token) {
                    localStorage.setItem('sanctum_api_token', data.token);
                    window.location.href = '/dashboard';
                } else {
                    waErrorMessage.textContent = data.message || 'Verifikasi OTP gagal. Coba lagi.';
                    waErrorMessage.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error verifying OTP:', error);
                waErrorMessage.textContent = 'Tidak dapat terhubung ke server. Periksa koneksi Anda.';
                waErrorMessage.classList.remove('hidden');
            } finally {
                verifyButton.innerHTML = 'Masuk dengan WhatsApp';
                verifyButton.disabled = false;
            }
        });

        // Initialize active tab based on error presence
        if (document.querySelector('#form-email .text-red-600') && !document.querySelector('#form-email .hidden')) {
            setActiveTab(tabEmail, tabWA, formEmail, formWA);
        } else if (document.querySelector('#form-wa .text-red-600') && !document.querySelector('#form-wa .hidden')) {
            setActiveTab(tabWA, tabEmail, formWA, formEmail);
        } else {
            // Default to email tab if no errors
            setActiveTab(tabEmail, tabWA, formEmail, formWA);
        }
    </script>
</body>
</html>