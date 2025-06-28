<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\FingerprintTemplate;
use App\Models\User;
use Illuminate\Http\Request;

class FingerprintController extends Controller
{
    /**
     * Tampilkan form tambah sidik jari
     */
    public function create(User $user)
    {
        return view('admin.fingerprint.create', compact('user'));
    }

    /**
     * Simpan sidik jari ke database
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'finger_position' => 'required|string|max:50',
            'template_data'   => 'required|string',
            'device_type'     => 'nullable|string|in:absensi,kantin,lainnya',
        ]);

        $user->fingerprintTemplates()->create([
            'finger_position' => $request->finger_position,
            'template_data'   => $request->template_data,
            'device_type'     => $request->device_type ?? 'absensi',
        ]);

        return redirect()
            ->route('core.users.index')
            ->with('success', 'Sidik jari berhasil ditambahkan.');
    }
}
