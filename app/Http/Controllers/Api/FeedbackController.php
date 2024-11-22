<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
    public function index()
    {
        return response()->json(Feedback::all(), 200);
    }

    public function show($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json($feedback, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'address' => 'required|string',
            'content' => 'required|string',
        ]);

        $feedback = Feedback::create($request->all());

        return response()->json($feedback, 201);
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->update($request->all());

        return response()->json($feedback, 200);
    }

    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted'], 200);
    }
}
