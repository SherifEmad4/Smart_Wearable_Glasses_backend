<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationHistory;
use Illuminate\Http\Request;

class LocationHistoryController extends Controller
{
    //
    public function index()
    {
        return response()->json(LocationHistory::all(), 200);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $locationHistory = LocationHistory::find($id);

        if (!$locationHistory) {
            return response()->json(['message' => 'Location History not found'], 404);
        }

        return response()->json($locationHistory, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'location_id' => 'required|integer',
        ]);

        $locationHistory = LocationHistory::create($request->all());

        return response()->json($locationHistory, 201);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $locationHistory = LocationHistory::find($id);

        if (!$locationHistory) {
            return response()->json(['message' => 'Location History not found'], 404);
        }

        $locationHistory->delete();

        return response()->json(['message' => 'Location History deleted'], 200);
    }
}
