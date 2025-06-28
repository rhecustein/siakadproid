<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamType;

class ExamTypeSeeder extends Seeder
{
    public function run()
    {
        ExamType::insert([
            ['name' => 'Ujian Tengah Semester', 'description' => 'UTS'],
            ['name' => 'Ujian Akhir Semester', 'description' => 'UAS'],
        ]);
    }
}
