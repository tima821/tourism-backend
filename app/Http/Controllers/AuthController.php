<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'user_type' => 'customer',
            'status'    => 'pending',
        ]);

        // 2. توليد وحفظ الكود
        $code = mt_rand(100000, 999999);
        VerificationCode::create([
            'email' => $user->email,
            'code'  => $code,
        ]);

        // 3. إرسال الإيميل
        Mail::to($user->email)->send(new VerifyEmailMail($code));

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الحساب، يرجى تفعيل الحساب عبر الكود المرسل لإيميلك',
            'user'    => $user
        ], 201);
    }





    public function verifyAccount(VerifyAccountRequest $request)
    {

        // 2. البحث عن الكود في جدول verification_codes
        $check = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$check) {
            return response()->json([
                'status'  => false,
                'message' => 'الكود غير صحيح، يرجى المحاولة مرة أخرى'
            ], 422);
        }

        // 3. إذا الكود صحيح، نقوم بتفعيل المستخدم
        $user = User::where('email', $request->email)->first();
        $user->update([
            'status' => 'active'
        ]);

        // 4. حذف الكود من الجدول (لأنه استخدم لمرة واحدة فقط)
        $check->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم تفعيل حسابك بنجاح، يمكنك الآن تسجيل الدخول'
        ], 200);
    }


    public function login(LoginRequest $request)
    {
        // 1. محاولة مطابقة البيانات
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => false,
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
            ], 401);
        }

        // 2. جلب بيانات المستخدم
        $user = User::where('email', $request->email)->firstOrFail();

        // 3. الخطوة الاحترافية: التحقق من حالة الحساب
        if ($user->status !== 'active') {
            return response()->json([
                'status'  => false,
                'message' => 'حسابك غير مفعل، يرجى إدخال كود التحقق أولاً'
            ], 403); // كود 403 يعني Forbidden (ممنوع الدخول)
        }

        // 4. إصدار التوكن
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
        // هذه الدالة ترجع بيانات المستخدم صاحب التوكن الحالي
        return response()->json([
            'status' => true,
            'user'   => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (! $user || ! $user->currentAccessToken()) {
            return response()->json([
                'status'  => false,
                'message' => 'لم يتم العثور على الجلسة الحالية أو إنك غير مسجل دخول.',
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الخروج بنجاح.',
        ], 200);
    }


       public function ForgetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $code = rand(100000, 9999999);
        VerificationCode::cerate(['email' => $request->email, 'code' => $code]);
        Mail::to($request->email)->send(new VerifyEmailMail($code));
        return response()->json(['message' => 'reset code send'], 200);
    }

    public function VerifyCode(VerifyAccountRequest $request)

{
    $data = $request->validated();
    $reset = VerificationCode::where('email', $data['email'])
                  ->where('code', $data['code'])
                  ->first();

    if (!$reset) {
        return response()->json(['message' => 'Invalid code'], 400);
    }

    $reset->update(['verified' => true]);

    return response()->json(['message' => 'Code verified'], 200);
}

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min6'
        ]);
        $reset = VerificationCode::where('email', $request->email)
            ->where('verified', true)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Code not verified'], 400);
        }

        User::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        $reset->delete();
        return response()->json(['message' => 'Password reset successfully'], 200);
    }


}

