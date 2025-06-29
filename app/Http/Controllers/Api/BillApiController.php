<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\School;
use App\Models\GradeLevel;
use App\Models\Classroom;
use App\Models\ClassroomAssignment;
use App\Models\StudentParent;
use App\Models\Bill;
use App\Models\BillItem;

class BillApiController extends Controller
{
    /**
     * Endpoint untuk memfilter siswa berdasarkan kriteria tertentu
     * untuk keperluan generate tagihan masal di frontend.
     *
     * @param Request $request
     * @return \Illuminate->Http->JsonResponse
     */
    public function filterStudentsForGenerate(Request $request)
    {
        // Mendapatkan ID tahun ajaran aktif saat ini
        $currentAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        $query = Student::query()
            ->with([
                'school',
                'grade', // grade_level
                'currentClassroomAssignment.classroom', // Load classroom dari assignment
                'currentClassroomAssignment.academicYear' // Load academicYear dari assignment
            ]);

        // Menerapkan filter berdasarkan request dari frontend
        if ($request->filled('academic_year_id')) {
            $query->whereHas('currentClassroomAssignment', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        } else {
             // Default ke tahun ajaran aktif jika tidak ada filter tahun ajaran yang dipilih
             $query->whereHas('currentClassroomAssignment', function($q) use ($currentAcademicYearId) {
                $q->where('academic_year_id', $currentAcademicYearId);
            });
        }
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }
        if ($request->filled('grade_level_id')) {
            $query->whereHas('currentClassroomAssignment.classroom', function($q) use ($request) {
                $q->where('grade_id', $request->grade_level_id);
            });
        }
        if ($request->filled('student_status')) {
            $query->where('student_status', $request->student_status);
        }
        if ($request->filled('search')) {
            $search = $request->input('search'); // Ambil dari input() karena bukan query 'q'
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $students = $query->get(); // Menggunakan get() karena frontend akan melakukan paginasi/filtering visual

        // Format data untuk frontend, termasuk relasi yang di-eager load
        $formattedStudents = $students->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'nisn' => $student->nisn,
                'nis' => $student->nis,
                'current_classroom' => [
                    'name' => optional(optional($student->currentClassroomAssignment)->classroom)->name,
                ],
                'grade' => [
                    'name' => optional($student->grade)->name,
                ],
                'school' => [
                    'name' => optional($student->school)->name,
                ],
                'student_status' => $student->student_status,
                'admission_date' => optional($student->admission_date)->format('Y-m-d'),
                'date_of_birth' => optional($student->date_of_birth)->format('Y-m-d'),
                'place_of_birth' => $student->place_of_birth,
                'address' => $student->address,
                'phone_number' => $student->phone_number,
                'notes' => $student->notes,
                // Tambahkan data lain yang dibutuhkan di student-checkbox label atau modal detail siswa
            ];
        });

        return response()->json(['students' => $formattedStudents]);
    }

    // Tambahkan API endpoint lain yang relevan di sini jika ada di masa depan
    // Misalnya, untuk mengambil detail tagihan tertentu, atau detail pembayaran.
}