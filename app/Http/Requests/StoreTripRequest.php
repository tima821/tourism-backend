<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'trip_type' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'booking_start_date' => 'required|date',
            'booking_end_date' => 'required|date|after:booking_start_date',
            'available_seats' => 'required|integer',
            'total_seats' => 'required|integer',
            'trip_cost' => 'required|numeric',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'trip_type.required' => 'نوع الرحلة مطلوب',
            'trip_type.max' => 'نوع الرحلة لا يزيد عن 50 حرف',
            'start_time.required' => 'وقت البدء مطلوب',
            'start_time.date' => 'وقت البدء يجب أن يكون تاريخاً صحيحاً',
            'end_time.required' => 'وقت الانتهاء مطلوب',
            'end_time.date' => 'وقت الانتهاء يجب أن يكون تاريخاً صحيحاً',
            'end_time.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البدء',
            'booking_start_date.required' => 'تاريخ بدء الحجز مطلوب',
            'booking_start_date.date' => 'تاريخ بدء الحجز يجب أن يكون تاريخاً صحيحاً',
            'booking_end_date.required' => 'تاريخ انتهاء الحجز مطلوب',
            'booking_end_date.date' => 'تاريخ انتهاء الحجز يجب أن يكون تاريخاً صحيحاً',
            'booking_end_date.after' => 'تاريخ انتهاء الحجز يجب أن يكون بعد تاريخ البدء',
            'available_seats.required' => 'عدد المقاعد المتاحة مطلوب',
            'available_seats.integer' => 'عدد المقاعد المتاحة يجب أن يكون رقماً',
            'total_seats.required' => 'إجمالي المقاعد مطلوب',
            'total_seats.integer' => 'إجمالي المقاعد يجب أن يكون رقماً',
            'trip_cost.required' => 'تكلفة الرحلة مطلوبة',
            'trip_cost.numeric' => 'تكلفة الرحلة يجب أن تكون رقماً',
        ];
    }
}
