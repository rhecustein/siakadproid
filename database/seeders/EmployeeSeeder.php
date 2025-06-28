<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {
            Employee::create([
                'user_id' => $i, // pastikan user dengan ID ini ada
                'school_id' => 1, // asumsi ada 3 sekolah, sesuaikan dengan jumlah sebenarnya
                'nip' => 'EMP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => $faker->name,
                'position' => $faker->jobTitle,
                'department' => $faker->randomElement(['Akademik', 'Kesiswaan', 'Administrasi']),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'marital_status' => $faker->randomElement(['Menikah', 'Belum Menikah']),
                'religion' => 'Islam',
                'phone' => $faker->phoneNumber,
                'email' => "pegawai{$i}@example.com",
                'birth_date' => $faker->date(),
                'birth_place' => $faker->city,
                'join_date' => $faker->dateTimeBetween('-5 years', '-1 years'),
                'end_date' => null, // default aktif
                'education_level' => $faker->randomElement(['SMA', 'S1', 'S2']),
                'last_education_institution' => $faker->company . ' University',
                'address' => $faker->address,
                'photo' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
