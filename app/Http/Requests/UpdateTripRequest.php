<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
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
            'trip_type' => 'sometimes|string|max:50',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
            'booking_start_date' => 'sometimes|date',
            'booking_end_date' => 'sometimes|date|after:booking_start_date',
            'available_seats' => 'sometimes|integer',
            'total_seats' => 'sometimes|integer',
            'trip_cost' => 'sometimes|numeric',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'trip_type.string' => 'نوع الرحلة يجب أن يكون نصاً.',
            'trip_type.max' => 'نوع الرحلة لا يزيد عن 50 حرف.',
            'start_time.date' => 'وقت البدء يجب أن يكون تاريخاً صحيحاً.',
            'end_time.date' => 'وقت الانتهاء يجب أن يكون تاريخاً صحيحاً.',
            'end_time.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البدء.',
            'booking_start_date.date' => 'تاريخ بدء الحجز يجب أن يكون تاريخاً صحيحاً.',
            'booking_end_date.date' => 'تاريخ انتهاء الحجز يجب أن يكون تاريخاً صحيحاً.',
            'booking_end_date.after' => 'تاريخ انتهاء الحجز يجب أن يكون بعد تاريخ بدء الحجز.',
            'available_seats.integer' => 'عدد المقاعد المتاحة يجب أن يكون رقماً.',
            'total_seats.integer' => 'إجمالي المقاعد يجب أن يكون رقماً.',
            'trip_cost.numeric' => 'تكلفة الرحلة يجب أن تكون رقماً.',
        ];
    }
}
