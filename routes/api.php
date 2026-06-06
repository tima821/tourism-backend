<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// مسارات الرحلات
Route::get('/trips/details', [TripController::class, 'indexWithDetails']);
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

// خيارات طلب الرحلة (متاحة بدون تسجيل دخول)
Route::get('trip-request-types', [TripRequestController::class, 'getRequestTypes']);

// مسارات محمية بـ auth
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    // مسارات طلبات الرحلات (المستخدم المسجل فقط)
    Route::post('trip-requests', [TripRequestController::class, 'store']);
    Route::get('trip-requests/{id}', [TripRequestController::class, 'show']);
    Route::get('my-trip-requests', [TripRequestController::class, 'myRequests']);
});
