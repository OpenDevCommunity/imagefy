<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Helpers\ImageHelper;
use Illuminate\Http\RedirectResponse;
use Auth;
use Storage;

/**
 * Class PublicImageController
 * @package App\Http\Controllers
 */
class PublicImageController extends Controller
{
    /**
     * @param $uuid
     * @return Application|Factory|View|RedirectResponse
     * @throws FileNotFoundException
     */
    public function showImage($uuid)
    {
        $image = Image::where('image_share_hash', $uuid)->first();

        if (!$image) {
            return response()->redirectTo('/');
        }

        if (ImageHelper::getFileVisibility($image->id) === 'private') {
            if ($image->user_id !== Auth::id()) {
                return response()->redirectTo('/');
            }
        }

        if (request()->query('full')) {
            $fullImg = Storage::get('images/'. $image->image_name);

            $headers = [
                'Content-Type' => 'image/png'
            ];

            return response($fullImg, 200, $headers);
        }

        // TODO: Add 404 page when image was not found

        return view('view-image', [
            'image' => $image
        ]);
    }
}
