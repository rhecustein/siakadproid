<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Pusat Al Bahjah Cirebon',
                'slug' => 'al-bahjah-cirebon',
                'address' => 'Jln. Pangeran Cakrabuana No. 179, Cirebon',
                'center_id' => null, // pusat
            ],
            [
                'name' => 'Al Bahjah Cabang Bandung',
                'slug' => 'al-bahjah-bandung',
                'address' => 'Jl. Cibiru Hilir No.88, Bandung',
                'center_id' => 1, // mengacu ke pusat
            ],
            [
                'name' => 'Al Bahjah Cabang Jakarta',
                'slug' => 'al-bahjah-jakarta',
                'address' => 'Jl. Raya Kalibata Timur No.10, Jakarta',
                'center_id' => 1,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create([
                'uuid' => Str::uuid(),
                'center_id' => $branch['center_id'],
                'name' => $branch['name'],
                'slug' => $branch['slug'],
                'address' => $branch['address'],
            ]);
        }
    }
}
