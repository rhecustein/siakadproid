<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\EmployeeAttendanceApiController;
use App\Http\Controllers\Api\FingerprintApiController;


    // 🔹 Student & Teacher Attendance (Fingerprint or Mobile)
    Route::prefix('attendances')->group(function () {
        Route::post('/', [AttendanceApiController::class, 'store']); // post attendance
        Route::get('/today', [AttendanceApiController::class, 'today']); // all attendance today
        Route::get('/history/{userId}', [AttendanceApiController::class, 'history']); // attendance log by user
    });

     // 🔹 User Api
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

   

