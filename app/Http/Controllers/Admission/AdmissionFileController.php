<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmissionFileController extends Controller
{
    public function index()
    {
        $files = AdmissionFile::with('admission')->latest()->get();
        return view('admission_files.index', compact('files'));
    }

    public function create()
    {
        return view('admission_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'file_type' => 'required|string',
            'file_path' => 'required|file|max:2048',
        ]);

        $path = $request->file('file_path')->store('admission_files');

        AdmissionFile::create([
            'admission_id' => $request->admission_id,
            'file_type' => $request->file_type,
            'file_path' => $path,
        ]);

        return redirect()->route('admission-files.index')->with('success', 'File uploaded.');
    }

    public function show(AdmissionFile $admissionFile)
    {
        return view('admission_files.show', compact('admissionFile'));
    }

    public function edit(AdmissionFile $admissionFile)
    {
        return view('admission_files.edit', compact('admissionFile'));
    }

    public function update(Request $request, AdmissionFile $admissionFile)
    {
        $request->validate([
            'file_type' => 'required|string',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $data = $request->only(['file_type']);

        if ($request->hasFile('file_path')) {
            Storage::delete($admissionFile->file_path);
            $data['file_path'] = $request->file('file_path')->store('admission_files');
        }

        $admissionFile->update($data);

        return redirect()->route('admission-files.index')->with('success', 'File updated.');
    }

    public function destroy(AdmissionFile $admissionFile)
    {
        Storage::delete($admissionFile->file_path);
        $admissionFile->delete();

        return redirect()->route('admission-files.index')->with('success', 'File deleted.');
    }
}
