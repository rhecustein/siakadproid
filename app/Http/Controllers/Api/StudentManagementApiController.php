<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentManagementApiController extends Controller
{
    /**
     * Endpoint untuk mencari siswa berdasarkan nama, NIS, atau NISN.
     * Digunakan oleh fitur pencarian di halaman 'Tambah/Edit Tagihan'.
     *
     * @param Request $request
     * @return \Illuminate->Http->JsonResponse
     */
    public function searchStudents(Request $request)
    {
        $search = $request->query('q'); // Ambil query pencarian dari parameter 'q'

        $students = Student::where('name', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%")
                            ->get(['id', 'name', 'nis', 'nisn']); // Hanya ambil kolom yang dibutuhkan

        return response()->json($students);
    }

    // Tambahkan API endpoint lain yang relevan di sini jika ada di masa depan
    // Misalnya, untuk mengambil detail siswa tertentu via API, atau filter lebih lanjut.
}
