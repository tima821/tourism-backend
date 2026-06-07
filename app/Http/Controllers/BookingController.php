<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function getBookingTypes(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data'   => ['فردي', 'جماعي'],
        ], 200);
    }

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $trip = Trip::find($request->trip_id);

        if (!$trip) {
            return response()->json([
                'status'  => false,
                'message' => 'الرحلة غير موجودة',
            ], 404);
        }

        $booking = Booking::create([
            ...$request->validated(),
            'user_id'        => auth()->user()->id,
            'booking_price'  => $trip->trip_cost,
            'booking_status' => 'pending',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الحجز بنجاح',
            'data'    => $booking,
        ], 201);
    }

    public function myBookings(): JsonResponse
    {
        $bookings = Booking::where('user_id', auth()->user()->id)
            ->with('trip')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $bookings,
        ], 200);
    }
}
