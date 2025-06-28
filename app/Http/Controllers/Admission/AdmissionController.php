<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdmissionFile;
use App\Models\AdmissionPayment;
use App\Models\AdmissionSchedule;
use App\Models\AdmissionStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmissionController extends Controller
{
    // 🧾 Daftar Pendaftar
    public function index()
    {
        $admissions = Admission::with(['files', 'payments', 'statusLogs'])->latest()->get();
        return view('admissions.registration.index', compact('admissions'));
    }

    // 📝 Formulir Pendaftaran
    public function create()
    {
        return view('admissions.registration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'birth_date' => 'required|date',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'files.*' => 'file|max:2048'
        ]);

        //'registration_number',
        // 'full_name',
        // 'nisn',
        // 'gender',
        // 'birth_date',
        // 'birth_place',
        // 'previous_school',
        // 'phone',
        // 'email',
        // 'address',
        // 'status',
        $admission = Admission::create($request->only(
        'full_name', 
        'birth_date', 
        'email', 
        'phone',
        'address',
        'status',
        'registration_number',
        'birth_place',
        'previous_school',
        'full_name',
        'nisn',
        'gender',

    ));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('admission_files');
                AdmissionFile::create([
                    'admission_id' => $admission->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('admission.admissions.index')->with('success', 'Pendaftaran berhasil disimpan.');
    }

    // 🔍 Detail Pendaftar
    public function show($id)
    {
        $admission = Admission::with(['files', 'payments', 'statusLogs'])->findOrFail($id);
        return view('admissions.registration.show', compact('admission'));
    }

    // ✅ Halaman Verifikasi & Seleksi
    public function verify($id)
    {
        $admission = Admission::with(['files', 'statusLogs'])->findOrFail($id);
        return view('admissions.registration.verify', compact('admission'));
    }

    public function storeStatusLog($id, Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string'
        ]);

        AdmissionStatusLog::create([
            'admission_id' => $id,
            'status' => $request->status,
            'note' => $request->note
        ]);

        return back()->with('success', 'Status log ditambahkan.');
    }

    // 💰 Halaman & Proses Pembayaran
    public function paymentForm($id)
    {
        $admission = Admission::findOrFail($id);
        return view('admissions.registration.payment', compact('admission'));
    }

    public function storePayment($id, Request $request)
    {
        $request->validate([
            'method' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'proof' => 'nullable|file|max:2048'
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('admission_payments');
        }

        AdmissionPayment::create([
            'admission_id' => $id,
            'method' => $request->method,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'proof' => $proofPath,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function listForVerification()
{
    $admissions = Admission::with('statusLogs')->get();
    return view('admissions.verify_list', compact('admissions'));
}
}
