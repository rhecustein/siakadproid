<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('admin.masters.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.masters.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255|unique:branches,name',
            'address' => 'nullable|string|max:500',
        ]);

        Branch::create([
            'uuid'    => Str::uuid(),
            'slug'    => Str::slug($request->name),
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('master.branches.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function show(Branch $branch)
    {
        return view('admin.masters.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('admin.masters.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'    => 'required|string|max:255|unique:branches,name,' . $branch->id,
            'address' => 'nullable|string|max:500',
        ]);

        $branch->update([
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('master.branches.index')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('master.branches.index')->with('deleted', 'Cabang berhasil dihapus.');
    }
}
