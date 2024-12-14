<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\TokenValidation;  // استيراد التريت

class SettingController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(Setting::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json($setting, 200);
    }

    public function store(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'personal_assistant_enable' => 'required|boolean',
            'vibration_enable' => 'required|boolean',
            'obstacle_avoidance_enable' => 'required|boolean',
        ]);

        $setting = Setting::create([
            'user_id'=> $request->user_id,
            'personal_assistant_enable'=>$request->personal_assistant_enable,
            'vibration_enable'=>$request->vibration_enable,
            'obstacle_avoidance_enable'=>$request->obstacle_avoidance_enable,
        ]);

        return response()->json($setting, 201);
    }

    public function update(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $setting->update($request->all());

        return response()->json($setting, 200);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $setting->delete();

        return response()->json(['message' => 'Setting deleted'], 200);
    }
}

