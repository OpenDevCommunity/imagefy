<?php

namespace App\Http\Controllers;

use App\Models\Image;

class PublicImageController extends Controller
{
    public function showImage($uuid)
    {
        $image = Image::where('image_share_hash', $uuid)->first();

        if (!$image) {
            // Render 404
        }

        return view('view-image', [
            'image' => $image
        ]);
    }
}
