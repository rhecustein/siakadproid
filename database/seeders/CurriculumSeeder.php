<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;
use Illuminate\Support\Str;

class CurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $curriculums = [
            [
                'name' => 'Kurikulum Merdeka',
                'code' => 'K-MDK',
                'description' => 'Kurikulum yang memberikan kebebasan dalam pembelajaran.',
                'start_year' => 2022,
                'end_year' => null,
                'is_active' => true,
                'level_group' => 'sma',
                'applicable_grades' => ['10', '11', '12'],
                'reference_document' => null,
                'regulation_number' => 'SK.2022/01/MERDEKA',
            ],
            [
                'name' => 'Kurikulum 2013',
                'code' => 'K13',
                'description' => 'Kurikulum nasional yang digunakan sebelum Kurikulum Merdeka.',
                'start_year' => 2013,
                'end_year' => 2022,
                'is_active' => false,
                'level_group' => 'smp',
                'applicable_grades' => ['7', '8', '9'],
                'reference_document' => null,
                'regulation_number' => 'SK.2013/08/K13',
            ]
        ];

        foreach ($curriculums as $data) {
            Curriculum::create([
                'uuid' => Str::uuid(),
                'name' => $data['name'],
                'code' => $data['code'],
                'description' => $data['description'],
                'start_year' => $data['start_year'],
                'end_year' => $data['end_year'],
                'is_active' => $data['is_active'],
                'level_group' => $data['level_group'],
                'applicable_grades' => $data['applicable_grades'],
                'reference_document' => $data['reference_document'],
                'regulation_number' => $data['regulation_number'],
            ]);
        }
    }
}
