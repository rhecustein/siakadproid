<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $suppliers = [
            [
                'name' => 'CV Boga Bahagia',
                'contact_person' => 'Pak Andi',
                'phone' => '08123456789',
                'email' => 'boga@kantin.co.id',
                'address' => 'Jl. Raya Kulon 88, Cirebon',
                'is_branch_partner' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Toko Berkah Makmur',
                'contact_person' => 'Bu Siti',
                'phone' => '082112233445',
                'email' => 'berkah@toko.id',
                'address' => 'Pasar Sumber Blok B, Cirebon',
                'is_branch_partner' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'PD Air Sejuk',
                'contact_person' => 'Pak Budi',
                'phone' => '085266778899',
                'email' => 'pdair@distributor.id',
                'address' => 'Jl. Gunungjati No. 12',
                'is_branch_partner' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_suppliers')->insert($suppliers);
    }
}
