<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Curriculum;
use App\Models\Level;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(['curriculum', 'level', 'major'])->orderBy('order');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $subjects = $query->paginate(10)->withQueryString();

        return view('admin.masters.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $curriculums = Curriculum::all();
        $levels = Level::all();
        $majors = Major::all();

        return view('admin.masters.subjects.create', compact('curriculums', 'levels', 'majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:subjects,name',
            'slug' => 'nullable|string|unique:subjects,slug',
            'code' => 'nullable|string|max:20',
            'type' => 'required|in:wajib,pilihan',
            'is_religious' => 'boolean',
            'description' => 'nullable|string',
            'group' => 'nullable|string|max:50',
            'kkm' => 'nullable|integer|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'level_id' => 'nullable|exists:levels,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'major_id' => 'nullable|exists:majors,id',
        ]);

        Subject::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'code' => $request->code,
            'type' => $request->type,
            'is_religious' => $request->is_religious ?? false,
            'description' => $request->description,
            'group' => $request->group,
            'kkm' => $request->kkm,
            'order' => $request->order ?? 0,
            'level_id' => $request->level_id,
            'curriculum_id' => $request->curriculum_id,
            'major_id' => $request->major_id,
            'is_active' => true,
        ]);

        return redirect()->route('academic.subjects.index')->with('success', 'Subject added.');
    }

    public function edit(Subject $subject)
    {
        $curriculums = Curriculum::all();
        $levels = Level::all();
        $majors = Major::all();

        return view('admin.masters.subjects.edit', compact('subject', 'curriculums', 'levels', 'majors'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:subjects,name,' . $subject->id,
            'slug' => 'nullable|string|unique:subjects,slug,' . $subject->id,
            'code' => 'nullable|string|max:20',
            'type' => 'required|in:wajib,pilihan',
            'is_religious' => 'boolean',
            'description' => 'nullable|string',
            'group' => 'nullable|string|max:50',
            'kkm' => 'nullable|integer|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'level_id' => 'nullable|exists:levels,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'major_id' => 'nullable|exists:majors,id',
        ]);

        $subject->update([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'code' => $request->code,
            'type' => $request->type,
            'is_religious' => $request->is_religious ?? false,
            'description' => $request->description,
            'group' => $request->group,
            'kkm' => $request->kkm,
            'order' => $request->order ?? 0,
            'level_id' => $request->level_id,
            'curriculum_id' => $request->curriculum_id,
            'major_id' => $request->major_id,
        ]);

        return redirect()->route('academic.subjects.index')->with('success', 'Subject updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('academic.subjects.index')->with('success', 'Subject deleted.');
    }
}
