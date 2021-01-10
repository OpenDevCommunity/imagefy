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
     * @param $visibility
     * @return string
     */
    public function validateVisibility($visibility)
    {
        return mb_strtolower($visibility) === 'private' ? 'private' : 'public';
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function setImageVisibility($id)
    {
        // Validate
        $validator = Validator::make(request()->all(), [
           'visibility' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'msg' => $validator->errors()->first()
            ], 422);
        }

        // Get image from database
        $userId = $this->getUserId(request()->headers->get('x-api-key'));

        // Get image from database
        $image = Image::find($id);

        if (!$image) {
            return response()->json([
                'error' => true,
                'msg' => 'Image with ID: ' . $id. ' was not found!'
            ], 404);
        }

        // Check if user is image owner
        if ($userId !== $image->user_id) {
            return response()->json([
                'error' => true,
                'msg' => 'Image with ID: ' . $id . ' was not found!'
            ], 404);
        }

        Storage::setVisibility('images/' . $image->image_name, $this->validateVisibility(request()->get('visibility')));

        return response()->json([
            'error' => false,
            'msg' => 'Successfully changed image visibility to: ' . $this->validateVisibility(request()->get('visibility'))
        ], 200);
    }

    /**
     * Handle image upload
     *
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
           'user_id'            => $this->getUserId(request()->headers->get('x-api-key')),
           'image_del_hash'     => uniqid('img_'),
           'image_share_hash'   => uniqid('sha_'),
           'image_name'         => $imageName,
           'public'              => true
        ]);

        // Check if meta was added to databse
        if (!$createdImage) {
            return response()->json([
                'error' => true,
                'msg'   => 'Failed to upload image! Please try again!'
            ], 500);
        }

        // Send json response back with image meta
        return response()->json([
            'error'     => false,
            'msg'       => 'Image uploaded successfully',
            'url'       => 'http://localhost:8000/image/' . $createdImage->image_share_hash ,
            'deleteUrl' => '',
        ], 200);
    }

    /**
     * @param $uuid
     * @return JsonResponse
     */
    public function deleteImage($uuid)
    {
        $image = Image::where('image_del_hash', $uuid)->first();

        $userId = $this->getUserId(request()->headers->get('x-api-key'));

        // Check if image requested exists
        if (!$image) {
            return response()->json([
                'error' => true,
                'msg' => 'Image does not exist!'
            ], 404);
        }

        // User is not a image owner
        if ($image->user_id !== $userId) {
            return response()->json([
                'error' => true,
                'msg' => 'Image does not exist!'
            ], 404);
        }

        Storage::delete('images/' . $image->image_name);
        Image::destroy($image->id);

        return response()->json([
            'error' => false,
            'msg' => 'Image has been removed'
        ], 200);
    }
}
