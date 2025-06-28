<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login SIAKAD Al-Bahjah</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-neutral-800 antialiased">
  <div class="flex min-h-screen">
    <!-- LEFT: Form Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
      <div class="w-full max-w-md">
        <div class="mb-8 text-center">
          <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Bahjah" class="w-16 mx-auto mb-3">
          <h2 class="text-3xl font-bold">Selamat Datang</h2>
          <p class="text-sm text-gray-500">Silakan masuk untuk mengakses SIAKAD</p>
        </div>

        <div>
          <div class="flex mb-4 border-b border-gray-200">
            <button id="tab-email" class="flex-1 py-2 text-center font-semibold text-blue-600 border-b-2 border-blue-600">Email</button>
            <button id="tab-wa" class="flex-1 py-2 text-center font-semibold text-gray-500">WhatsApp</button>
          </div>

          <!-- Email Form -->
          <form method="POST" action="{{ route('login') }}" class="space-y-5" id="form-email">
            @csrf
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input id="email" name="email" type="email" required class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2">
            </div>
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2">
            </div>
            <div class="flex justify-between text-sm">
              <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                <span class="ml-2 text-gray-600">Ingat saya</span>
              </label>
              <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Lupa Password?</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl">Masuk</button>
          </form>

          <!-- WhatsApp Form -->
          <div id="form-wa" class="space-y-5 hidden">
            <form id="wa-step1">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <input type="tel" name="phone" placeholder="Contoh: 628123456789" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2">
              </div>
              <button type="button" onclick="showOtpForm()" class="w-full bg-green-600 text-white py-2 rounded-xl">Kirim Kode Akses</button>
            </form>
            <form id="wa-step2" class="hidden space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Kode Akses</label>
                <input type="text" name="otp" maxlength="6" placeholder="Masukkan kode" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2">
              </div>
              <div>
                <span class="block text-sm mb-1 text-gray-700">Simpan login untuk:</span>
                <div class="space-y-1">
                  <label class="inline-flex items-center">
                    <input type="radio" name="remember_wa" value="1" checked class="text-green-500">
                    <span class="ml-2">1 Hari</span>
                  </label><br>
                  <label class="inline-flex items-center">
                    <input type="radio" name="remember_wa" value="3" class="text-green-500">
                    <span class="ml-2">3 Hari</span>
                  </label><br>
                  <label class="inline-flex items-center">
                    <input type="radio" name="remember_wa" value="7" class="text-green-500">
                    <span class="ml-2">7 Hari</span>
                  </label>
                </div>
              </div>
              <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-xl">Masuk dengan WhatsApp</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Ilustrasi -->
    <div class="hidden lg:flex lg:w-1/2 bg-blue-50 items-center justify-center">
      <img src="{{ asset('images/bannes.png') }}" alt="Banner" class="w-full h-full object-cover">
    </div>
  </div>

  <script>
    const tabEmail = document.getElementById('tab-email');
    const tabWA = document.getElementById('tab-wa');
    const formEmail = document.getElementById('form-email');
    const formWA = document.getElementById('form-wa');
    const waStep1 = document.getElementById('wa-step1');
    const waStep2 = document.getElementById('wa-step2');

    tabEmail.onclick = () => {
      formEmail.classList.remove('hidden');
      formWA.classList.add('hidden');
      tabEmail.classList.add('text-blue-600', 'border-blue-600');
      tabWA.classList.remove('text-blue-600', 'border-blue-600');
    };

    tabWA.onclick = () => {
      formEmail.classList.add('hidden');
      formWA.classList.remove('hidden');
      tabWA.classList.add('text-blue-600', 'border-blue-600');
      tabEmail.classList.remove('text-blue-600', 'border-blue-600');
    };

    function showOtpForm() {
      waStep1.classList.add('hidden');
      waStep2.classList.remove('hidden');
    }
  </script>
</body>
</html>
