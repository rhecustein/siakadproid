<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnnouncementFilesController extends Controller
{
    /**
     * Simpan file lampiran (jika upload langsung dari pengumuman).
     */
    public function store(Request $request)
    {
        $request->validate([
            'announcement_id' => 'required|exists:announcements,id',
            'file' => 'required|file|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('announcements/files', 'public');

        $announcementFile = AnnouncementFile::create([
            'uuid'        => Str::uuid(),
            'announcement_id' => $request->announcement_id,
            'file_path'   => $path,
            'file_name'   => $file->getClientOriginalName(),
            'mime_type'   => $file->getMimeType(),
            'file_size'   => $file->getSize(),
            'file_type'   => explode('/', $file->getMimeType())[0],
        ]);

        return response()->json([
            'success' => true,
            'file' => $announcementFile,
        ]);
    }

    /**
     * Tampilkan file (preview atau download).
     */
    public function show($id)
    {
        $file = AnnouncementFile::findOrFail($id);

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    /**
     * Hapus file lampiran.
     */
    public function destroy($id)
    {
        $file = AnnouncementFile::findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($file->file_path);

        // Hapus record dari database
        $file->delete();

        return redirect()->back()->with('success', 'File lampiran berhasil dihapus.');
    }
}
