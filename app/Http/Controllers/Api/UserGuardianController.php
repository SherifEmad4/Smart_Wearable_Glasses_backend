<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserGuardian;
use Illuminate\Http\Request;

class UserGuardianController extends Controller
{
     /**
     * Display a listing of all user-guardian pairs.
     */
    public function index()
    {
        $userGuardians = UserGuardian::with(['user', 'guardian'])->get();

        return response()->json($userGuardians);
    }

    /**
     * Store a new user-guardian pair.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'guardian_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $guardian = User::find($request->guardian_id);

        // Ensure the user has the correct roles
        if ($user->role !== 'user' || $guardian->role !== 'guardian') {
            return response()->json(['error' => 'Invalid roles'], 400);
        }

        // Avoid duplicate entries
        if (UserGuardian::where('user_id', $request->user_id)
                ->where('guardian_id', $request->guardian_id)
                ->exists()) {
            return response()->json(['error' => 'This pair already exists'], 400);
        }

        $userGuardian = UserGuardian::create([
            'user_id' => $request->user_id,
            'guardian_id' => $request->guardian_id,
        ]);

        return response()->json($userGuardian, 201);
    }

    /**
     * Display a specific user-guardian pair.
     */
    public function show(Request $request)
    {
        $id  = $request->input('id');
        $userGuardian = UserGuardian::with(['user', 'guardian'])->find($id);

        if (!$userGuardian) {
            return response()->json(['error' => 'UserGuardian not found'], 404);
        }

        return response()->json($userGuardian);
    }

    /**
     * Update a specific user-guardian pair.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'guardian_id' => 'required|exists:users,id',
        ]);

        $userGuardian = UserGuardian::find($id);

        if (!$userGuardian) {
            return response()->json(['error' => 'UserGuardian not found'], 404);
        }

        $user = User::find($request->user_id);
        $guardian = User::find($request->guardian_id);

        if ($user->role !== 'user' || $guardian->role !== 'guardian') {
            return response()->json(['error' => 'Invalid roles'], 400);
        }

        $userGuardian->update([
            'user_id' => $request->user_id,
            'guardian_id' => $request->guardian_id,
        ]);

        return response()->json($userGuardian);
    }

    /**
     * Remove a specific user-guardian pair.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $userGuardian = UserGuardian::find($id);

        if (!$userGuardian) {
            return response()->json(['error' => 'UserGuardian not found'], 404);
        }

        $userGuardian->delete();

        return response()->json(['message' => 'UserGuardian deleted successfully']);
    }
}
