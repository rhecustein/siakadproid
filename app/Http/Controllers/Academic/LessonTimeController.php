<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\LessonTime;
use Illuminate\Http\Request;

class LessonTimeController extends Controller
{
    public function index()
    {
        $times = LessonTime::orderBy('order')->get();
        return view('admin.masters.lesson_times.index', compact('times'));
    }

    public function create()
    {
        return view('admin.masters.lesson_times.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required|integer|min:1|unique:lesson_times,order',
            'start' => 'required|date_format:H:i',
            'end'   => 'required|date_format:H:i|after:start',
        ]);

        LessonTime::create($request->only('order', 'start', 'end'));

        return redirect()->route('lesson-times.index')->with('success', 'Jam pelajaran berhasil ditambahkan.');
    }

    public function edit(LessonTime $lessonTime)
    {
        return view('admin.masters.lesson_times.edit', compact('lessonTime'));
    }

    public function update(Request $request, LessonTime $lessonTime)
    {
        $request->validate([
            'order' => 'required|integer|min:1|unique:lesson_times,order,' . $lessonTime->id,
            'start' => 'required|date_format:H:i',
            'end'   => 'required|date_format:H:i|after:start',
        ]);

        $lessonTime->update($request->only('order', 'start', 'end'));

        return redirect()->route('lesson-times.index')->with('success', 'Jam pelajaran berhasil diperbarui.');
    }

    public function destroy(LessonTime $lessonTime)
    {
        $lessonTime->delete();
        return redirect()->route('lesson-times.index')->with('success', 'Jam pelajaran berhasil dihapus.');
    }
}
