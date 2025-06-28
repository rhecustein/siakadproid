<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentParent;

class ParentManagementApiController extends Controller
{
    /**
     * Endpoint untuk mencari pengguna yang tersedia (belum terhubung sebagai siswa).
     * Digunakan oleh fitur pencarian di halaman 'Tambah Siswa'.
     *
     * @param Request $request
     * @return \Illuminate->Http->JsonResponse
     */
    public function searchAvailableUsersForStudent(Request $request)
    {
        $search = $request->query('q');

        // Mencari pengguna yang belum memiliki relasi 'student' (belum menjadi siswa)
        $users = User::doesntHave('student')
                     ->where(function($query) use ($search) {
                         $query->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%");
                     })
                     ->get(['id', 'name', 'email']); // Hanya ambil kolom yang dibutuhkan

        return response()->json($users);
    }

    /**
     * Endpoint untuk mencari orang tua/wali yang tersedia.
     * Digunakan oleh fitur pencarian di halaman 'Tambah Siswa'.
     *
     * @param Request $request
     * @return \Illuminate->Http\JsonResponse
     */
    public function searchAvailableParentsForStudent(Request $request)
    {
        $search = $request->query('q');

        // Mencari StudentParent berdasarkan nama, email, atau nomor telepon
        $parents = StudentParent::where(function($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%")
                                      ->orWhere('email', 'like', "%{$search}%")
                                      ->orWhere('phone', 'like', "%{$search}%");
                            })
                            // ->where('is_active', true) // Opsional: filter hanya parent yang aktif
                            ->get(['id', 'name', 'relationship', 'email', 'phone']); // Ambil kolom yang dibutuhkan

        return response()->json($parents);
    }
}