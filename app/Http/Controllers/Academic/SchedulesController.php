<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Room;
use App\Models\LessonTime;
use App\Models\Classroom;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchedulesController extends Controller
{
    public function index()
{
    $schedules = Schedule::with(['teacher', 'subject', 'room', 'lessonTime', 'classroom'])
        ->orderBy('day')
        ->orderBy('lesson_time_id')
        ->get();

    return view('admin.masters.schedules.index', [
        'schedules' => $schedules,
        'schools' => \App\Models\School::all(),
        'classrooms' => \App\Models\Classroom::all(),
        'teachers' => \App\Models\Teacher::all(),
        'subjects' => \App\Models\Subject::all(),
        'rooms' => \App\Models\Room::all(),
        'lessonTimes' => \App\Models\LessonTime::orderBy('order')->get(),
        'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'],
    ]);
}


    public function create()
    {
        return view('admin.masters.schedules.create', [
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'rooms' => Room::all(),
            'lessonTimes' => LessonTime::orderBy('order')->get(),
            'classrooms' => Classroom::all(),
            'schools' => School::all(),
            'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'room_id' => 'nullable|exists:rooms,id',
            'lesson_time_id' => 'required|exists:lesson_times,id',
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
        ]);

        Schedule::create(array_merge(
            $request->only([
                'school_id', 'teacher_id', 'subject_id', 'classroom_id', 'room_id', 'lesson_time_id', 'day'
            ]),
            ['uuid' => Str::uuid()]
        ));

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.masters.schedules.edit', [
            'schedule' => $schedule,
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'rooms' => Room::all(),
            'lessonTimes' => LessonTime::orderBy('order')->get(),
            'classrooms' => Classroom::all(),
            'schools' => School::all(),
            'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'],
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'room_id' => 'nullable|exists:rooms,id',
            'lesson_time_id' => 'required|exists:lesson_times,id',
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
        ]);

        $schedule->update($request->only([
            'school_id', 'teacher_id', 'subject_id', 'classroom_id',
            'room_id', 'lesson_time_id', 'day'
        ]));

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
