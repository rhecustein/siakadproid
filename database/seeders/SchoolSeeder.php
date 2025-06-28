<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use Illuminate\Support\Str;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'branch_id' => 1, // Pusat Cirebon
                'name' => 'SD Al-Bahjah',
                'slug' => 'sd-albahjah',
                'npsn' => '12345678',
                'type' => 'formal',
                'address' => 'Jln. Pangeran Cakrabuana No.179, Cirebon',
                'phone' => '0231-123456',
                'email' => 'sd@albahjah.sch.id',
            ],
            [
                'branch_id' => 2, // Cabang Bandung
                'name' => 'Pondok Al-Bahjah Bandung',
                'slug' => 'pondok-albahjah-bandung',
                'npsn' => null,
                'type' => 'pondok',
                'address' => 'Jl. Cibiru Hilir No.88, Bandung',
                'phone' => '022-987654',
                'email' => 'bandung@albahjah.sch.id',
            ],
            [
                'branch_id' => 3, // Cabang Jakarta
                'name' => 'SMP Al-Bahjah Jakarta',
                'slug' => 'smp-albahjah-jakarta',
                'npsn' => '87654321',
                'type' => 'formal',
                'address' => 'Jl. Raya Kalibata Timur No.10, Jakarta',
                'phone' => '021-123789',
                'email' => 'smp.jakarta@albahjah.sch.id',
            ],
        ];

        foreach ($schools as $school) {
            School::create([
                'uuid' => Str::uuid(),
                'branch_id' => $school['branch_id'],
                'name' => $school['name'],
                'slug' => $school['slug'],
                'npsn' => $school['npsn'],
                'type' => $school['type'],
                'address' => $school['address'],
                'phone' => $school['phone'],
                'email' => $school['email'],
            ]);
        }
    }
}
