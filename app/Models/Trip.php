<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
     protected $fillable = [
        'trip_type',
        'start_time',
        'end_time',
        'booking_start_date',
        'booking_end_date',
        'available_seats',
        'total_seats',
        'trip_cost',
    ];

// ا رحلة لها حجوزات كثيرة
     public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
  
}
