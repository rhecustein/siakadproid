<?php

namespace Database\Seeders;

use App\Models\CanteenProductCategory;
use Illuminate\Database\Seeder;

class CanteenProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan Ringan', 'description' => 'Snack, keripik, dan makanan ringan lainnya'],
            ['name' => 'Minuman', 'description' => 'Air mineral, teh, susu, jus, dll'],
            ['name' => 'Makanan Berat', 'description' => 'Nasi, mie, lauk-pauk, dll'],
            ['name' => 'ATK', 'description' => 'Alat tulis kantor seperti pulpen, pensil, buku'],
            ['name' => 'Lain-lain', 'description' => 'Produk lainnya di luar kategori utama'],
        ];

        foreach ($categories as $category) {
            CanteenProductCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
