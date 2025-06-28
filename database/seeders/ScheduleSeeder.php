<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\LessonTime;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\School;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = Classroom::take(3)->get();
        $lessonTimes = LessonTime::take(6)->get(); // hanya jam 1–6
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $rooms = Room::all();
        $school = School::first();

        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

        foreach ($classrooms as $classroom) {
            foreach ($days as $day) {
                foreach ($lessonTimes as $lessonTime) {
                    $subject = $subjects->random();
                    $teacher = $teachers->random();
                    $room = $rooms->random();

                    Schedule::create([
                        'uuid' => Str::uuid(),
                        'school_id' => $school->id,
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'classroom_id' => $classroom->id,
                        'room_id' => $room->id,
                        'lesson_time_id' => $lessonTime->id,
                        'day' => $day,
                    ]);
                }
            }
        }
    }
}
