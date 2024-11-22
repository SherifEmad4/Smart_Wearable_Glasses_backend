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

    public function show($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json($image, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('images');
        $image = Image::create([
            'user_id' => $request->user_id,
            'image' => $path,
        ]);

        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted'], 200);
    }
}
