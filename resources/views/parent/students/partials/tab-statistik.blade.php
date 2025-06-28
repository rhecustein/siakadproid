<div class="space-y-6">
    <!-- Grafik Rata-rata Nilai -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-md font-semibold text-gray-800 mb-2">Perkembangan Rata-rata Nilai</h3>
        <canvas id="chartAverageScore" height="200"></canvas>
    </div>

    <!-- Grafik Kehadiran Bulanan -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-md font-semibold text-gray-800 mb-2">Grafik Kehadiran Bulanan</h3>
        <canvas id="chartAttendance" height="200"></canvas>
    </div>

    <!-- Grafik Distribusi Nilai per Mapel -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-md font-semibold text-gray-800 mb-2">Distribusi Nilai per Mata Pelajaran</h3>
        <canvas id="chartSubjectScores" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const avgScoreCtx = document.getElementById('chartAverageScore');
    new Chart(avgScoreCtx, {
        type: 'line',
        data: {
            labels: ['Semester 1', 'Semester 2', 'Semester 3'],
            datasets: [{
                label: 'Rata-rata Nilai',
                data: [82, 85, 88],
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.1)',
                tension: 0.4
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    const attendCtx = document.getElementById('chartAttendance');
    new Chart(attendCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [
                {
                    label: 'Hadir',
                    data: [20, 19, 21, 22, 20],
                    backgroundColor: '#10B981'
                },
                {
                    label: 'Izin/Sakit',
                    data: [2, 1, 0, 2, 1],
                    backgroundColor: '#F59E0B'
                }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    const subjectScoreCtx = document.getElementById('chartSubjectScores');
    new Chart(subjectScoreCtx, {
        type: 'doughnut',
        data: {
            labels: ['Matematika', 'Bahasa Arab', 'Bahasa Indonesia', 'Fiqih'],
            datasets: [{
                data: [85, 90, 82, 88],
                backgroundColor: ['#3B82F6', '#8B5CF6', '#F59E0B', '#10B981']
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush
