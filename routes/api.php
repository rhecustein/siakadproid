<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\EmployeeAttendanceApiController;
use App\Http\Controllers\Api\FingerprintApiController;
use App\Http\Controllers\Api\ParentManagementApiController;
use App\Http\Controllers\Api\TeacherApiController;
use Illuminate\Support\Facades\Auth;

    Route::post('/login-for-api-test', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Hapus token lama jika ingin hanya satu token aktif per user (opsional)
            // $user->tokens()->delete();
            $token = $user->createToken('api-token')->plainTextToken; // Buat token baru

            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }

        return response()->json(['message' => 'Email atau password salah'], 401);
    });

    Route::post('/login-api', function (Request $request) {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            // Hapus token lama jika hanya ingin 1 token aktif per user
            // $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'Login successful', 'token' => $token]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    });
    
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
});
   
