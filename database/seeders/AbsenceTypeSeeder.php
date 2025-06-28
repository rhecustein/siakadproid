<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbsenceType;

class AbsenceTypeSeeder extends Seeder
{
    public function run(): void
    {
        AbsenceType::insert([
            ['name' => 'sekolah',         'label' => 'Absensi Sekolah',         'group' => 'akademik'],
            ['name' => 'sholat',          'label' => 'Sholat Wajib',            'group' => 'ibadah'],
            ['name' => 'kegiatan_harian', 'label' => 'Kegiatan Harian',         'group' => 'kegiatan'],
            ['name' => 'kegiatan_mingguan','label' => 'Kegiatan Mingguan',      'group' => 'kegiatan'],
            ['name' => 'tidur_malam',     'label' => 'Tidur Malam Santri',      'group' => 'asrama'],
            ['name' => 'tidur_siang',     'label' => 'Tidur Siang Santri',      'group' => 'asrama'],
            ['name' => 'makan',           'label' => 'Makan Santri',            'group' => 'konsumsi'],
            ['name' => 'laundry',         'label' => 'Laundry Formal',          'group' => 'kegiatan'],
            ['name' => 'ekstrakurikuler', 'label' => 'Ekstrakurikuler',         'group' => 'akademik'],
            ['name' => 'tahfidz',         'label' => 'Kelas Tahfidz',           'group' => 'akademik'],
            ['name' => 'piket',           'label' => 'Piket Kebersihan',        'group' => 'kegiatan'],
            ['name' => 'izin_keluar',     'label' => 'Izin Keluar Pondok',      'group' => 'pengasuhan'],
            ['name' => 'konseling',       'label' => 'Konseling/Bimbingan',     'group' => 'pengasuhan'],
            ['name' => 'asrama',          'label' => 'Absensi Asrama',          'group' => 'asrama'],
        ]);
    }
}
