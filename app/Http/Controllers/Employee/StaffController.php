<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Staff::with('school');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
        }

        $staffs = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $users = User::all();
        return view('staffs.create', compact('schools', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'nip' => 'nullable|unique:staffs,nip',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:staffs,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:100',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'education_level' => 'nullable|string|max:50',
            'last_education_institution' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['uuid'] = Str::uuid();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staffs/photos', 'public');
        }

        Staff::create($validated);

        return redirect()->route('employee.staffs.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staffs)
    {
        return view('staffs.show', compact('staffs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staffs)
    {
        $schools = School::all();
        $users = User::all();
        return view('staffs.edit', compact('staffs', 'schools', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staffs $staffs)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'nip' => "nullable|unique:staffs,nip,{$staffs->id}",
            'name' => 'required|string|max:255',
            'email' => "nullable|email|unique:staffs,email,{$staffs->id}",
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:100',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'education_level' => 'nullable|string|max:50',
            'last_education_institution' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('photo')) {
            if ($staffs->photo) {
                Storage::disk('public')->delete($staffs->photo);
            }
            $validated['photo'] = $request->file('photo')->store('staffs/photos', 'public');
        }

        $staffs->update($validated);

        return redirect()->route('employee.staffs.index')->with('success', 'Staff berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staffs)
    {
        if ($staffs->photo) {
            Storage::disk('public')->delete($staffs->photo);
        }

        $staffs->delete();

        return redirect()->route('employee.staffs.index')->with('success', 'Staff berhasil dihapus.');
    }
}
