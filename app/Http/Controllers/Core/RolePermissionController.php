<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('role_permissions.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        $permissions = RolePermission::where('role_id', $role->id)->get();
        return view('role_permissions.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*.permission' => 'required|string',
            'permissions.*.allowed' => 'required|boolean',
        ]);

        $role->permissions()->delete(); // Clear existing

        foreach ($request->permissions as $perm) {
            RolePermission::create([
                'role_id' => $role->id,
                'permission' => $perm['permission'],
                'allowed' => $perm['allowed'],
            ]);
        }

        return redirect()->route('role-permissions.index')->with('success', 'Permissions updated.');
    }

    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function show($id) { abort(403); }
    public function destroy($id) { abort(403); }
}
