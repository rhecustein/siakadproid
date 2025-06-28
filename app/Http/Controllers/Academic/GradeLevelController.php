<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\Level;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeLevels = GradeLevel::with('level')->orderBy('level_id')->orderBy('grade')->paginate(15);
        return view('academics.grade_levels.index', compact('gradeLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = Level::where('is_active', true)->orderBy('order')->get();
        return view('academics.grade_levels.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'grade' => 'required|integer|min:1|max:20',
            'label' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        GradeLevel::create($validated);

        return redirect()->route('academic.grade-levels.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeLevel $gradeLevel)
    {
        $levels = Level::where('is_active', true)->orderBy('order')->get();
        return view('academics.grade_levels.edit', compact('gradeLevel', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeLevel $gradeLevel)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'grade' => 'required|integer|min:1|max:20',
            'label' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $gradeLevel->update($validated);

        return redirect()->route('academic.grade-levels.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        $gradeLevel->delete();
        return redirect()->route('academic.grade-levels.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
