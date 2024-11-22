<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class MessageController extends Controller
{
    //
    public function index()
    {
        return response()->json(Message::all(), 200);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        return response()->json($message, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'guardian_id' => 'required|integer|exists:guardians,id',
            'location_id' => 'required|integer|exists:locations,id',
            'text' => 'required|string',
            'sent_at' => 'sometimes|required|date',
            'is_sent' => 'sometimes|required|boolean',
        ]);

        $message = Message::create($request->all());

        return response()->json($message, 201);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        // Find the message by ID
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        // Validate the input data for updating
        $request->validate([
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'guardian_id' => 'sometimes|required|integer|exists:guardians,id',
            'location_id' => 'sometimes|required|integer|exists:locations,id',
            'text' => 'sometimes|required|string',
            'sent_at' => 'sometimes|required|date',
            'is_sent' => 'sometimes|required|boolean',
        ]);

        // Update the message with validated data
        $message->update($request->all());

        return response()->json($message, 200);
    }

    public function destroy(Request $request )
    {
        $id = $request->input('id');
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted'], 200);
    }
}
