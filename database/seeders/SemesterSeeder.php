<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\SchoolYear;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah sudah ada tahun ajaran, jika tidak buat satu
        $schoolYear = SchoolYear::first();

        if (!$schoolYear) {
            $schoolYear = SchoolYear::create([
                'uuid' => Str::uuid(),
                'name' => '2024/2025',
                'start_year' => 2024,
                'end_year' => 2025,
                'is_active' => true,
            ]);
        }

        // Isi 2 semester: Ganjil & Genap
        $semesters = [
            [
                'uuid' => Str::uuid(),
                'school_year_id' => $schoolYear->id,
                'name' => 'Semester Ganjil',
                'type' => 'ganjil',
                'is_active' => true,
            ],
            [
                'uuid' => Str::uuid(),
                'school_year_id' => $schoolYear->id,
                'name' => 'Semester Genap',
                'type' => 'genap',
                'is_active' => false,
            ],
        ];

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }

        $this->command->info('Seeder untuk tahun ajaran dan semester berhasil dijalankan.');
    }
}
