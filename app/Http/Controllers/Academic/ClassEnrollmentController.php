<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassEnrollment;
use App\Models\Student;
use App\Models\Level;
use App\Models\GradeLevel;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class ClassEnrollmentController extends Controller
{
public function index()
{
    // Hitung total siswa
    $totalStudents = \App\Models\Student::count();

    // Ambil data siswa yang sudah terdaftar
    $enrolledStudentIds = \App\Models\ClassEnrollment::pluck('student_id')->unique();
    $enrolledCount = $enrolledStudentIds->count();
    $notEnrolledCount = $totalStudents - $enrolledCount;

    // Query utama dengan relasi
    $enrollmentQuery = \App\Models\ClassEnrollment::with([
        'level',        // Jenjang
        'classroom',    // Ruang kelas
        'academicYear',
        'semester'
    ]);

    // Filter dinamis
    if (request('academic_year_id')) {
        $enrollmentQuery->where('academic_year_id', request('academic_year_id'));
    }

    if (request('semester_id')) {
        $enrollmentQuery->where('semester_id', request('semester_id'));
    }

    if (request('level_id')) {
        $enrollmentQuery->where('level_id', request('level_id'));
    }

    // Eksekusi query
    $enrollmentCollection = $enrollmentQuery->get();

    // Grouping berdasarkan level, ruang kelas, tahun ajaran, dan semester
    $enrollments = $enrollmentCollection->groupBy(function ($e) {
        return implode('-', [
            $e->level_id,
            $e->classroom_id,
            $e->academic_year_id,
            $e->semester_id,
        ]);
    });

    // Data filter dropdown
    $academicYears = \App\Models\AcademicYear::all();
    $semesters = \App\Models\Semester::all();
    $levels = \App\Models\Level::all(); // Jenjang

    return view('academics.class_enrollments.index', compact(
        'enrollments',
        'academicYears',
        'semesters',
        'totalStudents',
        'enrolledCount',
        'notEnrolledCount',
        'levels'
    ));
}

    public function create()
    {
        // Ambil semua ID siswa yang sudah ditempatkan
        $enrolledStudentIds = ClassEnrollment::pluck('student_id')->toArray();

        // Ambil hanya siswa yang belum ditempatkan
        $students = Student::whereNotIn('id', $enrolledStudentIds)->get();

        $levels = Level::all();              // Jenjang
        $gradeLevels = GradeLevel::all();    // Kelas
        $classrooms = Classroom::all();      // Ruang kelas
        $academicYears = AcademicYear::all();
        $semesters = Semester::all();

        return view('academics.class_enrollments.create', compact(
            'students',
            'levels',
            'gradeLevels',
            'classrooms',
            'academicYears',
            'semesters'
        ));
    }


    public function store(Request $request)
{
    $request->validate([
        'student_ids' => 'required|array|min:1',
        'student_ids.*' => 'exists:students,id',
        'level_id' => 'required|exists:levels,id',
        'grade_level_id' => 'required|exists:grade_levels,id',
        'classroom_id' => 'required|exists:classrooms,id',
        'academic_year_id' => 'required|exists:academic_years,id',
        'semester_id' => 'nullable|exists:semesters,id',
    ]);

    foreach ($request->student_ids as $studentId) {
        ClassEnrollment::create([
            'student_id' => $studentId,
            'level_id' => $request->level_id,
            'grade_level_id' => $request->grade_level_id,
            'classroom_id' => $request->classroom_id,
            'academic_year_id' => $request->academic_year_id,
            'semester_id' => $request->semester_id,
            'school_id' => auth()->user()->school_id ?? 1,
        ]);
    }

    return redirect()->route('academic.class-enrollments.index')
        ->with('success', 'Penempatan kelas berhasil untuk ' . count($request->student_ids) . ' siswa.');
}


    public function show(string $id)
    {
        $enrollment = ClassEnrollment::with(['student', 'gradeLevel', 'classroom', 'academicYear', 'semester'])->findOrFail($id);

        return view('academics.class_enrollments.show', compact('enrollment'));
    }

    public function edit(string $id)
{
    $enrollment = ClassEnrollment::findOrFail($id);
    $students = Student::all();
    $levels = Level::all();               // Jenjang
    $gradeLevels = GradeLevel::all();     // Kelas
    $classrooms = Classroom::all();       // Ruang kelas
    $academicYears = AcademicYear::all();
    $semesters = Semester::all();

    return view('academics.class_enrollments.edit', compact(
        'enrollment',
        'students',
        'levels',
        'gradeLevels',
        'classrooms',
        'academicYears',
        'semesters'
    ));
}

    public function update(Request $request, string $id)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'level_id' => 'required|exists:levels,id',
        'grade_level_id' => 'required|exists:grade_levels,id',
        'classroom_id' => 'required|exists:classrooms,id',
        'academic_year_id' => 'required|exists:academic_years,id',
        'semester_id' => 'nullable|exists:semesters,id',
    ]);

    $enrollment = ClassEnrollment::findOrFail($id);
    $enrollment->update($request->only([
        'student_id', 'level_id', 'grade_level_id', 'classroom_id', 'academic_year_id', 'semester_id'
    ]));

    return redirect()->route('academic.class-enrollments.index')->with('success', 'Data penempatan kelas siswa diperbarui.');
}


    public function destroy(string $id)
    {
        $enrollment = ClassEnrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('academic.class-enrollments.index')->with('success', 'Data penempatan kelas siswa dihapus.');
    }

public function show_group($level_id, $grade_level_id, $classroom_id, $academic_year_id, $semester_id)
{
    $data = \App\Models\ClassEnrollment::with(['student', 'level', 'gradeLevel', 'classroom', 'academicYear', 'semester'])
        ->where('level_id', $level_id)
        ->where('grade_level_id', $grade_level_id)
        ->where('classroom_id', $classroom_id)
        ->where('academic_year_id', $academic_year_id)
        ->where('semester_id', $semester_id)
        ->get();

    return view('academics.class_enrollments.show_group', compact('data'));
}



}
