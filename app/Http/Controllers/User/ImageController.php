<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Storage;
use Auth;

/**
 * Class ImageController
 * @package App\Http\Controllers\User
 */
class ImageController extends Controller
{
    /**
     * @param $uuid
     * @return RedirectResponse
     */
    public function deleteImage($uuid)
    {
        $image = Image::where('image_del_hash', $uuid)->first();

        // Check if image exists
        if (!$image) {
            return redirect()->route('home')
                ->with('error', 'Failed to find image with UUID: ' . $uuid);
        }

        // Check if user is an owner of image
        if ($image->user_id !== Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'Failed to find image with UUID: ' . $uuid);
        }

        Storage::delete('images/' . $image->image_name);
        Image::destroy($image->id);

        return redirect()->back()
            ->with('success', 'Successfully deleted image with UUID: ' . $uuid);

    }
}
