<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\GradeLevel;
use App\Models\Level;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class UnpaidBillController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::all();
        $levels = Level::all();
        $grades = GradeLevel::all();

        // Ambil siswa yang punya bill status unpaid/partial
        $students = Student::with(['grade', 'school'])
            ->whereHas('bills', function ($q) {
                $q->whereIn('status', ['unpaid', 'partial']);
            })
            ->when($request->school_id, fn($q) => $q->where('school_id', $request->school_id))
            ->when($request->level_id, function ($q) use ($request) {
                $gradeIds = GradeLevel::where('level_id', $request->level_id)->pluck('id');
                $q->whereIn('grade_id', $gradeIds);
            })
            ->when($request->grade_id, fn($q) => $q->where('grade_id', $request->grade_id))
            ->orderBy('name')
            ->get();

        // Hitung total tagihan belum lunas per siswa
        $studentData = $students->map(function ($student) {
            $bills = $student->bills()->whereIn('status', ['unpaid', 'partial'])->with('items')->get();

            $totalOutstanding = $bills->flatMap->items
                ->whereIn('status', ['unpaid', 'partial'])
                ->sum('amount');

            return [
                'student' => $student,
                'total_outstanding' => $totalOutstanding,
                'active_bills' => $bills->count(),
            ];
        });

        return view('admin.finance.bill.unpaid.index', compact(
            'studentData', 'schools', 'levels', 'grades'
        ));
    }
}
