<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetImageVisibilityRequest;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\UserSettings;
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
    /**
     * Handle image visibility update
     *
     * @param SetImageVisibilityRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function setImageVisibility(SetImageVisibilityRequest $request ,$id)
    {
        $data = $request->validated();
        $apiKey = $request->headers->get('x-api-key');

        $userId = Helper::getUserIdByAPIKey($apiKey);

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

        Storage::setVisibility('images/' . $image->image_name, AWSImage::validateVisibility($data['visibility']));

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
        $data = $request->validated();
        $apiKey = $request->headers->get('x-api-key');
        $userId = Helper::getUserIdByAPIKey($apiKey);

        // Fetch user settings
        $settings = UserSettings::where('user_id', $userId)->first();

        // Get file from request
        $image = $data['image'];

        // Give file a name
        $imageName = time().'.'.$image->getClientOriginalExtension();

        // Store image in Digital Ocean S3 Space
        Storage::disk('spaces')
            ->putFileAs('images', $image, $imageName, $request->has('visibility') ? $request->get('visibility') : $settings->default_image_visibility);

        // Store newly uploaded image meta in database
        $createdImage = Image::create([
           'user_id'            => $userId,
           'image_del_hash'     => uniqid('img_'),
           'image_share_hash'   => base_convert(time(), 10, 36),
           'image_name'         => $imageName,
           'public'             => $request->has('visibility') ? $request->get('visibility') : AWSImage::convertVisibility($settings->default_image_visibility)
        ]);

        // Check if meta was added to databse
        if (!$createdImage) {
            return response()->json([
                'error' => true,
                'msg'   => 'Failed to upload image! Please try again!'
            ], 500);
        }

        $user = User::find($userId);
        activity()->performedOn($createdImage)->causedBy($user)->log('Uploaded image via API');

        // Send json response back with image meta
        return response()->json([
            'error'     => false,
            'msg'       => 'Image uploaded successfully',
            'url'       => route('frontend.show.image', $createdImage->image_share_hash),
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
        $userId = Helper::getUserIdByAPIKey($request->headers->get('x-api-key'));
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

        Storage::delete('images/' . $image->image_name);
        Image::destroy($image->id);

        return response()->json([
            'error' => false,
            'msg' => 'Image has been removed'
        ], 200);
    }
}
