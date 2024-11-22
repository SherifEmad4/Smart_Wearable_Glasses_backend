<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
     // Fetch all users
     public function index()
     {
         return response()->json(User::all(), 200);
     }

     // Fetch a specific user by ID
     public function show($id)
     {
         $user = User::find($id);

         if (!$user) {
             return response()->json(['message' => 'User not found'], 404);
         }

         return response()->json($user, 200);
     }

     // Create a new user
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string',
             'phone' => 'required|string',
             'email' => 'required|string|email|unique:users,email',
             'password' => 'required|string|min:6',
             'gender' => 'required|in:male,female',
             'role' => 'required|in:user,admin',
             'is_active' => 'required|boolean',
         ]);

         $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash the password
            'gender' => $request->gender,
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

         return response()->json($user, 201);
     }

     // Update an existing user
     public function update(Request $request, $id)
    {
    // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string',
            'gender' => 'sometimes|required|string',
            'role' => 'sometimes|required|string',
            'is_active' => 'sometimes|required|boolean',
        ]);


        // Update the user fields explicitly
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('gender')) {
            $user->gender = $request->gender;
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }
        if ($request->has('is_active')) {
            $user->is_active = $request->is_active;
        }

        // Save the updated user
        $user->save();

        // Return the updated user as a response
        return response()->json($user, 200);
}


     // Delete a user
     public function destroy($id)
     {
         $user = User::find($id);

         if (!$user) {
             return response()->json(['message' => 'User not found'], 404);
         }

         $user->delete();

         return response()->json(['message' => 'User deleted'], 200);
     }
}
