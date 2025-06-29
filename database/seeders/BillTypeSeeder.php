<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\BillType;

class BillTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'SPP Bulanan',
                'code' => 'SPP-BULANAN',
                'description' => 'Tagihan bulanan SPP santri.',
                'is_online_payment' => true,
                'is_monthly' => true,
            ],
            [
                'name' => 'Formulir Pendaftaran',
                'code' => 'FORM-PENDAFTARAN',
                'description' => 'Biaya untuk pengambilan formulir pendaftaran.',
                'is_online_payment' => true,
                'is_monthly' => false,
            ],
            [
                'name' => 'Daftar Ulang',
                'code' => 'DAFTAR-ULANG',
                'description' => 'Biaya daftar ulang tahunan.',
                'is_online_payment' => false,
                'is_monthly' => false,
            ],
            [
                'name' => 'Kegiatan Tahunan',
                'code' => 'KEGIATAN-TAHUNAN',
                'description' => 'Biaya untuk kegiatan sekolah selama 1 tahun.',
                'is_online_payment' => false,
                'is_monthly' => false,
            ],
        ];

        foreach ($types as $type) {
            BillType::updateOrCreate(
                ['name' => $type['name']],
                [
                    'uuid' => Str::uuid(),
                    'code' => $type['code'],
                    'description' => $type['description'],
                    'is_online_payment' => $type['is_online_payment'],
                    'is_monthly' => $type['is_monthly'],
                    'is_active' => true,
                ]
            );
        }
    }
}
