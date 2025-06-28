<div class="bg-white shadow rounded p-6">
    <h2 class="text-md font-semibold text-gray-700 mb-4">Ringkasan Tagihan</h2>

    <p class="text-sm text-gray-800 mb-1">
        Siswa Terpilih:
        <span id="studentCount">0</span>
    </p>
    <p class="text-sm text-gray-800 mb-1">
        Nominal per Tagihan:
        <span class="font-semibold text-blue-700">Rp <span id="nominal">0</span></span>
    </p>
    <p class="text-sm text-gray-800 mb-1">
        Jumlah Tagihan / Siswa:
        <span id="count">0</span>
    </p>

    <div class="mt-4 border-t pt-4">
        <p class="text-sm text-gray-900 font-bold">Total Tagihan Akan Dibuat:</p>
        <p class="text-lg font-extrabold text-green-700" id="totalTagihan">Rp 0</p>
    </div>

    <div id="groupDetail" class="mt-6 text-sm text-gray-600 space-y-1 hidden">
        <p><strong>Deskripsi:</strong> <span id="descText">-</span></p>
        <p><strong>Tahun Ajaran:</strong> <span id="yearText">-</span></p>
        <p><strong>Jenis Kelamin:</strong> <span id="genderText">-</span></p>
        <p><strong>Periode:</strong> <span id="periodText">-</span></p>
    </div>
</div>

<script>
    function updateSummary() {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        const studentCount = document.getElementById('studentCount');
        const totalEl = document.getElementById('totalTagihan');
        const nominalEl = document.getElementById('nominal');
        const countEl = document.getElementById('count');
        const billGroupSelect = document.querySelector('select[name="bill_group_id"]');
        const selected = billGroupSelect.options[billGroupSelect.selectedIndex];

        const nominal = parseFloat(selected.getAttribute('data-nominal')) || 0;
        const jumlah = parseInt(selected.getAttribute('data-count')) || 1;
        const total = checked.length * nominal * jumlah;

        studentCount.innerText = checked.length;
        nominalEl.innerText = nominal.toLocaleString('id-ID');
        countEl.innerText = jumlah;
        totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');

        const desc = selected.getAttribute('data-description') || '-';
        const year = selected.getAttribute('data-year') || '-';
        const gender = selected.getAttribute('data-gender') || '-';
        const start = selected.getAttribute('data-start') || '';
        const end = selected.getAttribute('data-end') || '';

        document.getElementById('groupDetail').classList.remove('hidden');
        document.getElementById('descText').innerText = desc;
        document.getElementById('yearText').innerText = year;
        document.getElementById('genderText').innerText = gender === 'male' ? 'Laki-laki' : (gender === 'female' ? 'Perempuan' : '-');
        document.getElementById('periodText').innerText = start && end ? `${start} s.d ${end}` : '-';
    }

    document.querySelectorAll('.student-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSummary);
    });

    document.querySelector('select[name="bill_group_id"]').addEventListener('change', updateSummary);

    document.addEventListener('DOMContentLoaded', updateSummary);
</script>
