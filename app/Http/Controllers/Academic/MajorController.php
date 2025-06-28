<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Level; // Pastikan Level diimport
use App\Models\School; // Pastikan School diimport
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::with(['level', 'school'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('slug', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('is_active', $request->status === 'active'))
            // Menambahkan filter berdasarkan level_id dan school_id
            ->when($request->level_id, fn ($q) => $q->where('level_id', $request->level_id))
            ->when($request->school_id, fn ($q) => $q->where('school_id', $request->school_id))
            ->orderBy('order')
            ->paginate(10); // Menggunakan paginate untuk pagination

        // Ambil semua data levels dan schools untuk dropdown filter
        $levels = Level::all();
        $schools = School::all();

        return view('admin.masters.majors.index', compact('majors', 'levels', 'schools'));
    }

    public function create()
    {
        $levels = Level::all();
        $schools = School::all();

        return view('admin.masters.majors.create', compact('levels', 'schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:majors,name',
            'slug' => 'nullable|string|unique:majors,slug',
            'code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            // Perhatikan tipe jurusan yang tersedia, sesuaikan dengan kebutuhan Anda
            // 'academic', 'vocational', 'religious', 'special'
            // Jika di UI hanya ada "umum" dan "kejuruan", pastikan ini konsisten.
            'type' => 'required|in:umum,kejuruan,academic,vocational,religious,special',
            'level_id' => 'nullable|exists:levels,id',
            'school_id' => 'nullable|exists:schools,id',
            'order' => 'nullable|integer|min:0',
        ]);

        Major::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'code' => $request->code,
            'description' => $request->description,
            'type' => $request->type,
            'level_id' => $request->level_id,
            'school_id' => $request->school_id,
            'order' => $request->order ?? 0,
            'is_active' => true,
        ]);

        // Mengubah redirect ke rute yang benar: academic.majors.index
        return redirect()->route('academic.majors.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Major $major)
    {
        $levels = Level::all();
        $schools = School::all();

        return view('admin.masters.majors.edit', compact('major', 'levels', 'schools'));
    }

    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:majors,name,' . $major->id,
            'slug' => 'nullable|string|unique:majors,slug,' . $major->id,
            'code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'type' => 'required|in:umum,kejuruan,academic,vocational,religious,special', // Sesuaikan
            'level_id' => 'nullable|exists:levels,id',
            'school_id' => 'nullable|exists:schools,id',
            'order' => 'nullable|integer|min:0',
        ]);

        $major->update([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'code' => $request->code,
            'description' => $request->description,
            'type' => $request->type,
            'level_id' => $request->level_id,
            'school_id' => $request->school_id,
            'order' => $request->order ?? 0,
        ]);

        // Mengubah redirect ke rute yang benar: academic.majors.index
        return redirect()->route('academic.majors.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Major $major)
    {
        $major->delete();
        // Mengubah redirect ke rute yang benar: academic.majors.index
        return redirect()->route('academic.majors.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}