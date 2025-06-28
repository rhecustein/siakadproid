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
            ['year' => '2024/2025', 'is_active' => true], // yang aktif
        ];

        foreach ($years as $data) {
            AcademicYear::create([
                'year' => $data['year'],
                'is_active' => $data['is_active'],
            ]);
        }
    }
}
