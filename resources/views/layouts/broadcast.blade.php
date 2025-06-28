<!-- FULLSCREEN ALERT -->
<div id="globalAlert" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[9999]">
  <div id="alertBox" class="text-center text-white p-6 rounded-xl shadow-xl max-w-sm w-full mx-4">
    <div id="alertIcon" class="text-5xl mb-4">⚠️</div>
    <h2 id="alertTitle" class="text-xl font-bold mb-2">Judul</h2>
    <p id="alertMessage" class="text-sm mb-4">Pesan detail alert.</p>
    <button onclick="closeAlert()" class="px-4 py-2 mt-2 bg-white text-black rounded font-semibold">Tutup</button>
  </div>
</div>

<script>
  function triggerAlert(type) {
    const wrapper = document.getElementById('globalAlert');
    const box = document.getElementById('alertBox');
    const icon = document.getElementById('alertIcon');
    const title = document.getElementById('alertTitle');
    const message = document.getElementById('alertMessage');

    wrapper.classList.remove('hidden');

    switch (type) {
      case 'emergency':
        box.className = 'bg-red-700 text-white p-6 rounded-xl shadow-xl max-w-sm w-full mx-4';
        icon.innerText = '🚨';
        title.innerText = 'PERINGATAN GEMPA!';
        message.innerText = 'Segera menuju titik evakuasi dan jangan panik.';
        break;
      case 'violation':
        box.className = 'bg-orange-600 text-white p-6 rounded-xl shadow-xl max-w-sm w-full mx-4';
        icon.innerText = '❗';
        title.innerText = 'Pelanggaran Disiplin';
        message.innerText = 'Siswa terlambat kembali ke asrama.';
        break;
      case 'reminder':
        box.className = 'bg-blue-700 text-white p-6 rounded-xl shadow-xl max-w-sm w-full mx-4';
        icon.innerText = '🕌';
        title.innerText = 'Waktu Sholat';
        message.innerText = 'Sholat berjamaah akan dimulai. Silakan bersiap.';
        break;
      case 'event':
        box.className = 'bg-purple-700 text-white p-6 rounded-xl shadow-xl max-w-sm w-full mx-4';
        icon.innerText = '📢';
        title.innerText = 'Pengumuman Umum';
        message.innerText = 'Malam ini ada acara Mabit untuk santri senior.';
        break;
    }
  }

  function closeAlert() {
    document.getElementById('globalAlert').classList.add('hidden');
  }
</script>
<!-- CONFIRM MODAL -->
<div id="confirmBroadcast" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[9999]">
  <div id="confirmBox" class="bg-white text-gray-800 p-6 rounded-xl shadow-2xl w-full max-w-md mx-4 scale-95 opacity-0 transition-all duration-300">
    <div class="text-3xl mb-4 text-center" id="confirmIcon">📢</div>
    <h2 class="text-xl font-bold text-center mb-2" id="confirmTitle">Judul</h2>
    <p class="text-center mb-6 text-sm" id="confirmMessage">Isi pesan alert</p>
    <div class="flex justify-end gap-4">
      <button onclick="closeConfirm()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded font-semibold">❌ Tidak</button>
      <button onclick="acceptConfirm()" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded font-semibold">✅ Ya</button>
    </div>
  </div>
</div>

<audio id="broadcastSound" preload="auto">
  <source src="https://www.soundjay.com/button/beep-07.mp3" type="audio/mpeg">
</audio>

<script>
  function triggerConfirmAlert(title, message) {
    document.getElementById('confirmTitle').innerText = title;
    document.getElementById('confirmMessage').innerText = message;
    const modal = document.getElementById('confirmBroadcast');
    const box = document.getElementById('confirmBox');
    modal.classList.remove('hidden');
    setTimeout(() => {
      box.classList.remove('scale-95', 'opacity-0');
      box.classList.add('scale-100', 'opacity-100');
    }, 50);

    const sound = document.getElementById('broadcastSound');
    sound.currentTime = 0;
    sound.play();
  }

  function closeConfirm() {
    const modal = document.getElementById('confirmBroadcast');
    const box = document.getElementById('confirmBox');
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
  }

  function acceptConfirm() {
    alert('✅ Terima kasih, respon disimpan (simulasi).');
    closeConfirm();
  }
</script>
