<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyAccountRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // 1. إنشاء المستخدم
        $user = User::create([
            'username'                      => $request->username,
            'email'                         => $request->email,
            'password'                      => Hash::make($request->password),
            'phone'                         => $request->phone,
            'user_type'                     => 'customer',
            'status'                        => 'pending',
            'verification_code'             => 123456,        // ← أضف
            'verification_code_expires_at'  => now()->addMinutes(15), // ← أضف
        ]);

        // ⚠️ TODO: احذف السطر التالي آخر المشروع
        $code = 123456;
        // ⚠️ TODO: فك التعليق عن السطر التالي آخر المشروع
        // $code = mt_rand(100000, 999999);

        VerificationCode::create([
            'email' => $user->email,
            'code'  => $code,
             // ⚠️
             'expire_at' => now()->addMinutes(15),
        ]);

        // ⚠️ TODO: فك التعليق عن السطر التالي آخر المشروع
        // Mail::to($user->email)->send(new VerifyEmailMail($code));

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الحساب، يرجى تفعيل الحساب عبر الكود المرسل لإيميلك',
            'user'    => $user
        ], 201);
    }


    public function verifyAccount(VerifyAccountRequest $request)
    {
        $check = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
             // ⚠️
             ->where('expire_at', '>', now())
            ->first();

        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'الكود غير صحيح، يرجى المحاولة مرة أخرى'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'status' => 'active'
        ]);

        $check->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم تفعيل حسابك بنجاح، يمكنك الآن تسجيل الدخول'
        ], 200);
    }


    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => false,
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->status !== 'active') {
            return response()->json([
                'status'  => false,
                'message' => 'حسابك غير مفعل، يرجى إدخال كود التحقق أولاً'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'user'    => $user,
            'token'   => $token
        ], 200);
    }


    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'user'   => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200);
    }


    public function forgetPassword(ForgetPasswordRequest $request)
    {
        VerificationCode::where('email', $request->email)->delete();

        // ⚠️ TODO: احذف السطر التالي آخر المشروع
        $code = 123456;
        // ⚠️ TODO: فك التعليق عن السطر التالي آخر المشروع
        // $code = mt_rand(100000, 999999);

        VerificationCode::create([
            'email'     => $request->email,
            'code'      => $code,
            'verified'  => false,
            'expire_at' => now()->addMinutes(15),
        ]);

        // ⚠️ TODO: فك التعليق عن السطر التالي آخر المشروع
        // Mail::to($request->email)->send(new VerifyEmailMail($code));

        return response()->json([
            'status'  => true,
            'message' => 'تم إرسال كود إعادة التعيين بنجاح، الكود صالح لمدة 15 دقيقة.'
        ], 200);
    }

    public function verifyCode(VerifyAccountRequest $request)
    {
        $data = $request->validated();

        $reset = VerificationCode::where('email', $data['email'])
            ->where('code', $data['code'])
            ->where('expire_at', '>', now())
            ->first();

        if (!$reset) {
            return response()->json([
                'status'  => false,
                'message' => 'الكود غير صحيح أو انتهت صلاحيته'
            ], 400);
        }

        $reset->update(['verified' => true]);

        return response()->json([
            'status'  => true,
            'message' => 'تم التحقق من الكود بنجاح، يمكنك الآن تعيين كلمة مرور جديدة'
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $reset = VerificationCode::where('email', $request->email)
            ->where('verified', true)
            ->first();

        if (!$reset) {
            return response()->json([
                'status'  => false,
                'message' => 'لم يتم التحقق من الكود بعد، أو الطلب غير مصرح به'
            ], 403);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        $reset->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم إعادة تعيين كلمة المرور بنجاح'
        ], 200);
    }
}
