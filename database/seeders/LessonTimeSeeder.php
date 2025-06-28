<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonTime;
use Carbon\Carbon;

class LessonTimeSeeder extends Seeder
{
    public function run(): void
    {
        $startBase = Carbon::createFromTime(8, 30, 0); // Mulai jam 08:30
        $endLimit = Carbon::createFromTime(16, 0, 0);   // Batas akhir 16:00
        $durasiPerSesi = 60; // menit

        $academicYearIds = [1, 2, 3];
        $schoolId = 1;

        foreach ($academicYearIds as $academicYearId) {
            $startTime = $startBase->copy();
            $order = 1;

            while ($startTime->lessThan($endLimit)) {
                $endTime = $startTime->copy()->addMinutes($durasiPerSesi);

                if ($endTime->greaterThan($endLimit)) break;

                LessonTime::create([
                    'order'            => $order++,
                    'start_time'       => $startTime->format('H:i:s'),
                    'end_time'         => $endTime->format('H:i:s'),
                    'is_break'         => false,
                    'school_id'        => $schoolId,
                    'academic_year_id' => $academicYearId,
                ]);

                $startTime = $endTime->copy(); // sesi berikutnya
            }
        }
    }
}
