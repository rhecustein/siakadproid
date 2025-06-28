<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\School;
use App\Models\Grade;

class ParentChildController extends Controller
{
    /**
     * Display a listing of the children related to authenticated parent.
     */
    public function index()
    {
        $user = Auth::user();

        $parent = ParentModel::where('user_id', $user->id)->firstOrFail();

        $children = Student::with(['school', 'grade'])
            ->where('parent_id', $parent->id)
            ->get();

        return view('parent.students.index', compact('children'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create()
    {
        $schools = School::all();
        $grades = Grade::all();
        return view('parent.students.create', compact('schools', 'grades'));
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request)
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'grade_id' => 'required|exists:grades,id',
            'nis' => 'nullable|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'religion' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $validated['parent_id'] = $parent->id;

        Student::create($validated);

        return redirect()->route('parent.students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified child (detail).
     */
    public function show($id)
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();
        $activeTab = request('tab', 'statistik');
        $student = Student::with(['school', 'grade'])
            ->where('id', $id)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        return view('parent.students.show', compact('student','activeTab'));
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit($id)
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();

        $student = Student::where('id', $id)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        $schools = School::all();
        $grades = Grade::all();

        return view('parent.students.edit', compact('student', 'schools', 'grades'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, $id)
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();

        $student = Student::where('id', $id)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        $validated = $request->validate([
            'notes' => 'nullable|string',
            'phone' => 'nullable|string|max:20'
        ]);

        $student->update($validated);

        return redirect()->route('parent.students.index')->with('success', 'Student updated successfully.');
    }

     // Messages
    public function messages()
    {
        return view('parent.messages.index');
    }

    public function createMessage(Request $request)
    {
        $childId = $request->child_id;
        return view('parent.messages.create', compact('childId'));
    }

    public function storeMessage(Request $request)
    {
        // logic for storing the message
        // ex: validate, create Message model, attach parent_id and child_id
        return redirect()->route('parent.messages.index')->with('success', 'Message sent successfully.');
    }

    public function showMessage($id)
    {
        // get specific message
        return view('parent.messages.show', compact('id'));
    }

    public function editMessage($id)
    {
        // load message to edit
        return view('parent.messages.edit', compact('id'));
    }

    public function updateMessage(Request $request, $id)
    {
        // logic to update message
        return redirect()->route('parent.messages.index')->with('success', 'Message updated successfully.');
    }

}