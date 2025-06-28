<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use Illuminate\Support\Str;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                'name' => 'IPA',
                'slug' => 'ipa',
                'code' => 'SCI',
                'type' => 'academic',
                'level_slug' => 'sma',
                'description' => 'Ilmu Pengetahuan Alam',
            ],
            [
                'name' => 'IPS',
                'slug' => 'ips',
                'code' => 'SOC',
                'type' => 'academic',
                'level_slug' => 'sma',
                'description' => 'Ilmu Pengetahuan Sosial',
            ],
            [
                'name' => 'Tahfidz',
                'slug' => 'tahfidz',
                'code' => 'TFZ',
                'type' => 'religious',
                'level_slug' => 'pondok',
                'description' => 'Program hafalan Al-Qur\'an',
            ],
            [
                'name' => 'TKJ',
                'slug' => 'tkj',
                'code' => 'TKJ',
                'type' => 'vocational',
                'level_slug' => 'sma',
                'description' => 'Teknik Komputer dan Jaringan',
            ],
            [
                'name' => 'DKV',
                'slug' => 'dkv',
                'code' => 'DKV',
                'type' => 'vocational',
                'level_slug' => 'sma',
                'description' => 'Desain Komunikasi Visual',
            ],
        ];

        foreach ($majors as $data) {
            $level = \App\Models\Level::where('slug', $data['level_slug'])->first();

            Major::create([
                'uuid' => Str::uuid(),
                'level_id' => $level?->id,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'code' => $data['code'],
                'description' => $data['description'],
                'type' => $data['type'],
                'is_active' => true,
                'order' => 0,
                'school_id' => null, // tambahkan jika ada relasi dengan sekolah spesifik
            ]);
        }
    }
}