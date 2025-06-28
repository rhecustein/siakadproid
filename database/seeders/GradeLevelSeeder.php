<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    public function run()
    {
        DB::table('grade_levels')->insert([
            [
                'level_id' => 1,
                'grade' => 7,
                'label' => 'SMP 7',
                'description' => 'Kelas 7 tingkat SMP',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 1,
                'grade' => 8,
                'label' => 'SMP 8',
                'description' => 'Kelas 8 tingkat SMP',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 1,
                'grade' => 9,
                'label' => 'SMP 9',
                'description' => 'Kelas 9 tingkat SMP',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
