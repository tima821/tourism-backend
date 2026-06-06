<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seats_count'    => 'required|integer|min:1',
            'transport_type' => 'required|string|max:50',
            'request_type'   => 'required|string|in:خاصة,عامة',
            'hotel_required' => 'required|boolean',
            'rooms_count'    => 'required_if:hotel_required,true|nullable|integer|min:1',
            'from_location'  => 'required|string|max:100',
            'to_location'    => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'seats_count.required'    => 'عدد المقاعد مطلوب',
            'seats_count.min'         => 'عدد المقاعد يجب أن يكون 1 على الأقل',
            'transport_type.required' => 'نوع وسيلة النقل مطلوب',
            'request_type.required'   => 'نوع الطلب مطلوب',
            'request_type.in'         => 'نوع الطلب يجب أن يكون: خاصة أو عامة',
            'hotel_required.required' => 'يرجى تحديد إذا كنت تحتاج فندق',
            'rooms_count.required_if' => 'عدد الغرف مطلوب عند اختيار الفندق',
            'from_location.required'  => 'موقع الانطلاق مطلوب',
            'to_location.required'    => 'موقع الوصول مطلوب',
        ];
    }
}
