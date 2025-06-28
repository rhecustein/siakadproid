<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryCondition;

class InventoryConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            [
                'name' => 'Good',
                'description' => 'Barang dalam kondisi baik dan dapat digunakan dengan optimal.',
            ],
            [
                'name' => 'Minor Damage',
                'description' => 'Barang mengalami kerusakan ringan namun masih bisa digunakan.',
            ],
            [
                'name' => 'Major Damage',
                'description' => 'Barang rusak berat dan memerlukan perbaikan besar atau tidak dapat digunakan.',
            ],
            [
                'name' => 'Missing',
                'description' => 'Barang hilang dan tidak ditemukan di lokasi seharusnya.',
            ],
            [
                'name' => 'Under Repair',
                'description' => 'Barang sedang dalam proses perbaikan dan tidak dapat digunakan sementara.',
            ],
        ];

        foreach ($conditions as $cond) {
            InventoryCondition::firstOrCreate(['name' => $cond['name']], $cond);
        }
    }
}
