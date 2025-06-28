<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentArchiveController extends Controller
{
    public function index()
    {
        $archives = DocumentArchive::with('uploader')->latest()->get();
        return view('document_archives.index', compact('archives'));
    }

    public function create()
    {
        return view('document_archives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'file_path' => 'required|file|max:2048',
            'archived_at' => 'required|date',
        ]);

        $path = $request->file('file_path')->store('archives');

        DocumentArchive::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'file_path' => $path,
            'archived_at' => $request->archived_at,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('facility.document-archives.index')->with('success', 'Document archived.');
    }

    public function show(DocumentArchive $documentArchive)
    {
        return view('document_archives.show', compact('documentArchive'));
    }

    public function edit(DocumentArchive $documentArchive)
    {
        return view('document_archives.edit', compact('documentArchive'));
    }

    public function update(Request $request, DocumentArchive $documentArchive)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'archived_at' => 'required|date',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $data = $request->only(['title', 'category', 'description', 'archived_at']);

        if ($request->hasFile('file_path')) {
            Storage::delete($documentArchive->file_path);
            $data['file_path'] = $request->file('file_path')->store('archives');
        }

        $documentArchive->update($data);

        return redirect()->route('facility.document-archives.index')->with('success', 'Document updated.');
    }

    public function destroy(DocumentArchive $documentArchive)
    {
        Storage::delete($documentArchive->file_path);
        $documentArchive->delete();

        return redirect()->route('facility.document-archives.index')->with('success', 'Document deleted.');
    }
}
