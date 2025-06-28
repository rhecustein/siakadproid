<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\GradeLevel;
use App\Models\LessonTime;
use App\Models\Room;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
  public function index(Request $request)
{
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $schools = School::all();
    $academic_years = AcademicYear::all();
    $gradeLevels = GradeLevel::with(['classrooms' => fn($q) => $q->orderBy('name')])->get();

    $schoolId = $request->school_id ?? $schools->first()?->id;
    $academicYearId = $request->academic_year_id ?? $academic_years->first()?->id;

    $lesson_times = LessonTime::where('school_id', $schoolId)
        ->where('academic_year_id', $academicYearId)
        ->orderBy('order')
        ->get();

    $timetables = Timetable::with(['subject', 'teacher', 'room'])
        ->where('school_id', $schoolId)
        ->where('academic_year_id', $academicYearId)
        ->get();

    $subjects = Subject::orderBy('name')->get();
    $teachers = Teacher::orderBy('name')->get();
    $rooms = Room::orderBy('name')->get();

    // 🔥 Ambil classroom hasil gabungan dari GradeLevel
    $classrooms = $gradeLevels->flatMap(fn ($grade) => $grade->classrooms);

    return view('academics.timetables.index', compact(
        'schools',
        'academic_years',
        'lesson_times',
        'gradeLevels',
        'timetables',
        'days',
        'subjects',
        'teachers',
        'rooms',
        'classrooms',
        'schoolId',
        'academicYearId'
    ));
}



    public function create()
    {
        return view('academics.timetables.create', [
            'classrooms' => Classroom::all(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
            'rooms' => Room::all(),
            'lessonTimes' => LessonTime::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'lesson_time_id' => 'required|exists:lesson_times,id',
            'day' => 'required|string'
        ]);

        Timetable::create($request->all());

        return redirect()->route('timetables.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show($id)
    {
        $timetable = Timetable::with(['classroom', 'subject', 'teacher', 'lesson_time', 'room'])->findOrFail($id);
        return view('academics.timetables.show', compact('timetable'));
    }

    public function edit($id)
    {
        $timetable = Timetable::findOrFail($id);
        return view('academics.timetables.edit', [
            'timetable' => $timetable,
            'classrooms' => Classroom::all(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
            'rooms' => Room::all(),
            'lessonTimes' => LessonTime::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'lesson_time_id' => 'required|exists:lesson_times,id',
            'day' => 'required|string'
        ]);

        $timetable = Timetable::findOrFail($id);
        $timetable->update($request->all());

        return redirect()->route('timetables.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();

        return redirect()->route('timetables.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function availableTimes(Request $request)
    {
        $classroomId = $request->classroom_id;
        $day = $request->day;

        $used = Timetable::where('classroom_id', $classroomId)
            ->where('day', $day)
            ->pluck('lesson_time_id');

        $available = LessonTime::whereNotIn('id', $used)
            ->orderBy('order')
            ->get(['id', 'order', 'start_time', 'end_time']);

        return response()->json($available);
    }

}
