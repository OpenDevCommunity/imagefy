<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\APIKeys;
use App\Models\Image;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Http\JsonResponse;
use Storage;
use Validator;

/**
 * Class ImageController
 * @package App\Http\Controllers\Api
 */
class ImageController extends Controller
{
    /**
     * @param $apiKey
     * @return HigherOrderBuilderProxy|int|mixed
     */
    private function getUserId($apiKey)
    {
        $key = APIKeys::where('api_key', $apiKey)->first();

        return $key->user_id;
    }


    /**
     * @return JsonResponse
     */
    public function uploadImage()
    {
        // No file was submitted
        if (!request()->hasFile('image')) return response()->json([
            'error' => true,
            'msg' => 'No Image file was submitted! Please try again!'
        ],422);

        // Validate file
        $validator = Validator::make(request()->all(), [
         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        // Check if file is valid
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'msg' => $validator->errors()->first()
            ], 422);
        }

        // Get file from request
        $image = request()->file('image');

        // Process file
        $imageName = time().'.'.$image->getClientOriginalExtension();

        // Store image in Digital Ocean S3 Space
        Storage::disk('spaces')->putFileAs('images', $image, $imageName, 'public');

        // Store newly uploaded image meta in database
        $createdImage = Image::create([
           'user_id' => $this->getUserId(request()->headers->get('x-api-key')),
           'image_del_hash' => uniqid('img_'),
           'image_share_hash' => uniqid('sha_'),
           'image_name' => $imageName,
           'public' => true
        ]);

        // Check if meta was added to databse
        if (!$createdImage) {
            return response()->json([
                'error' => true,
                'msg' => 'Failed to upload image! Please try again!'
            ], 500);
        }

        // Send json response back with image meta
        return response()->json([
            'error' => false,
            'msg' => 'Image uploaded successfully',
            'url' => 'http://localhost:8000/image/' . $createdImage->image_share_hash ,
            'deleteUrl' => '',
        ], 200);
    }
}
