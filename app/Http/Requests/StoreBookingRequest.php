<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_id'         => 'required|integer|exists:trips,id',
            'booking_type'    => 'required|string|in:فردي,جماعي',
            'age_category'    => 'required|string|max:50',
            'hotel_rooms'     => 'required|integer|min:0',
            'seats_count'     => 'required|integer|min:1',
            'national_id'     => 'required|string|max:50',
            'passport_number' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'trip_id.required'         => 'الرحلة مطلوبة',
            'trip_id.exists'           => 'الرحلة غير موجودة',
            'booking_type.required'    => 'نوع الحجز مطلوب',
            'booking_type.in'          => 'نوع الحجز يجب أن يكون: فردي أو جماعي',
            'age_category.required'    => 'الفئة العمرية مطلوبة',
            'hotel_rooms.required'     => 'عدد غرف الفندق مطلوب',
            'hotel_rooms.min'          => 'عدد غرف الفندق لا يقل عن 0',
            'seats_count.required'     => 'عدد المقاعد مطلوب',
            'seats_count.min'          => 'عدد المقاعد يجب أن يكون 1 على الأقل',
            'national_id.required'     => 'رقم الهوية مطلوب',
            'passport_number.max'      => 'رقم الجواز لا يزيد عن 50 حرف',
        ];
    }
}
