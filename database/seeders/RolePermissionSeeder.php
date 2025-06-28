<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua role dari database
        $roles = DB::table('roles')->get()->keyBy('name');

        // Daftar permissions berdasarkan fungsi role
        $permissionsMap = [

            // Superadmin: akses penuh
            'superadmin' => ['*'],

            // Admin & developer
            'admin' => [
                'user.manage', 'role.manage', 'absensi.view', 'laporan.view',
                'siswa.view', 'tagihan.manage', 'kantin.transaksi', 'parkir.view'
            ],
            'developer' => [
                'system.config', 'role.manage', 'log.view', 'error.report'
            ],
            'operator_siakad' => [
                'nilai.input', 'nilai.view', 'absensi.input', 'jadwal.manage'
            ],

            // Kepala
            'kepala_yayasan' => ['laporan.view', 'keuangan.view', 'siswa.view'],
            'kepala_sekolah' => ['laporan.view', 'nilai.view', 'absensi.view'],
            'kepala_madrasah' => ['laporan.view', 'nilai.view', 'absensi.view'],
            'wakil_kepala_sekolah' => ['jadwal.manage', 'nilai.approve'],
            'koordinator_unit' => ['unit.siswa.manage', 'laporan.unit.view'],
            'tim_pengasuhan' => ['asrama.view', 'pelanggaran.manage', 'penghargaan.manage'],

            // Guru
            'guru' => ['nilai.input', 'absensi.input', 'jadwal.view', 'siswa.view'],
            'wali_kelas' => ['absensi.kelas.view', 'siswa.kelas.view', 'catatan.kelas.input'],
            'guru_tahfidz' => ['tahfidz.input', 'tahfidz.view'],
            'guru_bk' => ['konseling.input', 'konseling.view'],
            'penguji' => ['ujian.nilai.input', 'ujian.schedule.view'],
            'pembina_ekskul' => ['ekskul.input', 'ekskul.view'],

            // Siswa
            'siswa' => ['nilai.view', 'absensi.view', 'pembayaran.view', 'jadwal.view'],
            'santri' => ['jadwal.view', 'absensi.view', 'asrama.info'],

            // Orang Tua
            'orang_tua' => ['nilai.anak.view', 'absensi.anak.view', 'pembayaran.anak.view'],

            // Operasional
            'keuangan' => ['tagihan.manage', 'topup.input', 'saldo.view'],
            'petugas_kantin' => ['kantin.transaksi', 'kantin.menu.manage'],
            'petugas_parkir' => ['parkir.transaksi', 'parkir.laporan'],
            'petugas_laundry' => ['laundry.transaksi'],
            'petugas_absensi' => ['absensi.device.monitor'],
            'petugas_perpustakaan' => ['buku.pinjam', 'buku.kembali'],
            'petugas_asrama' => ['asrama.kontrol', 'santri.izin.manage'],
            'petugas_kebersihan' => ['check.kebersihan'],

            // Keamanan & Maintenance
            'petugas_keamanan' => ['akses.kontrol', 'tamu.checkin'],
            'petugas_teknis' => ['device.monitor', 'jaringan.cek'],
            'maintenance' => ['maintenance.schedule'],

            // Eksternal
            'pengawas_yayasan' => ['audit.view', 'laporan.keuangan.view'],
            'auditor' => ['audit.laporan.view'],
            'tamu' => ['tamu.request'],
        ];

        $now = Carbon::now();

        foreach ($permissionsMap as $roleName => $permissions) {
            $roleId = $roles[$roleName]->id ?? null;
            if (!$roleId) continue;

            foreach ($permissions as $permission) {
                DB::table('role_permissions')->updateOrInsert(
                    ['role_id' => $roleId, 'permission' => $permission],
                    [
                        'allowed' => true,
                        'context' => null,
                        'conditions' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
