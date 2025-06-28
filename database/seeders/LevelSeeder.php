<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        Level::firstOrCreate(['slug' => 'smp'], [
            'uuid' => Str::uuid(),
            'name' => 'Sekolah Menengah Pertama',
            'type' => 'formal',
            'min_grade' => 7,
            'max_grade' => 9,
            'order' => 1,
            'is_active' => true,
        ]);

        Level::firstOrCreate(['slug' => 'sma'], [
            'uuid' => Str::uuid(),
            'name' => 'Sekolah Menengah Atas',
            'type' => 'formal',
            'min_grade' => 10,
            'max_grade' => 12,
            'order' => 2,
            'is_active' => true,
        ]);

        echo "✅ LevelSeeder selesai.\n";
    }
}
