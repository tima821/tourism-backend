<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripRequest extends Model
{
    protected $fillable = [
        'user_id',
        'seats_count',
        'transport_type',
        'request_status',
        'request_type',
        'hotel_required',
        'rooms_count',
        'from_location',
        'to_location',
    ];

    protected $casts = [
        'hotel_required' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
