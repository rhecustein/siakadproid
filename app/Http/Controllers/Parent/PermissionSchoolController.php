<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\PermissionSchool;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentModel;
use Illuminate\Http\Request;

class PermissionSchoolController extends Controller
{
    public function permissions()
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();

        $permissions = PermissionSchool::with('student')
            ->whereHas('student', fn($q) => $q->where('parent_id', $parent->id))
            ->latest()
            ->get();

        return view('parent.permissions.index', compact('permissions'));
    }

    public function createPermission(Request $request)
    {
        $childId = $request->child_id;
        return view('parent.permissions.create', compact('childId'));
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:students,id',
            'leave_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:leave_date',
            'reason' => 'required|string|max:500',
        ]);

        PermissionSchool::create([
            'student_id' => $request->child_id,
            'leave_date' => $request->leave_date,
            'return_date' => $request->return_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('parent.permissions.index')->with('success', 'Permission submitted.');
    }

    public function showPermission($id)
    {
        $permission = PermissionSchool::with('student')->findOrFail($id);
        return view('parent.permissions.show', compact('permission'));
    }

    public function editPermission($id)
    {
        $permission = PermissionSchool::with('student')->findOrFail($id);
        return view('parent.permissions.edit', compact('permission'));
    }

    public function updatePermission(Request $request, $id)
    {
        $request->validate([
            'leave_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:leave_date',
            'reason' => 'required|string|max:500',
            'status' => 'in:pending,approved,rejected'
        ]);

        $permission = PermissionSchool::findOrFail($id);

        $permission->update([
            'leave_date' => $request->leave_date,
            'return_date' => $request->return_date,
            'reason' => $request->reason,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect()->route('parent.permissions.index')->with('success', 'Permission updated.');
    }
}
