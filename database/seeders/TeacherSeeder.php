<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use App\Models\School;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $role = Role::where('name', 'guru')->first();

        if (!$school || !$role) {
            throw new \Exception('Seeder gagal: School atau Role "guru" belum tersedia.');
        }

        $teachers = [
            [
                'name' => 'Ustadz Ahmad',
                'nip' => '1980123456',
                'position' => 'Wali Kelas',
                'employment_status' => 'Tetap',
                'type' => 'Formal',
                'email' => 'ahmad@albahjah.sch.id',
                'gender' => 'L',
            ],
            [
                'name' => 'Ustadzah Siti',
                'nip' => '1980987654',
                'position' => 'Guru Tahfidz',
                'employment_status' => 'Kontrak',
                'type' => 'Pondok',
                'email' => 'siti@albahjah.sch.id',
                'gender' => 'P',
            ],
            [
                'name' => 'Ustadz Budi',
                'nip' => '1980777711',
                'position' => 'Pembina Asrama',
                'employment_status' => 'Honorer',
                'type' => 'Pesantren',
                'email' => 'budi@albahjah.sch.id',
                'gender' => 'L',
            ],
        ];

        foreach ($teachers as $data) {
            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $data['name'],
                'username' => strtolower(Str::slug($data['name'])),
                'email' => $data['email'],
                'phone_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => $role->id,
                'detail_id' => null, // bisa diisi nanti dengan teacher.id jika relasi dua arah
                'avatar' => null,
                'fingerprint' => null,
                'village_id' => null,
                'remember_token' => Str::random(10),
            ]);

            $teacher = Teacher::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'school_id' => $school->id,
                'nip' => $data['nip'],
                'name' => $data['name'],
                'position' => $data['position'],
                'employment_status' => $data['employment_status'],
                'type' => $data['type'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'is_active' => true,
            ]);

            // Optional: update user.detail_id pointing to teacher.id if needed
            // $user->update(['detail_id' => $teacher->id]);
        }
    }
}
