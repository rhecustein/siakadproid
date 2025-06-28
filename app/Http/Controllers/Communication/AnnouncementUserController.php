<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementUser;
use Illuminate\Http\Request;

class AnnouncementUserController extends Controller
{
    /**
     * Admin: tampilkan daftar user yang ditargetkan untuk pengumuman.
     */
    public function index($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        $users = $announcement->users()
            ->withPivot('is_read', 'read_at')
            ->orderBy('pivot_is_read')
            ->get();

        return view('announcements.recipients', compact('announcement', 'users'));
    }

    /**
     * User: tandai sebagai dibaca.
     */
    public function markAsRead($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        $announcement->users()->updateExistingPivot(auth()->id, [
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => 'Ditandai sebagai dibaca.']);
    }

    /**
     * Admin: hapus target user dari pengumuman.
     */
    public function destroy($announcementId, $userId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $announcement->users()->detach($userId);

        return redirect()->back()->with('success', 'Target user telah dihapus dari pengumuman.');
    }
}
