<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Traits\TokenValidation;  // استيراد التريت

class LocationController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(Location::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json($location, 200);
    }

    public function store(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'latitude' => 'required|numeric|between:-90,90', // Latitude must be between -90 and 90
            'longitude' => 'required|numeric|between:-180,180', // Longitude must be between -180 and 180
        ]);

        $location = Location::create([
            'user_id' => $request->user_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($location, 201);
    }

    public function update(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->update($request->all());

        return response()->json($location, 200);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->delete();

        return response()->json(['message' => 'Location deleted'], 200);
    }
}

