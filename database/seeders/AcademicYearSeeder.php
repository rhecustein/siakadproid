<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['year' => '2022/2023', 'is_active' => false],
            ['year' => '2023/2024', 'is_active' => false],
            ['year' => '2024/2025', 'is_active' => true],
            ['year' => '2025/2026', 'is_active' => false],
        ];

        foreach ($years as $data) {
            AcademicYear::updateOrCreate(
                ['year' => $data['year']],
                ['is_active' => $data['is_active']]
            );
        }

        // Pastikan hanya satu tahun ajaran yang aktif
        AcademicYear::where('is_active', true)
            ->where('year', '!=', '2024/2025')
            ->update(['is_active' => false]);
    }
}
