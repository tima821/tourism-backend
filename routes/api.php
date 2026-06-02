<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// مسارات الرحلات
Route::apiResource('trips', TripController::class);

// مسارات المستخدم
Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// مسارات المصادقة
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-account', [AuthController::class, 'verifyAccount']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('verify-code', [AuthController::class, 'verifyCode']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// مسارات محمية بـ auth
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});
