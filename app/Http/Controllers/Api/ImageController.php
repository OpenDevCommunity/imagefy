<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetImageVisibilityRequest;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\UserSetting;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;
use AWSImage;
use App\Models\User;
/**
 * Class ImageController
 * @package App\Http\Controllers\Api
 */
class ImageController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = request()->headers->has('x-api-key') ? request()->headers->get('x-api-key') : null;
    }

    public function getAllImages()
    {
        // TODO:
    }

    /**
     * Handle image visibility update
     *
     * @param SetImageVisibilityRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function setImageVisibility(SetImageVisibilityRequest $request ,$id)
    {
        // Validate request
        $data = $request->validated();

        // Get user id via API key
        $userId = Helper::getUserIdByAPIKey($this->apiKey);

        // Get image from database
        $image = Image::find($id);

        // No Image
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

        // Set Image visibility
        Storage::setVisibility('images/' . $image->image_name, AWSImage::validateVisibility($data['visibility']));

        // Return response
        return response()->json([
            'error' => false,
            'msg' => 'Successfully changed image visibility to: ' . AWSImage::validateVisibility($data['visibility'])
        ], 200);
    }


    /**
     * Handle image upload
     *
     * @param UploadImageRequest $request
     * @return JsonResponse
     */
    public function uploadImage(UploadImageRequest $request)
    {
        // Validate Request
        $data = $request->validated();

        // Get user ID by API Key
        $userId = Helper::getUserIdByAPIKey($this->apiKey);

        // Fetch user settings
        $settings = UserSetting::where('user_id', $userId)->first();

        // Get file from request
        $image = $data['image'];

        // Give file a name
        $imageName = time().'.'.$image->getClientOriginalExtension();

        // Store image in Digital Ocean S3 Space
        Storage::putFileAs('images', $image, $imageName, $request->has('visibility') ? $request->get('visibility') : $settings->default_image_visibility);

        // Get image visibility
        $visibility = $request->has('visibility') ? $request->get('visibility') : AWSImage::convertVisibility($settings->default_image_visibility);

        // Store newly uploaded image meta in database
        $imageMeta = (new ImageService())->saveImageMeta($userId, $imageName, $visibility);

        // Check if meta was added to databse
        if (!$imageMeta) {
            return response()->json([
                'error' => true,
                'msg'   => 'Failed to upload image! Please try again!'
            ], 500);
        }

        // Get user from database
        $user = User::find($userId);

        // Log new activity about user
        activity('API')->performedOn($imageMeta)->causedBy($user)->log('Uploaded image via API');


        // Send json response back with image meta
        return response()->json([
            'error'     => false,
            'msg'       => 'Image uploaded successfully',
            'url'       => route('frontend.show.image', $imageMeta->image_share_hash),
        ], 200);
    }

    /**
     * Handle image deletion
     *
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function deleteImage(Request $request, $uuid)
    {
        // Get User ID via API Key
        $userId = Helper::getUserIdByAPIKey($this->apiKey);

        // Get image by delete hash
        $image = Image::where('image_del_hash', $uuid)->first();

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

        // Delete image from storage
        Storage::delete('images/' . $image->image_name);

        // Delete image record
        Image::destroy($image->id);

        // Send response back
        return response()->json([
            'error' => false,
            'msg' => 'Image has been removed'
        ], 200);
    }
}
