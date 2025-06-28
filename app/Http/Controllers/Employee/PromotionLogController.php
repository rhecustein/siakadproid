<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\PromotionLog;
use Illuminate\Http\Request;

class PromotionLogController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all();
        return view('admin.academics.promotions.index', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_classroom_id' => 'required|exists:classrooms,id',
            'to_classroom_id' => 'nullable|exists:classrooms,id',
            'student_ids' => 'required|array',
        ]);

        foreach ($request->student_ids as $studentId) {
            $student = Student::find($studentId);
            if (!$student) continue;

            PromotionLog::create([
                'student_id' => $studentId,
                'from_classroom_id' => $request->from_classroom_id,
                'to_classroom_id' => $request->to_classroom_id,
                'is_graduated' => false,
                'processed_at' => now(),
            ]);

            // Update classroom_id siswa langsung
            $student->update([
                'classroom_id' => $request->to_classroom_id
            ]);
        }

        return redirect()->back()->with('success', 'Proses kenaikan kelas berhasil.');
    }
}
