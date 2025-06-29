<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\EmployeeAttendanceApiController;
use App\Http\Controllers\Api\FingerprintApiController;
use App\Http\Controllers\Api\ParentManagementApiController;
use App\Http\Controllers\Api\TeacherApiController;
use App\Http\Controllers\Api\StudentManagementApiController;
use Illuminate\Support\Facades\Auth;

    // --- Rute Login API Publik (TIDAK dilindungi middleware auth:sanctum) ---
    Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Generate token tanpa prefix user ID
        $fullToken = $user->createToken('auth_token')->plainTextToken;
        $token = explode('|', $fullToken, 2)[1]; // Ambil hanya bagian token (tanpa "11|")

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    return response()->json(['message' => 'Unauthorized: Email atau password salah'], 401);
});

    // --- Rute Logout API Publik (opsional, bisa dilindungi auth:sanctum juga jika mau) ---
    Route::post('/logout', function (Request $request) {
        if (Auth::guard('sanctum')->check()) { // Pastikan user login via Sanctum
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout successful']);
        }
        return response()->json(['message' => 'Tidak ada sesi aktif'], 401);
    })->middleware('auth:sanctum'); // Logout bisa dilindungi token juga

   Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 🔹 Student & Teacher Attendance (Fingerprint or Mobile)
    Route::prefix('attendances')->group(function () {
        Route::post('/', [AttendanceApiController::class, 'store']); // post attendance
        Route::get('/today', [AttendanceApiController::class, 'today']); // all attendance today
        Route::get('/history/{userId}', [AttendanceApiController::class, 'history']); // attendance log by user
    });

    // 🔹 User API (untuk penggunaan internal API, misalnya dropdown)
    Route::prefix('users')->group(function () {
        Route::get('/', [AttendanceApiController::class, 'getAllUsers']); // /api/users
        Route::get('/{userId}', [AttendanceApiController::class, 'getUser']); // /api/users/{id}
    });

    // 🔹 Employee Attendance
    Route::prefix('employee-attendance')->group(function () {
        Route::post('/check-in', [EmployeeAttendanceApiController::class, 'checkIn']);
        Route::post('/check-out', [EmployeeAttendanceApiController::class, 'checkOut']);
        Route::get('/history/{staffId}', [EmployeeAttendanceApiController::class, 'history']);
    });

    // 🔹 Fingerprint API Integration (Device communication)
    Route::prefix('fingerprint')->group(function () {
        Route::post('/log', [FingerprintApiController::class, 'storeLog']); // device logs
        Route::get('/templates/{userId}', [FingerprintApiController::class, 'getTemplates']); // fetch template for enroll
        Route::post('/templates', [FingerprintApiController::class, 'storeTemplate']); // save template
    });

    // 🚀 New AI & Management Related API Endpoints (as discussed)
    // Endpoint untuk mencari user yang belum jadi siswa
    Route::get('/available-users-for-student', [ParentManagementApiController::class, 'searchAvailableUsersForStudent']);

    // Endpoint untuk mencari orang tua/wali yang tersedia
    Route::get('/available-parents-for-student', [ParentManagementApiController::class, 'searchAvailableParentsForStudent']);

    // Endpoint untuk mencari user yang belum jadi guru
    Route::get('/available-users-for-teacher', [TeacherApiController::class, 'searchAvailableUsers']);

    // Endpoint baru untuk mencari siswa
    Route::get('/search-students', [StudentManagementApiController::class, 'searchStudents']); // PENTING: Rute ini
});
   
