<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Specialist;

class TimeController extends Controller
{
    public function myTimes()
    {
        $specialist = auth('specialist')->user();

        $times = Time::where('specialist_id', $specialist->id)->get();

        return response()->json([
            'message' => 'All your times with services',
            'times'   => $times,
        ], 200);
    }
}
