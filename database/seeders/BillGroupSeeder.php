<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\BillType;
use App\Models\GradeLevel;

class BillGroupSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil Data Master
        $smp = School::where('name', 'SMP Al Bahjah')->firstOrFail();
        $sma = School::where('name', 'SMA Al Bahjah')->firstOrFail();

        $academicYear2024_2025 = AcademicYear::where('year', '2024/2025')->firstOrFail();
        $academicYear2025_2026 = AcademicYear::where('year', '2025/2026')->firstOrFail();

        $sppBillType = BillType::where('name', 'SPP Bulanan')->firstOrFail();
        $formulirPendaftaranBillType = BillType::where('name', 'Formulir Pendaftaran')->firstOrFail();
        $daftarUlangBillType = BillType::where('name', 'Daftar Ulang')->firstOrFail();

        $grade10 = GradeLevel::where('name', 'Kelas 10')->first();
        // Jika grade10 tidak wajib, tidak perlu pakai firstOrFail()

        // Insert ke bill_groups
        DB::table('bill_groups')->insert([
            [
                'type' => 'periode',
                'name' => 'SPP Angkatan 2022',
                'level_id' => null,
                'grade_id' => optional($grade10)->id,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2024_2025->id,
                'bill_type_id' => $sppBillType->id,
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
                'type' => 'event',
                'name' => 'DU Santri Baru - SMPIQu 2025',
                'level_id' => null,
                'grade_id' => null,
                'school_id' => $smp->id,
                'academic_year_id' => $academicYear2025_2026->id,
                'bill_type_id' => $daftarUlangBillType->id,
                'gender' => null,
                'tagihan_count' => 1,
                'amount_per_tagihan' => 17000000,
                'start_date' => null,
                'end_date' => null,
                'description' => 'Daftar Ulang santri baru SMPIQu untuk tahun ajaran 2025-2026.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
