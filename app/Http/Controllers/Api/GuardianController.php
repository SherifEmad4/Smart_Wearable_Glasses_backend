<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuardianController extends Controller
{
    //
    public function connectGuardian(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $guardian = User::where('code', $request->code)
                        ->where('role', 'guardian')
                        ->first();

        if (!$guardian) {
            return response()->json([
                'message' => 'Guardian not found or invalid code.',
            ], 404);
        }

        $userId = auth()->id();
        $guardianId = $guardian->id;

        // Check if already connected
        $alreadyConnected = DB::table('users_guardians')
            ->where('user_id', $userId)
            ->where('guardian_id', $guardianId)
            ->exists();

        if ($alreadyConnected) {
            return response()->json([
                'message' => 'You are already connected to this guardian.',
            ], 409); // 409 Conflict
        }

        // If not connected yet, insert
        DB::table('users_guardians')->insert([
            'user_id' => $userId,
            'guardian_id' => $guardianId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Guardian connected successfully!',
        ], 201);
    }

}
