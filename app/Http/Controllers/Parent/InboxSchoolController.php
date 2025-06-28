<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\InboxSchool;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxSchoolController extends Controller
{
    public function index()
    {
        $parent = ParentModel::where('user_id', Auth::id())->firstOrFail();

        $messages = InboxSchool::with(['student', 'receiver'])
            ->whereHas('student', fn($q) => $q->where('parent_id', $parent->id))
            ->latest()
            ->get();

        return view('parent.inbox.index', compact('messages'));
    }

    public function create(Request $request)
    {
        $childId = $request->child_id;
        return view('parent.inbox.create', compact('childId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:students,id',
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ]);

        InboxSchool::create([
            'student_id' => $request->child_id,
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return redirect()->route('parent.messages.index')->with('success', 'Pesan berhasil dikirim.');
    }

    public function show(InboxSchool $inboxSchool)
    {
        return view('parent.inbox.show', compact('inboxSchool'));
    }

    public function edit(InboxSchool $inboxSchool)
    {
        return view('parent.inbox.edit', compact('inboxSchool'));
    }

    public function update(Request $request, InboxSchool $inboxSchool)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
            'status' => 'in:unread,read'
        ]);

        $inboxSchool->update($request->only('subject', 'message', 'status'));

        return redirect()->route('parent.messages.index')->with('success', 'Pesan berhasil diperbarui.');
    }

    public function destroy(InboxSchool $inboxSchool)
    {
        $inboxSchool->delete();

        return redirect()->route('parent.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
