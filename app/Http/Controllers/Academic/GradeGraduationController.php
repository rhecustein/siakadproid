<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Graduation;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeGraduationController extends Controller
{
    public function index(Request $request)
    {
        $graduations = Graduation::with('student')
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                return $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('certificate_number', 'like', "%$search%");
            })
            ->orderBy('graduation_date', 'desc')
            ->paginate(10);

        return view('academics.grade_graduations.index', compact('graduations'));
    }

    public function create()
    {
        $students = Student::doesntHave('graduation')->orderBy('name')->get();
        return view('academics.grade_graduations.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id|unique:graduations,student_id',
            'graduation_date' => 'required|date',
            'certificate_number' => 'nullable|string|max:50|unique:graduations,certificate_number',
            'notes' => 'nullable|string|max:500',
        ]);

        Graduation::create($request->all());

        return redirect()->route('grade-graduations.index')
            ->with('success', 'Data kelulusan berhasil ditambahkan');
    }

    public function show(Graduation $grade_graduation)
    {
        return view('academics.grade_graduations.show', compact('grade_graduation'));
    }

    public function edit(Graduation $grade_graduation)
    {
        $students = Student::orderBy('name')->get();
        return view('academics.grade_graduations.edit', compact('grade_graduation', 'students'));
    }

    public function update(Request $request, Graduation $grade_graduation)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id|unique:graduations,student_id,' . $grade_graduation->id,
            'graduation_date' => 'required|date',
            'certificate_number' => 'nullable|string|max:50|unique:graduations,certificate_number,' . $grade_graduation->id,
            'notes' => 'nullable|string|max:500',
        ]);

        $grade_graduation->update($request->all());

        return redirect()->route('grade-graduations.index')
            ->with('success', 'Data kelulusan berhasil diperbarui');
    }

    public function destroy(Graduation $grade_graduation)
    {
        $grade_graduation->delete();

        return redirect()->route('grade-graduations.index')
            ->with('success', 'Data kelulusan berhasil dihapus');
    }
}