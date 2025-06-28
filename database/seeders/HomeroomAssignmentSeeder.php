<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeroomAssignment;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\AcademicYear;

class HomeroomAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        $classroom = Classroom::first();
        $teacher = Teacher::where('position', 'Wali Kelas')->first();

        if ($teacher && $classroom && $academicYear) {
            HomeroomAssignment::create([
                'teacher_id' => $teacher->id,
                'classroom_id' => $classroom->id,
                'academic_year_id' => $academicYear->id,
                'assigned_at' => now(),
                'note' => 'Penugasan wali kelas pertama',
                'is_active' => true,
            ]);
        }
    }
}
