<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AttendanceApiController extends Controller
{
    /**
     * Ambil semua data user aktif untuk keperluan absensi / fingerprint
     */
    public function getAllUsers(Request $request)
    {
        $users = User::where('is_active', true)
            ->select([
                'uuid',
                'name',
                'username',
                'email',
                'phone_number',
                'role_id',
                'detail_id',
                'avatar',
                'village_id',
                'fingerprint',
            ])
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diambil.',
            'data' => $users
        ]);
    }

    public function getUser($userId)
    {
        // Cek apakah parameter berupa UUID (panjang 36 karakter) atau ID numerik
        $user = strlen($userId) === 36
            ? User::where('uuid', $userId)->first()
            : User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diambil.',
            'data' => [
                'uuid'          => $user->uuid,
                'name'          => $user->name,
                'username'      => $user->username,
                'email'         => $user->email,
                'phone_number'  => $user->phone_number,
                'role_id'       => $user->role_id,
                'detail_id'     => $user->detail_id,
                'avatar'        => $user->avatar,
                'village_id'    => $user->village_id,
                'is_active'     => $user->is_active,
                'fingerprint'   => $user->fingerprint,
            ]
        ]);
    }

    public function update(Request $request)
    {
        Log::info('Hit endpoint: /update-fingerprint', [
            'method' => $request->method(),
            'uuid' => $request->input('uuid'),
            'fingerprint_length' => strlen($request->input('fingerprint', '')),
        ]);

        try {
            $request->validate([
                'uuid' => 'required|uuid',
                'fingerprint' => 'required|string',
            ]);

            $user = User::where('uuid', $request->uuid)->first();

            if (!$user) {
                Log::warning('User not found', ['uuid' => $request->uuid]);
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $user->fingerprint = $request->fingerprint;
            $user->save();

            Log::info('Fingerprint updated', ['uuid' => $request->uuid]);

            return response()->json(['success' => true, 'message' => 'Fingerprint updated successfully']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Unexpected error in update-fingerprint', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

}
