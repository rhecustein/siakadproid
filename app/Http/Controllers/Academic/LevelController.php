<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('order')->paginate(10);
        return view('academics.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('academics.levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|unique:levels,slug',
            'type' => 'nullable|string|max:50',
            'min_grade' => 'nullable|integer|min:1',
            'max_grade' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['uuid'] = Str::uuid();

        Level::create($validated);

        return redirect()->route('academic.levels.index')->with('success', 'Level berhasil ditambahkan.');
    }

    public function edit(Level $level)
    {
        return view('academics.levels.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|unique:levels,slug,' . $level->id,
            'type' => 'nullable|string|max:50',
            'min_grade' => 'nullable|integer|min:1',
            'max_grade' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $level->update($validated);

        return redirect()->route('academic.levels.index')->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('academic.levels.index')->with('success', 'Level dihapus.');
    }
}
