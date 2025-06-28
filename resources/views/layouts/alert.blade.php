<!-- FULLSCREEN ALERT -->
<div id="globalAlert" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[9999] transition-all duration-300 ease-out">
  <div id="alertBox" class="text-center text-white p-6 rounded-xl shadow-2xl max-w-sm w-full mx-4 scale-90 opacity-0 transition-all duration-500 ease-in-out">
    <div id="alertIcon" class="text-5xl mb-4 animate-pulse">⚠️</div>
    <h2 id="alertTitle" class="text-2xl font-bold mb-2 tracking-wide">Judul</h2>
    <p id="alertMessage" class="text-sm mb-4">Pesan detail alert.</p>
    <button onclick="closeAlert()" id="alertCloseBtn" class="px-4 py-2 mt-2 bg-white/90 text-black rounded font-semibold hover:bg-white hidden">Tutup</button>
  </div>
</div>

<!-- AUDIO ELEMENT -->
<audio id="alertSound" preload="auto">
  <source src="https://www.soundjay.com/buttons/sounds/button-10.mp3" type="audio/mpeg">
</audio>

<script>
  function triggerAlert(type) {
    const wrapper = document.getElementById('globalAlert');
    const box = document.getElementById('alertBox');
    const icon = document.getElementById('alertIcon');
    const title = document.getElementById('alertTitle');
    const message = document.getElementById('alertMessage');
    const closeBtn = document.getElementById('alertCloseBtn');
    const sound = document.getElementById('alertSound');

    // Reset
    closeBtn.classList.add('hidden');
    box.className = 'text-center text-white p-6 rounded-xl shadow-2xl max-w-sm w-full mx-4 scale-90 opacity-0 transition-all duration-500 ease-in-out';
    wrapper.classList.remove('hidden');

    // Play sound
    sound.currentTime = 0;
    sound.play();

    // Animate in
    setTimeout(() => {
      box.classList.remove('scale-90', 'opacity-0');
      box.classList.add('scale-100', 'opacity-100');
    }, 100);

    // Config by type
    switch (type) {
      case 'emergency':
        box.classList.add('bg-red-700');
        icon.innerText = '🚨';
        title.innerText = 'PERINGATAN GEMPA!';
        message.innerText = 'Segera menuju titik evakuasi dan jangan panik.';
        break;

      case 'violation':
        box.classList.add('bg-orange-600');
        icon.innerText = '❗';
        title.innerText = 'Pelanggaran Disiplin';
        message.innerText = 'Siswa terlambat kembali ke asrama.';
        closeBtn.classList.remove('hidden');
        break;

      case 'reminder':
        box.classList.add('bg-blue-700');
        icon.innerText = '🕌';
        title.innerText = 'Waktu Sholat Telah Tiba';
        message.innerText = 'Sholat berjamaah akan dimulai. Silakan bersiap.';
        closeBtn.classList.remove('hidden');
        break;

      case 'event':
        box.classList.add('bg-purple-700');
        icon.innerText = '📢';
        title.innerText = 'Acara Pondok Hari Ini';
        message.innerText = 'Jangan lupa ikut kegiatan Mabit setelah Isya.';
        closeBtn.classList.remove('hidden');
        break;
    }
  }

  function closeAlert() {
    const wrapper = document.getElementById('globalAlert');
    const box = document.getElementById('alertBox');
    box.classList.add('scale-90', 'opacity-0');
    setTimeout(() => wrapper.classList.add('hidden'), 300);
  }
</script>
