<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleNames = [
            'admin',
            'guru',
            'orang_tua',
            'siswa',
            'employee',
        ];

        foreach ($roleNames as $roleName) {
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                continue;
            }

            User::create([
                'uuid' => Str::uuid(),
                'tenant_id' => 1,
                'name' => ucfirst($roleName),
                'username' => $roleName,
                'email' => $roleName . '@example.com',
                'phone_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => $role->id,
                'detail_id' => null,
                'avatar' => null,
                'fingerprint' => null,
                'village_id' => null,
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
