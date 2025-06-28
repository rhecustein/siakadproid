<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $curriculums = Curriculum::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('level_group', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('is_active', $request->status === 'active' ? true : false);
            })
            ->orderByDesc('start_year')
            ->get();

        return view('admin.masters.curriculums.index', compact('curriculums'));
    }


    public function create()
    {
        return view('admin.masters.curriculums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:curriculums,name',
            'code' => 'nullable|string|max:100|unique:curriculums,code',
            'start_year' => 'nullable|integer|min:2000|max:2100',
            'end_year' => 'nullable|integer|min:2000|max:2100',
            'level_group' => 'nullable|in:sd,smp,sma,ponpes',
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'string',
        ]);

        Curriculum::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'level_group' => $request->level_group,
            'applicable_grades' => $request->applicable_grades,
            'reference_document' => $request->reference_document,
            'regulation_number' => $request->regulation_number,
            'is_active' => false,
        ]);

        return redirect()->route('academic.curriculums.index')->with('success', 'Curriculum added.');
    }

    public function edit($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        return view('admin.masters.curriculums.edit', compact('curriculum'));
    }

    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:curriculums,name,' . $curriculum->id,
            'code' => 'nullable|string|max:100|unique:curriculums,code,' . $curriculum->id,
            'start_year' => 'nullable|integer|min:2000|max:2100',
            'end_year' => 'nullable|integer|min:2000|max:2100',
            'level_group' => 'nullable|in:sd,smp,sma,ponpes',
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'string',
        ]);

        $curriculum->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'level_group' => $request->level_group,
            'applicable_grades' => $request->applicable_grades,
            'reference_document' => $request->reference_document,
            'regulation_number' => $request->regulation_number,
        ]);

        return redirect()->route('academic.curriculums.index')->with('success', 'Curriculum updated.');
    }

    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return redirect()->route('academic.curriculums.index')->with('success', 'Curriculum deleted.');
    }

    public function activate($id)
    {
        $curriculum = Curriculum::findOrFail($id);

        // Nonaktifkan semua kurikulum dengan level_group yang sama
        Curriculum::where('level_group', $curriculum->level_group)
            ->update(['is_active' => false]);

        // Aktifkan yang dipilih
        $curriculum->update(['is_active' => true]);

        return redirect()->route('academic.curriculums.index')
            ->with('success', 'Kurikulum untuk level ' . strtoupper($curriculum->level_group) . ' telah diaktifkan.');
    }

    public function deactivate($id)
    {
        $curriculum = Curriculum::findOrFail($id);

        if ($curriculum->is_active) {
            $curriculum->update(['is_active' => false]);
        }

        return redirect()->route('academic.curriculums.index')
            ->with('success', 'Kurikulum untuk level ' . strtoupper($curriculum->level_group) . ' telah dinonaktifkan.');
    }

}
