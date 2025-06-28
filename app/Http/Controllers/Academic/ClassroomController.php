<?php

namespace App\Http\Controllers\Academic; // Perhatikan namespace yang benar

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\GradeLevel; // Tambahkan import untuk GradeLevel
use App\Models\AcademicYear;
use App\Models\Curriculum;
use App\Models\Room; // Tambahkan import untuk Model Room
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Asumsikan Anda akan membuat Form Request berikut untuk validasi yang lebih bersih
// use App\Http\Requests\StoreClassroomRequest;
// use App\Http\Requests\UpdateClassroomRequest;

class ClassroomController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index(Request $request)
    {
        $query = Classroom::with(['level', 'academicYear', 'curriculum', 'room']); // Tambahkan 'room' ke eager loading

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('alias', 'like', "%{$search}%"); // Tambahkan pencarian berdasarkan alias
        }

        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // Tambahkan filter berdasarkan is_active jika diperlukan
        if ($request->filled('status')) {
            $query->where('is_active', (bool)$request->status);
        }

        $classrooms = $query->orderBy('order')->paginate(10)->withQueryString(); // Order by 'order' untuk tampilan terurut
        $levels = Level::all();
        $academicYears = AcademicYear::all(); // Perbaiki variabel dari $year menjadi $academicYears (sudah benar)

        return view('admin.masters.classrooms.index', compact('classrooms', 'levels', 'academicYears'));
    }

    /**
     * Menampilkan formulir untuk membuat sumber daya baru.
     */
    public function create()
    {
        $levels = Level::all();
        $gradeLevels = GradeLevel::all();
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();
        $rooms = Room::all(); // Ambil semua ruangan fisik

        return view('admin.masters.classrooms.create', compact('levels', 'gradeLevels', 'academicYears', 'curriculums', 'rooms'));
    }

    /**
     * Menyimpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(Request $request) // Ganti dengan StoreClassroomRequest jika sudah dibuat
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:classrooms,name',
            'alias' => 'nullable|string|max:50',
            'room_id' => 'required|exists:rooms,id', // Diubah dari 'room' string menjadi room_id
            'level_id' => 'required|exists:levels,id', // Diubah menjadi required
            'grade_level_id' => 'required|exists:grade_levels,id', // Diubah menjadi required
            'academic_year_id' => 'required|exists:academic_years,id', // Diubah menjadi required
            'curriculum_id' => 'required|exists:curriculums,id', // Diubah menjadi required
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean', // Set nullable agar bisa diabaikan jika checkbox tidak dicentang
        ]);

        $validated['uuid'] = (string) Str::uuid();
        $validated['order'] = $validated['order'] ?? 0;
        // is_active akan default ke true jika tidak ada di request, atau ambil dari request jika ada
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Classroom::create($validated);

        return redirect()->route('academic.classrooms.index')->with('success', 'Ruangan kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit sumber daya yang ditentukan.
     */
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $levels = Level::all();
        $gradeLevels = GradeLevel::all();
        $academicYears = AcademicYear::all();
        $curriculums = Curriculum::all();
        $rooms = Room::all(); // Ambil semua ruangan fisik

        return view('admin.masters.classrooms.edit', compact('classroom', 'levels', 'gradeLevels', 'academicYears', 'curriculums', 'rooms'));
    }

    /**
     * Memperbarui sumber daya yang ditentukan di penyimpanan.
     */
    public function update(Request $request, $id) // Ganti dengan UpdateClassroomRequest jika sudah dibuat
    {
        $classroom = Classroom::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:classrooms,name,' . $classroom->id,
            'alias' => 'nullable|string|max:50',
            'room_id' => 'required|exists:rooms,id', // Diubah dari 'room' string menjadi room_id
            'level_id' => 'required|exists:levels,id', // Diubah menjadi required
            'grade_level_id' => 'required|exists:grade_levels,id', // Diubah menjadi required
            'academic_year_id' => 'required|exists:academic_years,id', // Diubah menjadi required
            'curriculum_id' => 'required|exists:curriculums,id', // Diubah menjadi required
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean', // Set nullable agar bisa diabaikan jika checkbox tidak dicentang
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false; // Gunakan false jika tidak ada

        $classroom->update($validated);

        return redirect()->route('academic.classrooms.index')->with('success', 'Ruangan kelas berhasil diperbarui.');
    }

    /**
     * Menghapus sumber daya yang ditentukan dari penyimpanan.
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('academic.classrooms.index')->with('success', 'Ruangan kelas berhasil dihapus.');
    }
}