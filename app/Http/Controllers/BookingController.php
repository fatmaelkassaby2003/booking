<?php

namespace App\Http\Controllers;

use App\Models\TimeBook;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function book(Request $request)
{
    $request->validate([
        'time_id'       => 'required|exists:times,id',
        'specialist_id' => 'required|exists:specialists,id',
        'service_id'    => 'required|exists:services,id',
    ]);

    $user = auth('api')->user();

    
    $existingBooking = TimeBook::where('time_id', $request->time_id)
        ->where('specialist_id', $request->specialist_id)
        ->first();

    if ($existingBooking) {
        return response()->json([
            'message' => 'Time already booked by another user',
        ], 409); 
    }

    $booking = TimeBook::create([
        'time_id'       => $request->time_id,
        'user_id'       => $user->id,
        'specialist_id' => $request->specialist_id,
        'service_id'    => $request->service_id,
    ]);

    return response()->json([
        'message' => 'Booking created successfully',
        'booking' => $booking,
    ], 201);
}


    public function myBookings()
    {
        $user = auth('api')->user();

        $bookings = TimeBook::with(['service', 'specialist'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'message'  => 'Your bookings',
            'bookings' => $bookings,
        ], 200);
    }


    public function updateBooking(Request $request, $id)
{
    $request->validate([
        'time_id'       => 'sometimes|exists:times,id',
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


   public function cancelBooking(Request $request)
{
    $user = auth('api')->user();

    $id = $request->input('id');

    $booking = TimeBook::where('id', $id)
        ->where('user_id', $user->id)
        ->first();

    if (!$booking) {
        return response()->json([
            'message' => 'Booking not found'
        ], 404);
    }

    $booking->delete();

    return response()->json([
        'message' => 'Booking cancelled successfully'
    ], 200);
}

}
