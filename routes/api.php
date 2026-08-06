<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LeaveRequestController;
use App\Http\Controllers\Api\OvertimeRequestController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Attendance
    Route::get('/attendances/today', [AttendanceController::class, 'today']);
    Route::get('/attendances/history', [AttendanceController::class, 'history']);
    Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut']);

    // Leave Requests
    Route::get('/leave-requests', [LeaveRequestController::class, 'index']);
    Route::post('/leave-requests', [LeaveRequestController::class, 'store']);
    Route::get('/leave-requests/{id}', [LeaveRequestController::class, 'show']);

    // Overtime Requests
    Route::get('/overtime-requests', [OvertimeRequestController::class, 'index']);
    Route::post('/overtime-requests', [OvertimeRequestController::class, 'store']);
    Route::get('/overtime-requests/{id}', [OvertimeRequestController::class, 'show']);
});
