<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationHistory;
use Illuminate\Http\Request;
use App\Traits\TokenValidation;  // استيراد التريت

class LocationHistoryController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(LocationHistory::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $locationHistory = LocationHistory::find($id);

        if (!$locationHistory) {
            return response()->json(['message' => 'Location History not found'], 404);
        }

        return response()->json($locationHistory, 200);
    }

    public function store(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'location_id' => 'required|integer|exists:locations,id',
        ]);

        $locationHistory = LocationHistory::create([
            "user_id"=>$request->user_id,
            "location_id"=>$request->location_id,
        ]);

        return response()->json($locationHistory, 201);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $locationHistory = LocationHistory::find($id);

        if (!$locationHistory) {
            return response()->json(['message' => 'Location History not found'], 404);
        }

        $locationHistory->delete();

        return response()->json(['message' => 'Location History deleted'], 200);
    }
}

