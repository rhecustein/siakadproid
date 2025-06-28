<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentParent::with('user');

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $parents = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.masters.parents.index', compact('parents'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.masters.parents.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'nik'          => 'nullable|string|max:20|unique:parents,nik',
            'name'         => 'required|string|max:255',
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $validated['uuid'] = Str::uuid();

        \App\Models\StudentParent::create($validated);

        return redirect()->route('core.parents.index')->with('success', 'Data wali berhasil ditambahkan.');
    }

    public function show(StudentParent $parent)
    {
        return view('admin.masters.parents.show', compact('parent'));
    }

    public function edit(StudentParent $parent)
    {
        $users = User::all();
        return view('admin.masters.parents.edit', compact('parent', 'users'));
    }

    public function update(Request $request, StudentParent $parent)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'nik'          => "nullable|string|max:20|unique:parents,nik,{$parent->id}",
            'name'         => 'required|string|max:255',
            'gender'       => 'nullable|in:L,P',
            'relationship' => 'nullable|in:ayah,ibu,wali',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $parent->update($validated);

        return redirect()->route('core.parents.index')->with('success', 'Data wali berhasil diperbarui.');
    }

    public function destroy(StudentParent $parent)
    {
        $parent->delete();

        return redirect()->route('core.parents.index')->with('success', 'Data wali berhasil dihapus.');
    }
}
