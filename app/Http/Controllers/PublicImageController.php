<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class PublicImageController
 * @package App\Http\Controllers
 */
class PublicImageController extends Controller
{
    /**
     * @param $uuid
     * @return Application|Factory|View
     */
    public function showImage($uuid)
    {
        $image = Image::where('image_share_hash', $uuid)->first();

        // TODO: Add 404 page when image was not found

        return view('view-image', [
            'image' => $image
        ]);
    }
}
