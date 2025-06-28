<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(5);
        $schools = School::with('branch')->latest()->paginate(10);
        return view('admin.masters.schools.index', compact('schools', 'branches'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('admin.masters.schools.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:255',
            'npsn'      => 'nullable|string|max:20',
            'type'      => 'nullable|string|max:50',
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
        ]);

        School::create([
            'uuid'      => Str::uuid(),
            'branch_id' => $request->branch_id,
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'npsn'      => $request->npsn,
            'type'      => $request->type,
            'address'   => $request->address,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        return redirect()->route('shared.schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    public function edit(School $school)
    {
        $branches = Branch::all();
        return view('admin.masters.schools.edit', compact('school', 'branches'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:255',
            'npsn'      => 'nullable|string|max:20',
            'type'      => 'nullable|string|max:50',
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
        ]);

        $school->update([
            'branch_id' => $request->branch_id,
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'npsn'      => $request->npsn,
            'type'      => $request->type,
            'address'   => $request->address,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        return redirect()->route('shared.schools.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('shared.schools.index')->with('deleted', 'Sekolah berhasil dihapus.');
    }
}

