<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlEntity;

class GlEntitySeeder extends Seeder
{
    public function run(): void
    {
        GlEntity::insert([
            ['entity_type' => 'student', 'entity_id' => 1, 'label' => 'Ahmad Santri'],
            ['entity_type' => 'parent', 'entity_id' => 2, 'label' => 'Ibu Ahmad'],
            ['entity_type' => 'employee', 'entity_id' => 3, 'label' => 'Ustadz Yusuf'],
        ]);
    }
}
