<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'حقل اسم المستخدم إلزامي.',
            'username.string'   => 'اسم المستخدم يجب أن يكون نصاً.',
            'username.max'      => 'اسم المستخدم لا يجب أن يتجاوز 100 حرف.',
            'email.required'    => 'حقل البريد الإلكتروني إلزامي.',
            'email.email'       => 'البريد الإلكتروني غير صحيح.',
            'email.unique'      => 'هذا البريد الإلكتروني مسجل بالفعل.',
            'password.required' => 'حقل كلمة المرور إلزامي.',
            'password.min'      => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'كلمة المرور غير متطابقة.',
            'phone.string'      => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.max'         => 'رقم الهاتف لا يجب أن يتجاوز 20 حرف.',
        ];
    }
}
