<?php

namespace App\Http\Controllers;

use App\Models\TripRequest;
use App\Http\Requests\StoreTripRequestRequest;
use Illuminate\Http\JsonResponse;

class TripRequestController extends Controller
{
    public function getRequestTypes(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data'   => ['خاصة', 'عامة'],
        ], 200);
    }

    public function store(StoreTripRequestRequest $request): JsonResponse
    {
        $tripRequest = TripRequest::create([
            ...$request->validated(),
            'user_id'        => auth()->user()->id,
            'request_status' => 'pending',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'تم إرسال طلب الرحلة بنجاح',
            'data'    => $tripRequest,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $tripRequest = TripRequest::find($id);

        if (!$tripRequest) {
            return response()->json([
                'status'  => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        }

        if ($tripRequest->request_type === 'خاصة' && $tripRequest->user_id !== auth()->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بعرض هذا الطلب',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data'   => $tripRequest,
        ], 200);
    }

    public function myRequests(): JsonResponse
    {
        $tripRequests = TripRequest::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => true,
            'data'   => $tripRequests,
        ], 200);
    }
}
