<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Adjust validation rules as needed
        ]);

        try {
            $result = Cloudinary::upload($request->file('image')->getRealPath()); 
            $imageUrl = $result->getSecurePath(); 

            return response()->json(['message' => 'Image uploaded successfully!', 'url' => $imageUrl], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}