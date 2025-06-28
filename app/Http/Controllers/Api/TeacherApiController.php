<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TeacherApiController extends Controller
{
    /**
     * Endpoint untuk mencari pengguna yang tersedia (belum terhubung sebagai guru).
     * Digunakan oleh fitur pencarian di halaman 'Tambah Guru'.
     *
     * @param Request $request
     * @return \Illuminate->Http->JsonResponse
     */
    public function searchAvailableUsersForTeacher(Request $request)
    {
        $search = $request->query('q'); // Ambil query pencarian dari parameter 'q'

        // Mencari pengguna yang belum memiliki relasi 'teacher' (belum menjadi guru)
        $users = User::doesntHave('teacher') // Metode ini mengasumsikan ada relasi 'teacher()' di model User
                     ->where(function($query) use ($search) {
                         // Mencari di kolom 'name', 'email', atau 'username'
                         $query->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%");
                     })
                     ->get(['id', 'name', 'email']); // Hanya ambil kolom yang dibutuhkan untuk dropdown

        return response()->json($users);
    }
}