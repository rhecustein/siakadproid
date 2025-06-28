<div class="space-y-4">
    <!-- Header + Selector -->
    <div class="flex justify-between items-center">
        <h3 class="text-md font-semibold text-gray-800">Daftar Nilai Semester</h3>
        <select class="border border-gray-300 rounded-md text-sm px-2 py-1">
            <option>Semester 1</option>
            <option>Semester 2</option>
            <option>Semester 3</option>
        </select>
    </div>

    <!-- Table Nilai -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Mata Pelajaran</th>
                    <th class="px-4 py-2 border">Nilai</th>
                    <th class="px-4 py-2 border">Predikat</th>
                    <th class="px-4 py-2 border">Ranking Mapel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border text-center">1</td>
                    <td class="px-4 py-2 border">Matematika</td>
                    <td class="px-4 py-2 border text-center">85</td>
                    <td class="px-4 py-2 border text-center">A</td>
                    <td class="px-4 py-2 border text-center">3 dari 28</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border text-center">2</td>
                    <td class="px-4 py-2 border">Bahasa Arab</td>
                    <td class="px-4 py-2 border text-center">90</td>
                    <td class="px-4 py-2 border text-center">A</td>
                    <td class="px-4 py-2 border text-center">1 dari 28</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border text-center">3</td>
                    <td class="px-4 py-2 border">Fiqih</td>
                    <td class="px-4 py-2 border text-center">78</td>
                    <td class="px-4 py-2 border text-center">B</td>
                    <td class="px-4 py-2 border text-center">7 dari 28</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Ringkasan -->
    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded">
            <div class="text-xs text-blue-700 uppercase">Rata-rata Semester</div>
            <div class="text-xl font-bold">84.3</div>
        </div>
        <div class="bg-green-50 p-4 rounded">
            <div class="text-xs text-green-700 uppercase">Ranking Kelas</div>
            <div class="text-xl font-bold">5 dari 28</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded">
            <div class="text-xs text-yellow-700 uppercase">Jumlah Mapel</div>
            <div class="text-xl font-bold">12</div>
        </div>
    </div>
</div>
