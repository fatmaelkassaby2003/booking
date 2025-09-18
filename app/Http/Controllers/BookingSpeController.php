<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeBook;
use App\Models\Time;
use App\Models\Specialist;

class BookingSpeController extends Controller
{
    public function specialistBookingsAndTimes()
    {
        $specialist = auth('specialist')->user();

        $bookings = TimeBook::with(['service', 'specialist'])
            ->where('specialist_id', $specialist->id)
            ->get();

        $bookedTimeIds = $bookings->pluck('time_id')->toArray();

        $availableTimes = Time::where('specialist_id', $specialist->id)
            ->whereNotIn('time', $bookedTimeIds)
            ->with('service')
            ->get();

        return response()->json([
            'message' => 'Specialist data fetched successfully',
            'bookings' => $bookings,
            'available_times' => $availableTimes,
        ], 200);
    }


    public function updateBooking(Request $request, $id)
{
    $request->validate([
        'time_id'       => 'sometimes|string',
        'service_id'    => 'sometimes|exists:services,id',
        'specialist_id' => 'sometimes|exists:specialists,id',
    ]);

    $user = auth('api')->user();

    $booking = TimeBook::where('id', $id)
        ->where('user_id', $user->id)
        ->first();

    if (!$booking) {
        return response()->json([
            'message' => 'Booking not found'
        ], 404);
    }

    $specialist_id = $request->specialist_id ?? $booking->specialist_id;
    $time_id       = $request->time_id ?? $booking->time_id;

    $existingBooking = TimeBook::where('time_id', $time_id)
        ->where('specialist_id', $specialist_id)
        ->where('id', '!=', $booking->id)
        ->first();

    if ($existingBooking) {
        return response()->json([
            'message' => 'This time is already booked by another user'
        ], 409);
    }

    $booking->time_id       = $time_id;
    $booking->service_id    = $request->service_id ?? $booking->service_id;
    $booking->specialist_id = $specialist_id;

    $booking->save();

    return response()->json([
        'message' => 'Booking updated successfully',
        'booking' => $booking
    ], 200);
}

}
