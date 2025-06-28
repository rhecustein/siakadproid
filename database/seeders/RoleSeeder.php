<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
      $roles = [
            // System & Central Roles
            ['name' => 'superadmin',             'display_name' => 'Super Administrator'], // full control
            ['name' => 'admin',                  'display_name' => 'Administrator'],       // general admin
            ['name' => 'developer',              'display_name' => 'System Developer'],    // internal/outsourced IT
            ['name' => 'operator_siakad',        'display_name' => 'SIAKAD Operator'],     // input nilai, absensi, dsb

            // Manajemen Yayasan dan Sekolah
            ['name' => 'kepala_yayasan',         'display_name' => 'Foundation Head'],
            ['name' => 'kepala_sekolah',         'display_name' => 'School Principal'],
            ['name' => 'kepala_madrasah',        'display_name' => 'Madrasah Head'],
            ['name' => 'wakil_kepala_sekolah',   'display_name' => 'Vice Principal'],
            ['name' => 'koordinator_unit',       'display_name' => 'Unit Coordinator'],     // boarding, tahfidz, dll
            ['name' => 'tim_pengasuhan',         'display_name' => 'Boarding Supervisor'], // pengasuhan santri

            // Pendidikan & Akademik
            ['name' => 'guru',                   'display_name' => 'Teacher'],
            ['name' => 'wali_kelas',             'display_name' => 'Homeroom Teacher'],
            ['name' => 'guru_tahfidz',           'display_name' => 'Tahfidz Teacher'],
            ['name' => 'guru_bk',                'display_name' => 'Guidance Counselor'],
            ['name' => 'kepala_laboratorium',    'display_name' => 'Head of Laboratory'],
            ['name' => 'pembina_ekskul',         'display_name' => 'Extracurricular Coach'],
            ['name' => 'penguji',                'display_name' => 'Examiner'], // ujian akhir atau praktik

            // Siswa & Wali
            ['name' => 'siswa',                  'display_name' => 'Student'],
            ['name' => 'santri',                 'display_name' => 'Boarding Student'], // jika ingin dibedakan
            ['name' => 'orang_tua',              'display_name' => 'Parent / Guardian'],

            // Layanan & Operasional
            ['name' => 'keuangan',              'display_name' => 'Finance Admin'],         // tagihan, topup, dll
            ['name' => 'petugas_kantin',        'display_name' => 'Canteen Operator'],
            ['name' => 'petugas_parkir',        'display_name' => 'Parking Operator'],
            ['name' => 'petugas_laundry',       'display_name' => 'Laundry Operator'],
            ['name' => 'petugas_absensi',       'display_name' => 'Attendance Staff'],     // monitoring fingerprint
            ['name' => 'petugas_perpustakaan',  'display_name' => 'Library Staff'],
            ['name' => 'petugas_asrama',        'display_name' => 'Dormitory Officer'],
            ['name' => 'petugas_kebersihan',    'display_name' => 'Cleaning Staff'],

            // Security & Maintenance
            ['name' => 'petugas_keamanan',      'display_name' => 'Security Officer'],
            ['name' => 'petugas_teknis',        'display_name' => 'Technical Staff'], // listrik, jaringan, dsb
            ['name' => 'maintenance',           'display_name' => 'Maintenance Crew'],

            // Eksternal & Evaluasi
            ['name' => 'pengawas_yayasan',      'display_name' => 'Foundation Supervisor'],
            ['name' => 'auditor',               'display_name' => 'Auditor / Inspector'],
            ['name' => 'tamu',                  'display_name' => 'Guest / Visitor'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'uuid' => (string) Str::uuid(),
                    'display_name' => $role['display_name'],
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
