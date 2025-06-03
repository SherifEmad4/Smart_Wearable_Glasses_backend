<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Traits\TokenValidation;  // استيراد التريت

class ImageController extends Controller
{
    use TokenValidation;  // استخدام التريت للتحقق من التوكن

    public function index()
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        return response()->json(Image::all(), 200);
    }

    public function show(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json($image, 200);
    }

    public function store(Request $request)
    {
        $user = $this->validateToken();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'caption' => 'required|string|max:255',
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:4096'],
        ]);

        $path = $request->file('image')->store('public');

        $image = Image::create([
            'user_id' => $request->user_id,
            'image' => $path,
            'caption' => $request->caption,
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $image
        ], 201);
    }

    public function destroy(Request $request)
    {
        $user = $this->validateToken();  // تحقق من التوكن
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;  // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $id = $request->input('id');
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted'], 200);
    }
}

