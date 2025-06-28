<?php

namespace App\Http\Controllers\Academic;;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Level;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Curriculum;

class ClassroomScheduleController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');
        $level = $request->input('level');

        $classrooms = Classroom::with(['level', 'academicYear', 'curriculum'])
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
            ->when($level, fn($q) => $q->where('level_id', $level))
            ->orderBy('order')
            ->paginate(10)
            ->withQueryString();

        $schedules = Schedule::with(['teacher', 'school', 'subject', 'classroom', 'room', 'lessonTime'])->get();

        $levels = Level::all();

        $counts = [
            'classrooms' => Classroom::count(),
            'schedules'  => Schedule::count(),
            'levels'     => Level::count(),
            'subjects'   => Subject::count(),
        ];

        return view('admin.academics.classrooms-schedule.index', compact(
            'classrooms', 'schedules', 'counts', 'search', 'level', 'levels'
        ));
    }


    public function create()
    {
        $levels = Level::all();
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();

        return view('admin.academics.classrooms-schedule.form', [
            'formAction' => route('academic.classrooms-schedule.store'),
            'isEdit' => false,
            'classroom' => new Classroom(),
            'levels' => $levels,
            'academicYears' => $academicYears,
            'curriculums' => $curriculums,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'room' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Classroom::create($validated);

        return redirect()->route('academic.classrooms-schedule.index')
                         ->with('success', 'Classroom created successfully.');
    }

    public function edit(Classroom $classroom_schedule)
    {
        $levels = Level::all();
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();

        return view('admin.academics.classrooms-schedule.edit', [
            'formAction' => route('academic.classrooms-schedule.update', $classroom_schedule),
            'isEdit' => true,
            'classroom' => $classroom_schedule,
            'levels' => $levels,
            'academicYears' => $academicYears,
            'curriculums' => $curriculums,
        ]);
    }

    public function update(Request $request, Classroom $classroom_schedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'room' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $classroom_schedule->update($validated);

        return redirect()->route('academic.classrooms-schedule.index')
                         ->with('success', 'Classroom updated successfully.');
    }

    public function destroy(Classroom $classroom_schedule)
    {
        $classroom_schedule->delete();

        return redirect()->route('academic.classrooms-schedule.index')
                         ->with('success', 'Classroom deleted successfully.');
    }

    public function show(Classroom $classroom_schedule)
    {
        $classroom_schedule->load(['level', 'academicYear', 'curriculum']);

        return view('admin.academics.classrooms-schedule.show', [
            'classroom' => $classroom_schedule
        ]);
    }
}
