<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\SpecialistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingSpeController;
use App\Models\Specialist;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [UserController::class, 'login']);
Route::post('/sign', [UserController::class, 'sign']);

Route::post('/login/specialist', [SpecialistController::class, 'specialistLogin']);
Route::post('/sign/specialist', [SpecialistController::class, 'sign']);


Route::middleware('auth:specialist')->group(function () {
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/update', [ServiceController::class, 'update']);
    Route::delete('/services/delete', [ServiceController::class, 'destroy']);
    Route::get('/my-services', [ServiceController::class, 'myServices']);
    Route::get('/my-times', [TimeController::class, 'myTimes']);
    Route::get('/specialist/dashboard', [BookingSpeController::class, 'specialistBookingsAndTimes']);

});


Route::middleware('auth:api')->group(function () 
{
    Route::post('/book', [BookingController::class, 'book']);      
    Route::get('/bookings', [BookingController::class, 'myBookings']);
    Route::put('/update-booking/{id}', [BookingController::class, 'updateBooking']);
    Route::delete('/cancel-booking', [BookingController::class, 'cancelBooking']);
});


