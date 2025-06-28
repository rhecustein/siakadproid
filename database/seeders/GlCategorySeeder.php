<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlCategory;

class GlCategorySeeder extends Seeder
{
    public function run(): void
    {
        GlCategory::insert([
            ['code' => 'A01', 'name' => 'Aktiva Lancar', 'type' => 'asset'],
            ['code' => 'A02', 'name' => 'Aktiva Tetap', 'type' => 'asset'],
            ['code' => 'L01', 'name' => 'Kewajiban Lancar', 'type' => 'liability'],
            ['code' => 'E01', 'name' => 'Ekuitas Yayasan', 'type' => 'equity'],
            ['code' => 'I01', 'name' => 'Pendapatan Operasional', 'type' => 'income'],
            ['code' => 'I02', 'name' => 'Pendapatan Non-Operasional', 'type' => 'income'],
            ['code' => 'X01', 'name' => 'Beban Operasional', 'type' => 'expense'],
            ['code' => 'X02', 'name' => 'Beban Non-Operasional', 'type' => 'expense'],
        ]);
    }
}
