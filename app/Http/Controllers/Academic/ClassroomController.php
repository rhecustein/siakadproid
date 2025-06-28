<?php

namespace App\Http\Controllers\Academic;;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\GradeLevel;
use App\Models\AcademicYear;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::with(['level', 'academicYear', 'curriculum'])->orderBy('order');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $classrooms = $query->paginate(10)->withQueryString();
        $levels = Level::all();
        $academicYears = AcademicYear::all();

        return view('admin.masters.classrooms.index', compact('classrooms', 'levels', 'academicYears'));
    }

    public function create()
    {
        $levels = Level::all();
        $gradeLevels = GradeLevel::all(); // ← Tambahan
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();

        return view('admin.masters.classrooms.create', compact('levels', 'gradeLevels', 'academicYears', 'curriculums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:classrooms,name',
            'alias' => 'nullable|string|max:50',
            'room' => 'nullable|string|max:50',
            'level_id' => 'nullable|exists:levels,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['uuid'] = (string) Str::uuid();
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Classroom::create($validated);

        return redirect()->route('academic.classrooms.index')->with('success', 'Classroom berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $levels = Level::all();
        $gradeLevels = GradeLevel::all(); // ← Tambahan
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();

        return view('admin.masters.classrooms.edit', compact('classroom', 'levels', 'gradeLevels', 'academicYears', 'curriculums'));
    }

    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:classrooms,name,' . $classroom->id,
            'alias' => 'nullable|string|max:50',
            'room' => 'nullable|string|max:50',
            'level_id' => 'nullable|exists:levels,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        $classroom->update($validated);

        return redirect()->route('academic.classrooms.index')->with('success', 'Classroom berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('academic.classrooms.index')->with('success', 'Classroom berhasil dihapus.');
    }
}
