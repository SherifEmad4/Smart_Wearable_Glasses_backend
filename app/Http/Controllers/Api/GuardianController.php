<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuardianController extends Controller
{
    //
    public function connectGuardian(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        if (!$request->code && !$request->email) {
            return response()->json([
                'message' => 'You must provide either a guardian code or email.',
            ], 422); // Unprocessable Entity
        }

        // Try finding the guardian by code or email
        $guardian = User::where('role', 'guardian')
                        ->when($request->code, function ($query) use ($request) {
                            $query->where('code', $request->code);
                        })
                        ->when($request->email, function ($query) use ($request) {
                            $query->orWhere('email', $request->email);
                        })
                        ->first();

        if (!$guardian) {
            return response()->json([
                'message' => 'Guardian not found using provided credentials.',
            ], 404);
        }

        $userId = Auth::id();
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

        // Insert connection
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
