<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\SchoolYear;
use App\Models\PromotionLog;
use Illuminate\Http\Request;

class GraduationController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $schoolYears = SchoolYear::all();

        $students = Student::with('classroom')
            ->when($request->school_year_id, fn($q) =>
                $q->whereHas('enrollments', fn($e) =>
                    $e->where('school_year_id', $request->school_year_id)))
            ->when($request->classroom_id, fn($q) =>
                $q->where('classroom_id', $request->classroom_id))
            ->get();

        return view('academics.graduations.index', compact('students', 'classrooms', 'schoolYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
        ]);

        foreach ($request->student_ids as $studentId) {
            $student = Student::find($studentId);
            if (!$student) continue;

            PromotionLog::create([
                'student_id' => $student->id,
                'from_classroom_id' => $student->classroom_id,
                'to_classroom_id' => null,
                'is_graduated' => true,
                'processed_at' => now(),
            ]);

            $student->update([
                'classroom_id' => null // keluarkan dari kelas
            ]);
        }

        return redirect()->route('academic.graduations.index')
            ->with('success', 'Siswa berhasil ditandai sebagai lulus.');
    }
}
