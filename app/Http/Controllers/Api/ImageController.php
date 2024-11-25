<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function index()
    {
        return response()->json(Image::all(), 200);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json($image, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'image' => ['required','image','mimes:png,jpg,jpeg','max:2048'],
        ]);

        $path = $request->file('image')->store('public');
        $image = Image::create([
            'user_id' => $request->user_id,
            'image' => $path,
        ]);

        return response()->json(['message' => 'Image uploaded successfully', 'path' => $path], 201);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted'], 200);
    }
}
