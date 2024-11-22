<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        return response()->json(Setting::all(), 200);
    }

    public function show($id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json($setting, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'personal_assistant_enable' => 'required|boolean',
            'vibration_enable' => 'required|boolean',
            'obstacle_avoidance_enable' => 'required|boolean',
        ]);

        $setting = Setting::create([
            'user_id'=> $request->user_id,
            'personal_assistant_enable'=>$request->obstacle_avoidance_enable,
            'vibration_enable'=>$request->vibration_enable,
            'obstacle_avoidance_enable'=>$request->obstacle_avoidance_enable,
        ]);

        return response()->json($setting, 201);
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $setting->update($request->all());

        return response()->json($setting, 200);
    }

    public function destroy($id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $setting->delete();

        return response()->json(['message' => 'Setting deleted'], 200);
    }
}
