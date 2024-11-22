<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    //
     // Fetch all guardians
     public function index()
     {
         return response()->json(Guardian::all(), 200);
     }

     // Fetch a specific guardian by ID
     public function show(Request $request)
     {
        $id = $request->input('id');
        $guardian = Guardian::find($id);

         if (!$guardian) {
             return response()->json(['message' => 'Guardian not found'], 404);
         }

         return response()->json($guardian, 200);
     }

     // Create a new guardian
     public function store(Request $request)
     {
        $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string|email|unique:guardians,email',
                'user_id' => 'required|exists:users,id',
                'receive_location_updates' => 'required|boolean',
         ]);

         $guardian = Guardian::create([
            'name' => $request->name,
            'phone'=> $request->phone,
            'email'=> $request->email,
            'user_id'=>$request->user_id,
            'receive_location_updates'=>$request->receive_location_updates,
        ]);

         return response()->json($guardian, 201);
     }

     // Update an existing guardian
     public function update(Request $request)
     {
        $id = $request->input('id');
         // Find the guardian by ID
         $guardian = Guardian::find($id);

         if (!$guardian) {
             return response()->json(['message' => 'Guardian not found'], 404);
         }

         // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email|unique:guardians,email,' . $id,
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'receive_location_updates' => 'sometimes|required|boolean',
        ]);


        // Update the guardian with the validated data
        $guardian->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => $request->user_id,
            'receive_location_updates' => $request->receive_location_updates,
        ]);

        // Return the updated guardian as a response
        return response()->json($guardian, 200);
     }

     // Delete a guardian
     public function destroy($id)
     {
         $guardian = Guardian::find($id);

         if (!$guardian) {
             return response()->json(['message' => 'Guardian not found'], 404);
         }

         $guardian->delete();

         return response()->json(['message' => 'Guardian deleted'], 200);
     }
}
