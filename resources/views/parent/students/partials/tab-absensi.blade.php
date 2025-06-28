<div class="space-y-6">
    <!-- Ringkasan Kehadiran -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-green-50 p-4 rounded">
            <div class="text-xs text-green-700 uppercase">Total Hadir</div>
            <div class="text-xl font-bold">122</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded">
            <div class="text-xs text-yellow-700 uppercase">Total Izin</div>
            <div class="text-xl font-bold">5</div>
        </div>
        <div class="bg-orange-50 p-4 rounded">
            <div class="text-xs text-orange-700 uppercase">Total Sakit</div>
            <div class="text-xl font-bold">3</div>
        </div>
        <div class="bg-red-50 p-4 rounded">
            <div class="text-xs text-red-700 uppercase">Tanpa Keterangan</div>
            <div class="text-xl font-bold">2</div>
        </div>
    </div>

    <!-- Grafik Kehadiran Bulanan -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-md font-semibold text-gray-800 mb-2">Grafik Kehadiran Bulanan</h3>
        <canvas id="chartAttendanceMonthly" height="200"></canvas>
    </div>

    <!-- Tabel Kehadiran Harian -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-md font-semibold text-gray-800 mb-2">Rekap Harian</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border">2025-05-01</td>
                        <td class="px-4 py-2 border text-green-600 font-semibold">Hadir</td>
                        <td class="px-4 py-2 border">-</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">2025-05-02</td>
                        <td class="px-4 py-2 border text-yellow-600 font-semibold">Izin</td>
                        <td class="px-4 py-2 border">Demam</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">2025-05-03</td>
                        <td class="px-4 py-2 border text-red-600 font-semibold">Tanpa Keterangan</td>
                        <td class="px-4 py-2 border">Tidak hadir</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ctxAttendanceMonthly = document.getElementById('chartAttendanceMonthly');
    new Chart(ctxAttendanceMonthly, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [
                {
                    label: 'Hadir',
                    data: [20, 18, 21, 19, 20],
                    backgroundColor: '#10B981'
                },
                {
                    label: 'Izin',
                    data: [1, 2, 1, 2, 1],
                    backgroundColor: '#FBBF24'
                },
                {
                    label: 'Sakit',
                    data: [1, 1, 0, 1, 0],
                    backgroundColor: '#FB923C'
                },
                {
                    label: 'Tanpa Keterangan',
                    data: [0, 1, 1, 0, 1],
                    backgroundColor: '#EF4444'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
