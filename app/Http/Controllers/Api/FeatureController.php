<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Traits\TokenValidation;  // استيراد التريت

class FeatureController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(Feature::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json(['message' => 'Feature not found'], 404);
        }

        return response()->json($feature, 200);
    }

    public function store(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $feature = Feature::create($request->all());

        return response()->json($feature, 201);
    }

    public function update(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json(['message' => 'Feature not found'], 404);
        }

        $feature->update($request->all());

        return response()->json($feature, 200);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json(['message' => 'Feature not found'], 404);
        }

        $feature->delete();

        return response()->json(['message' => 'Feature deleted'], 200);
    }
}


