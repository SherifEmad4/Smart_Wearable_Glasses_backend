<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    //
    public function index()
    {
        return response()->json(Feature::all(), 200);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json(['message' => 'Feature not found'], 404);
        }

        return response()->json($feature, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $feature = Feature::create($request->all());

        return response()->json($feature, 201);
    }

    public function update(Request $request)
    {
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
        $id = $request->input('id');
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json(['message' => 'Feature not found'], 404);
        }

        $feature->delete();

        return response()->json(['message' => 'Feature deleted'], 200);
    }
}
