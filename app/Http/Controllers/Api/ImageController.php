<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\APIKeys;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['apikey']);
    }

    private function getUserId($apiKey)
    {
        $key = APIKeys::where('api_key', $apiKey)->first();

        return $key->user_id;
    }

    public function uploadImage(Request $request)
    {
        // No file was submitted
        if (!$request->hasFile('image')) return response()->json([
            'error' => true,
            'msg' => 'No Image file was submitted! Please try again!'
        ],422);

        // Validate file
        $validator = Validator::make($request->all(), [
         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'msg' => $validator->errors()->first()
            ], 422);
        }

        $image = $request->file('image');

        // Process file
        $imageName = time().'.'.$image->getClientOriginalExtension();

        Storage::disk('spaces')->putFileAs('images', $image, $imageName, 'public');

        $createdImage = Image::create([
           'user_id' => $this->getUserId($request->headers->get('x-api-key')),
           'image_del_hash' => uniqid('img_'),
           'image_name' => $imageName,
           'public' => true
        ]);

        // return file URL


        if (!$createdImage) {
            return response()->json([
                'error' => true,
                'msg' => 'Failed to upload image! Please try again!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'msg' => 'Image uploaded successfully',
            'url' => '',
            'deleteUrl' => ''
        ], 200);
    }
}
