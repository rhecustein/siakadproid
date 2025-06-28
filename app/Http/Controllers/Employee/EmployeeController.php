<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with('school');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
        }

        $employees = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        return view('employees.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nip' => 'nullable|unique:employees,nip',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'education_level' => 'nullable|string',
            'last_education_institution' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        Employee::create($validated);

        return redirect()->route('employee.employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $schools = School::all();
        return view('employees.edit', compact('employee', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nip' => "nullable|unique:employees,nip,{$employee->id}",
            'name' => 'required|string|max:255',
            'email' => "nullable|email|unique:employees,email,{$employee->id}",
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'education_level' => 'nullable|string',
            'last_education_institution' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employee.employees.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('employee.employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
