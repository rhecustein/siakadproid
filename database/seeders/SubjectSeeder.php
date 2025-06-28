<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Mathematics',
                'code' => 'MATH101',
                'type' => 'wajib',
                'is_religious' => false,
                'group' => 'General',
                'kkm' => 75,
                'description' => 'Basic and advanced mathematical concepts.',
            ],
            [
                'name' => 'English',
                'code' => 'ENG101',
                'type' => 'wajib',
                'is_religious' => false,
                'group' => 'General',
                'kkm' => 75,
                'description' => 'English language and literature.',
            ],
            [
                'name' => 'Islamic Jurisprudence (Fiqh)',
                'code' => 'FIQH101',
                'type' => 'wajib',
                'is_religious' => true,
                'group' => 'Religion',
                'kkm' => 70,
                'description' => 'Study of Islamic laws and practices.',
            ],
            [
                'name' => 'Quran Memorization (Tahfidz)',
                'code' => 'TAHFIDZ101',
                'type' => 'pilihan',
                'is_religious' => true,
                'group' => 'Religion',
                'kkm' => 70,
                'description' => 'Memorizing selected surahs from the Quran.',
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'uuid' => Str::uuid(),
                'name' => $subject['name'],
                'slug' => Str::slug($subject['name']),
                'code' => $subject['code'],
                'type' => $subject['type'],
                'is_religious' => $subject['is_religious'],
                'group' => $subject['group'],
                'kkm' => $subject['kkm'],
                'description' => $subject['description'],
                'is_active' => true,
                'order' => 0,
                'curriculum_id' => null,
                'level_id' => null,
            ]);
        }
    }
}
