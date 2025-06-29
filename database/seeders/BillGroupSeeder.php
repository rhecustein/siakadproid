<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\BillType;
use App\Models\BillGroup;
use App\Models\GradeLevel;

class BillGroupSeeder extends Seeder
{
    public function run()
    {
        // Pastikan sekolah, tahun ajaran, level, dan grade sudah ada
        $smp = School::where('name', 'SMP Al Bahjah')->first();
        $sma = School::where('name', 'SMA Al Bahjah')->first();

        // Ambil ID dari academic year yang akan digunakan
        $academicYear2024_2025 = AcademicYear::where('year', '2024-2025')->first();
        $academicYear2025_2026 = AcademicYear::where('year', '2025-2026')->first();
        // Pastikan tahun ajaran ini ada di database Anda atau buat jika belum.

        // Ambil ID dari BillType yang akan digunakan
        $sppBillType = BillType::where('name', 'SPP Bulanan')->first();
        $formulirPendaftaranBillType = BillType::where('name', 'Formulir Pendaftaran')->first();
        $daftarUlangBillType = BillType::where('name', 'Daftar Ulang')->first();
        // Pastikan BillType ini ada di database Anda atau buat jika belum.

        // Contoh mendapatkan grade_id jika 'grade_id' di bill_groups adalah FK ke grade_levels
        $grade10 = GradeLevel::where('name', 'Kelas 10')->first(); // Sesuaikan nama grade di DB Anda
        $grade11 = GradeLevel::where('name', 'Kelas 11')->first(); // Sesuaikan nama grade di DB Anda
        $grade12 = GradeLevel::where('name', 'Kelas 12')->first(); // Sesuaikan nama grade di DB Anda


        if (!$smp) { throw new \Exception("Sekolah 'SMP Al Bahjah' tidak ditemukan."); }
        if (!$sma) { throw new \Exception("Sekolah 'SMA Al Bahjah' tidak ditemukan."); }
        if (!$academicYear2024_2025) { throw new \Exception("Tahun Ajaran '2024-2025' tidak ditemukan."); }
        if (!$academicYear2025_2026) { throw new \Exception("Tahun Ajaran '2025-2026' tidak ditemukan."); }
        if (!$sppBillType) { throw new \Exception("BillType 'SPP Bulanan' tidak ditemukan. Harap jalankan BillTypeSeeder terlebih dahulu."); }
        if (!$formulirPendaftaranBillType) { throw new \Exception("BillType 'Formulir Pendaftaran' tidak ditemukan. Harap jalankan BillTypeSeeder terlebih dahulu."); }
        if (!$daftarUlangBillType) { throw new \Exception("BillType 'Daftar Ulang' tidak ditemukan. Harap jalankan BillTypeSeeder terlebih dahulu."); }


        DB::table('bill_groups')->insert([
            [
                'type' => 'periode',
                'name' => 'SPP Angkatan 2022',
                'level_id' => null, // Sesuaikan jika Anda ingin mengaitkan dengan level tertentu
                'grade_id' => optional($grade10)->id, // Contoh: Kelas 10
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $sppBillType->id, // Menggunakan ID dari BillType
                'gender' => 'male',
                'tagihan_count' => 12,
                'amount_per_tagihan' => 1525000,
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'description' => 'SPP bulanan untuk angkatan 2022.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'periode',
                'name' => 'SPP Angkatan 2023',
                'level_id' => null, // Sesuaikan
                'grade_id' => optional($grade11)->id, // Contoh: Kelas 11
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $sppBillType->id,
                'gender' => 'male',
                'tagihan_count' => 12,
                'amount_per_tagihan' => 1625000,
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'description' => 'SPP bulanan untuk angkatan 2023.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'Formulir Pendaftaran Siswa SMP',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $formulirPendaftaranBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1, // Biasanya 1 untuk event
                'amount_per_tagihan' => 400000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Biaya formulir pendaftaran siswa SMP.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'DU Santri Baru SMPIQu 2024',
                'level_id' => null,
                'grade_id' => optional($grade10)->id, // Contoh: Kelas 10 (jika DU untuk kelas spesifik)
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 16700000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar Ulang santri baru SMPIQu tahun 2024.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'Daftar Ulang Kenaikan Kelas 2024',
                'level_id' => null, // Asumsi ini umum untuk semua grade di sekolah tersebut
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id, // Tahun ajaran ini
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 4020000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar ulang untuk kenaikan kelas tahun ajaran 2024/2025.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'periode',
                'name' => 'SPP Angkatan 2024',
                'level_id' => null,
                'grade_id' => optional($grade12)->id, // Contoh: Kelas 12
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $sppBillType->id,
                'gender' => 'male',
                'tagihan_count' => 12,
                'amount_per_tagihan' => 1700000,
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'description' => 'SPP bulanan untuk angkatan 2024.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'Formulir Pendaftaran Siswa SMA',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $sma->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $formulirPendaftaranBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 400000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Biaya formulir pendaftaran siswa SMA.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'DU Santri Baru SMAIQu',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $sma->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 17000000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar Ulang santri baru SMAIQu.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'DU Santri Baru - SMPIQu 2025',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2025_2026->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => null, // Semua gender
                'tagihan_count' => 1,
                'amount_per_tagihan' => 17000000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar Ulang santri baru SMPIQu untuk tahun ajaran 2025-2026.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'periode',
                'name' => 'SPP Angkatan 2025',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2025_2026->id,
                'bill_type_id' => $sppBillType->id,
                'gender' => null, // Semua gender
                'tagihan_count' => 12,
                'amount_per_tagihan' => 1850000,
                'start_date' => '2025-07-01',
                'end_date' => '2026-06-30',
                'description' => 'SPP bulanan untuk angkatan 2025.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'DU Kenaikan Kelas Tahun 2025 - Angkatan 2024',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2025_2026->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 4500000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar ulang kenaikan kelas tahun 2025 untuk angkatan 2024.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'event',
                'name' => 'DU Kenaikan Kelas Tahun 2025 - Angkatan 2023',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2025_2026->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => 'male',
                'tagihan_count' => 1,
                'amount_per_tagihan' => 4020000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar ulang kenaikan kelas tahun 2025 untuk angkatan 2023.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}