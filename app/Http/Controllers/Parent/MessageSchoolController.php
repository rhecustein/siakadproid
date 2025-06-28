<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InboxSchool;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageSchoolController extends Controller
{
    public function messages()
    {
        $parent = Auth::user()->parent;
        $studentIds = $parent->students->pluck('id');

        $messages = InboxSchool::with(['student', 'receiver'])
            ->whereIn('student_id', $studentIds)
            ->latest()
            ->get();

        return view('parent.messages.index', compact('messages'));
    }

    public function createMessage(Request $request)
    {
        $parent = Auth::user()->parent;
        $children = $parent->students;
        $teachers = User::where('role_id', 3)->get(); // assuming role_id 3 is wali kelas

        return view('parent.messages.create', compact('children', 'teachers'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        InboxSchool::create([
            'uuid' => (string) \Str::uuid(),
            'student_id' => $request->student_id,
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dikirim.');
    }

    public function showMessage($id)
    {
        $message = InboxSchool::with(['student', 'receiver'])->findOrFail($id);
        $message->update(['status' => 'read']);

        return view('parent.messages.show', compact('message'));
    }

    public function editMessage($id)
    {
        $message = InboxSchool::findOrFail($id);
        return view('parent.messages.edit', compact('message'));
    }

    public function updateMessage(Request $request, $id)
    {
        $message = InboxSchool::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $message->update([
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->route('messages.index')->with('success', 'Pesan berhasil diperbarui.');
    }
}
