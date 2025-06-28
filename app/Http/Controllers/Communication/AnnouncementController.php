<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementFile;
use App\Models\StudentParent;
use App\Models\User;
use App\Models\School;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
{
    // Ambil query filter dari request
    $search    = $request->input('search');
    $category  = $request->input('category');
    $target    = $request->input('target');
    $priority  = $request->input('priority');

    // Ambil semua pengumuman sesuai filter + pagination
    $announcements = Announcement::with('creator', 'school')
        ->where('is_active', true)
        ->when($search, fn($q) => $q->where('title', 'like', '%' . $search . '%'))
        ->when($category, fn($q) => $q->where('category', $category))
        ->when($target, fn($q) => $q->where('target', $target))
        ->when($priority, fn($q) => $q->where('priority', $priority))
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_at')
        ->paginate(10)
        ->withQueryString(); // biar query tetap saat pagination

    // Sidebar pinned
    $pinned = Announcement::where('is_pinned', true)
        ->where('is_active', true)
        ->latest('published_at')
        ->take(5)
        ->get();

    return view('announcements.index', compact('announcements', 'pinned'));
}

    public function create()
    {
        $schools = School::all();
        $roles = Role::all();
        $users = User::all();

        return view('announcements.create', compact('schools', 'roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category'     => 'nullable|string',
            'priority'     => 'nullable|in:normal,tinggi,mendesak',
            'target'       => 'required|in:all,guru,ortu,siswa',
            'is_public'    => 'boolean',
            'is_active'    => 'boolean',
            'is_pinned'    => 'boolean',
            'published_at' => 'nullable|date',
            'expired_at'   => 'nullable|date|after_or_equal:published_at',
            'files.*'      => 'nullable|file|max:2048',
        ]);

        $user_id = auth()->id(); // atau auth()->user()->id

        $announcement = Announcement::create([
            'uuid'         => Str::uuid(),
            'school_id'    => $request->school_id,
            'user_id'      => $user_id,
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category ?? 'informasi',
            'priority'     => $request->priority ?? 'normal',
            'target'       => $request->target,
            'is_public'    => $request->boolean('is_public'),
            'is_active'    => $request->boolean('is_active'),
            'is_pinned'    => $request->boolean('is_pinned'),
            'published_at' => $request->published_at,
            'expired_at'   => $request->expired_at,
            'school_id'    => $request->school_id,
        ]);

        // Handle file upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('announcements/files', 'public');

                $announcement->files()->create([
                    'uuid'       => Str::uuid(),
                    'file_path'  => $path,
                    'file_name'  => $uploadedFile->getClientOriginalName(),
                    'mime_type'  => $uploadedFile->getMimeType(),
                    'file_size'  => $uploadedFile->getSize(),
                    'file_type'  => explode('/', $uploadedFile->getMimeType())[0],
                ]);
            }
        }

        // TODO: Assign users or roles if specific target

        return redirect()->route('communication.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show($id)
    {
        $announcement = Announcement::with([
            'creator',
            'files',
            'comments.user' // ⬅️ agar nama user di komentar langsung bisa diakses
        ])->findOrFail($id);

        return view('announcements.show', compact('announcement'));
    }
    public function edit($id)
    {
        $announcement = Announcement::with('files')->findOrFail($id);
        $schools = School::all();
        $roles = Role::all();
        $users = User::all();

        return view('announcements.edit', compact('announcement', 'schools', 'roles', 'users'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'priority'     => 'nullable|in:normal,tinggi,mendesak',
            'target'       => 'required|in:all,guru,ortu,siswa',
            'is_public'    => 'boolean',
            'is_active'    => 'boolean',
            'is_pinned'    => 'boolean',
            'published_at' => 'nullable|date',
            'expired_at'   => 'nullable|date|after_or_equal:published_at',
            'files.*'      => 'nullable|file|max:2048',
        ]);

        $announcement->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category ?? 'informasi',
            'priority'     => $request->priority ?? 'normal',
            'target'       => $request->target,
            'is_public'    => $request->boolean('is_public'),
            'is_active'    => $request->boolean('is_active'),
            'is_pinned'    => $request->boolean('is_pinned'),
            'published_at' => $request->published_at,
            'expired_at'   => $request->expired_at,
        ]);

        // Handle new file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('announcements/files', 'public');

                $announcement->files()->create([
                    'uuid'       => Str::uuid(),
                    'file_path'  => $path,
                    'file_name'  => $uploadedFile->getClientOriginalName(),
                    'mime_type'  => $uploadedFile->getMimeType(),
                    'file_size'  => $uploadedFile->getSize(),
                    'file_type'  => explode('/', $uploadedFile->getMimeType())[0],
                ]);
            }
        }

        return redirect()->route('communication.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Hapus file di storage
        foreach ($announcement->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        $announcement->delete();

        return redirect()->route('communication.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function markAsRead($id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->users()->updateExistingPivot(auth()->id, [
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => 'Ditandai sebagai dibaca.']);
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $announcement = Announcement::findOrFail($id);

        $announcement->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('communication.announcements.show', $announcement->id)->with('success', 'Komentar berhasil dikirim.');
    }

    public function manage()
    {
        $announcements = Announcement::with('creator')->orderBy('created_at', 'desc')->get();
        return view('announcements.list', compact('announcements'));
    }
}
