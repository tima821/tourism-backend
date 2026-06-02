<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;

class TripController extends Controller
{
    // عرض جميع الرحلات
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Trip::all()
        ], 200);
    }

    // إنشاء رحلة جديدة
    public function store(StoreTripRequest $request)
    {
        // استخدام البيانات التي تم التحقق منها فقط
        $trip = Trip::create($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الرحلة بنجاح',
            'trip'    => $trip
        ], 201);
    }

    // عرض تفاصيل رحلة معينة
    public function show(Trip $trip)
    {
        return response()->json([
            'status' => true,
            'data'   => $trip
        ], 200);
    }

    // تعديل بيانات رحلة
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'تم تحديث بيانات الرحلة بنجاح',
            'trip'    => $trip
        ], 200);
    }

    // حذف رحلة
    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم حذف الرحلة بنجاح'
        ], 200);
    }
}
