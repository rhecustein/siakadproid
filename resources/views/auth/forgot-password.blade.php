<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password • SIAKAD Al-Bahjah</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-400 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
    <div class="text-center mb-8">
      <img src="{{ asset('images/logo.png') }}" alt="Logo SIAKAD Al-Bahjah" class="w-16 mx-auto mb-3">
      <h2 class="text-2xl font-bold text-blue-700">Lupa Password</h2>
      <p class="text-sm text-gray-500">
        Masukkan alamat email Anda, kami akan kirimkan link untuk reset password.
      </p>
    </div>

    @if (session('status'))
      <div class="mb-4 text-sm text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
        <input id="email" name="email" type="email" required autocomplete="email"
               class="mt-1 block w-full px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring focus:ring-blue-500">
        @error('email')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl shadow-md transition">
          Kirim Link Reset
        </button>
      </div>

      <div class="text-center">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Kembali ke Login</a>
      </div>
    </form>
  </div>

</body>
</html>
