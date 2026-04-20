<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('register', [AuthController::class, 'register']);
Route::post('verify-account', [AuthController::class, 'verifyAccount']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // هذا هو الرابط الذي سيطلبه الفرونت إيند لجلب بيانات المستخدم
    Route::get('/profile', [AuthController::class, 'profile']);

    // رابط تسجيل الخروج الذي برمجتيه سابقاً
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::post('forget-password',[AuthController::class,'ForgetPassword']);
Route::post('verify-code',[AuthController::class,'VerifyCode']);
Route::post('reset-password',[AuthController::class,'resetpassword']);

