<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Traits\TokenValidation;  // استيراد التريت
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(Message::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        return response()->json($message, 200);
    }

  public function store(Request $request)
    {
        $user = $this->validateToken();  // 
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'user'),
            ],
            'guardian_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'guardian'),
            ],
            'location_id' => 'required|integer|exists:locations,id',
            'text' => 'required|string',
            'sent_at' => 'sometimes|date',
            'is_sent' => 'sometimes|boolean',
        ]);

        $message = Message::create($request->all());

        broadcast(new MessageSent($message))->toOthers(); //  broadcast it!

        return response()->json($message, 201);
    }

    public function update(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $request->validate([
            'user_id' => ['required',
                            'integer',
                            Rule::exists('users', 'id')->where('role', 'user'),],
            'guardian_id' => ['required',
                                'integer',
                                Rule::exists('users', 'id')->where('role', 'guardian')],
            'location_id' => 'required|integer|exists:locations,id',
            'text' => 'required|string',
            'sent_at' => 'sometimes|date',
            'is_sent' => 'sometimes|boolean',
        ]);

        $message->update($request->all());

        return response()->json($message, 200);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted'], 200);
    }
}

