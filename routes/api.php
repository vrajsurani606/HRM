<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AttendanceController;

Route::middleware('auth:sanctum')->group(function () {
    // Attendance routes
    Route::prefix('attendance')->group(function () {
        Route::get('status', [AttendanceController::class, 'checkStatus']);
        Route::post('check-in', [AttendanceController::class, 'checkIn']);
        Route::post('check-out', [AttendanceController::class, 'checkOut']);
        Route::get('history', [AttendanceController::class, 'history']);
    });
});
