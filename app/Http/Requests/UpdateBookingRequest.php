<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
        'booking_type'     => 'sometimes|string',
        'age_category'     => 'sometimes|string',
        'hotel_rooms'      => 'sometimes|integer',
        'seats_count'      => 'sometimes|integer',
        'national_id'      => 'sometimes|string',
        'passport_number'  => 'nullable|string',
    ];
}
}
