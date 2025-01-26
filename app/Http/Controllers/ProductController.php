<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
class ProductController extends Controller
{
    //
    public function addproduct(Request $request)
{
    // Define validation rules including the image field
    $rules = [
        'name' => 'required|min:2|max:10',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
    ];

    // Validate the request data
    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {
        return response()->json($validation->errors(), 400); // Return validation errors
    } else {
        // Create a new student instance
        $stu = new Product();
        $stu->name = $request->name;
   

        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            // Retrieve the uploaded file
            $uploadedFile = $request->file('image');

            // Upload the image to Cloudinary
            $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'productslaarveel'
            ]);

            // Get the secure URL of the uploaded image
            $imageUrl = $result->getSecurePath();

            // Store the image URL in the student's record
            $stu->image_url = $imageUrl;
        }

        // Save the student record
        if ($stu->save()) {
            return response()->json(['message' => 'Student added successfully', 'code' => 201]);
        } else {
            return response()->json(['message' => 'Operation failed', 'code' => 500]);
        }
    }
}

    public function getproducts(){
    return Product::all();
}
}