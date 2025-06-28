<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Curriculum; // Pastikan model Curriculum sudah diimport
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan daftar level_groups unik dari kurikulum yang ada
        // Atau Anda bisa mendapatkan ini dari tabel master jenjang pendidikan jika ada
        $levelGroups = Curriculum::select('level_group')
                               ->distinct()
                               ->whereNotNull('level_group')
                               ->pluck('level_group')
                               ->mapWithKeys(function ($item) {
                                   return [$item => strtoupper($item)]; // Format untuk dropdown
                               })
                               ->toArray();

        // Tambahkan opsi default jika Anda tidak memiliki data aktif untuk setiap jenjang
        if (!isset($levelGroups['sd'])) $levelGroups['sd'] = 'SD';
        if (!isset($levelGroups['smp'])) $levelGroups['smp'] = 'SMP';
        if (!isset($levelGroups['sma'])) $levelGroups['sma'] = 'SMA';
        if (!isset($levelGroups['ponpes'])) $levelGroups['ponpes'] = 'PONPES';

        // Filter data kurikulum
        $curriculums = Curriculum::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('level_group', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->level_group, function ($query) use ($request) { // Menggunakan level_group
                $query->where('level_group', $request->level_group);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('is_active', $request->status === 'active' ? true : false);
            })
            ->orderByDesc('start_year')
            ->paginate(10); // Menggunakan paginate untuk pagination

        return view('admin.masters.curriculums.index', compact('curriculums', 'levelGroups'));
    }


    public function create()
    {
        // Untuk form create, mungkin Anda juga perlu melewatkan levelGroups untuk dropdown
        $levelGroups = [
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'ponpes' => 'PONPES',
        ];
        return view('admin.masters.curriculums.create', compact('levelGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:curriculums,name',
            'code' => 'nullable|string|max:100|unique:curriculums,code',
            'start_year' => 'nullable|integer|min:2000|max:2100',
            'end_year' => 'nullable|integer|min:2000|max:2100',
            'level_group' => 'nullable|in:sd,smp,sma,ponpes', // Pastikan ini cocok dengan daftar Anda
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'string',
            'description' => 'nullable|string', // Tambahkan validasi jika diperlukan
            'reference_document' => 'nullable|string', // Tambahkan validasi jika diperlukan
            'regulation_number' => 'nullable|string', // Tambahkan validasi jika diperlukan
        ]);

        Curriculum::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'level_group' => $request->level_group,
            'applicable_grades' => $request->applicable_grades ? json_encode($request->applicable_grades) : null, // Simpan sebagai JSON
            'reference_document' => $request->reference_document,
            'regulation_number' => $request->regulation_number,
            'is_active' => false,
        ]);

        return redirect()->route('academic.curriculums.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $levelGroups = [ // Juga perlu dilewatkan ke view edit
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'ponpes' => 'PONPES',
        ];
        return view('admin.masters.curriculums.edit', compact('curriculum', 'levelGroups'));
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
            'description' => 'nullable|string',
            'reference_document' => 'nullable|string',
            'regulation_number' => 'nullable|string',
        ]);

        $curriculum->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'level_group' => $request->level_group,
            'applicable_grades' => $request->applicable_grades ? json_encode($request->applicable_grades) : null,
            'reference_document' => $request->reference_document,
            'regulation_number' => $request->regulation_number,
            // 'is_active' tidak diubah di sini, diatur oleh activate/deactivate
        ]);

        return redirect()->route('academic.curriculums.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return redirect()->route('academic.curriculums.index')->with('success', 'Kurikulum berhasil dihapus.');
    }

    public function activate($id)
    {
        $curriculum = Curriculum::findOrFail($id);

        // Nonaktifkan semua kurikulum dengan level_group yang sama
        Curriculum::where('level_group', $curriculum->level_group)
            ->where('id', '!=', $curriculum->id) // Jangan nonaktifkan kurikulum yang sedang diaktifkan jika sudah aktif
            ->update(['is_active' => false]);

        // Aktifkan yang dipilih
        $curriculum->update(['is_active' => true]);

        return redirect()->route('academic.curriculums.index')
            ->with('success', 'Kurikulum untuk jenjang ' . strtoupper($curriculum->level_group) . ' telah diaktifkan.');
    }

    public function deactivate($id)
    {
        $curriculum = Curriculum::findOrFail($id);

        if ($curriculum->is_active) {
            $curriculum->update(['is_active' => false]);
        }

        return redirect()->route('academic.curriculums.index')
            ->with('success', 'Kurikulum untuk jenjang ' . strtoupper($curriculum->level_group) . ' telah dinonaktifkan.');
    }
}