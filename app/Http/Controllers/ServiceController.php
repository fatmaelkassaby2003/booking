<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Specialist;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $specialist = auth('specialist')->user();

    $service = Service::create([
        'name' => $request->name,
        'price' => $request->price,
        'specialist_id' => $specialist->id,
    ]);

    return response()->json([
        'message' => 'Service created successfully',
        'service' => $service,
    ], 201);
}


public function update(Request $request)
{
    $request->validate([
        'service_id' => 'required|integer|exists:services,id',
        'name'       => 'sometimes|required|string|max:255',
        'price'      => 'sometimes|required|numeric|min:0',
    ]);

    $specialist = auth('specialist')->user();

    $service = Service::where('id', $request->service_id)
                      ->where('specialist_id', $specialist->id)
                      ->first();

    if (!$service) {
        return response()->json([
            'message' => 'Service not found or not authorized',
        ], 404);
    }

    $service->update($request->only(['name', 'price']));

    return response()->json([
        'message' => 'Service updated successfully',
        'service' => $service,
    ], 200);
}

public function destroy(Request $request)
{
    $request->validate([
        'service_id' => 'required|integer|exists:services,id',
    ]);

    $specialist = auth('specialist')->user();

    $service = Service::where('id', $request->service_id)
                      ->where('specialist_id', $specialist->id)
                      ->first();

    if (!$service) {
        return response()->json([
            'message' => 'Service not found or not authorized',
        ], 404);
    }

    $service->delete();

    return response()->json([
        'message' => 'Service deleted successfully',
    ], 200);
}


public function myServices()
{
    $specialist = auth('specialist')->user();

    $services = Service::where('specialist_id', $specialist->id)->get();

    return response()->json([
        'message' => 'Your services',
        'services' => $services,
    ], 200);
}


}

