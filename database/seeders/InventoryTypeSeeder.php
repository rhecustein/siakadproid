<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryType;

class InventoryTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Furniture',
                'is_electronic' => false,
                'economic_life' => 10, // rata-rata meja/kursi
            ],
            [
                'name' => 'Elektronik',
                'is_electronic' => true,
                'economic_life' => 5, // laptop, proyektor, dll
            ],
            [
                'name' => 'Peralatan Kelas',
                'is_electronic' => false,
                'economic_life' => 5, // papan tulis, lemari, rak buku
            ],
            [
                'name' => 'Alat Tulis Kantor',
                'is_electronic' => false,
                'economic_life' => 3,
            ],
            [
                'name' => 'Perangkat Jaringan',
                'is_electronic' => true,
                'economic_life' => 4, // access point, router
            ],
            [
                'name' => 'Audio Visual',
                'is_electronic' => true,
                'economic_life' => 6, // speaker, TV
            ],
            [
                'name' => 'Lainnya',
                'is_electronic' => false,
                'economic_life' => null,
            ],
        ];

        foreach ($types as $type) {
            InventoryType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}
