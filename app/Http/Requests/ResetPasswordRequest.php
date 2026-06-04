<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email'    => 'يجب أن يكون البريد الإلكتروني صالحاً.',
            'email.exists'   => 'هذا البريد الإلكتروني غير مسجل لدينا.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string'   => 'كلمة المرور يجب أن تكون نصاً.',
            'password.min'      => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ];
    }
}
