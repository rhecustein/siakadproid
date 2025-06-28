<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\BillGroup;
use App\Models\BillType;
use App\Models\GradeLevel;
use App\Models\Level;
use App\Models\School;
use App\Models\Student;
use App\Services\BillService;
use Illuminate\Http\Request;

class BillGenerateController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::all();
        $levels = Level::all();
        $gradeLevels = GradeLevel::all();
        $groups = BillGroup::with('type')->get(); // include relasi bill_type
        $academicYears = AcademicYear::orderBy('year', 'desc')->get();
        $billTypes = BillType::select('id', 'name')->get();

        $students = Student::with(['grade', 'school'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            })
            ->when($request->school_id, fn($q) => $q->where('school_id', $request->school_id))
            ->when($request->level_id, function ($q) use ($request) {
                $gradeIds = GradeLevel::where('level_id', $request->level_id)->pluck('id');
                $q->whereIn('grade_id', $gradeIds);
            })
            ->when($request->grade_id, fn($q) => $q->where('grade_id', $request->grade_id))
            ->paginate(10)
            ->withQueryString();

        return view('admin.finance.bill.generate', compact(
            'schools', 'levels', 'groups', 'students', 'gradeLevels', 'academicYears', 'billTypes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bill_group_id' => 'required|exists:bill_groups,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'bill_type_id' => 'nullable|exists:bill_types,id',
        ]);

        $group = BillGroup::with('type')->findOrFail($request->bill_group_id);
        $students = Student::whereIn('id', $request->student_ids)->get();

        // Prioritaskan input dari form, fallback ke grup
        $billTypeId = $request->bill_type_id ?? $group->bill_type_id;

        if (!$billTypeId) {
            return back()->withInput()->with('error', 'Jenis tagihan tidak tersedia. Silakan pilih secara manual atau perbaiki grup.');
        }

        $count = BillService::generateForStudents($group, $students, [
            'bill_type_id' => $billTypeId,
        ]);

        return redirect()->route('finance.bills.index')->with('success', "$count tagihan berhasil dibuat.");
    }
}
