<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/9/2021
 * Time: 4:42 PM
 */

namespace App\Helpers;


use App\Models\Image;
use Carbon\Carbon;
use Storage;

class ImageHelper
{
    public static function getFileUrl($id)
    {
        $image = Image::find($id);

        return Storage::url('images/' . $image->image_name);
    }

    public static function getFileVisibility($id)
    {
        $image = Image::find($id);

        return Storage::getVisibility('images/' . $image->image_name);
    }

    public static function generateTempLink($name, $time)
    {
        $tempUrl = Storage::temporaryUrl('images/' . $name, Carbon::now()->addMinutes($time));

        return str_replace('md-img-host.fra1.digitaloceanspaces.com', 'cdn.imagefy.me', $tempUrl);
    }

    public static function getImageFile($name)
    {
        return Storage::get('images/' . $name);
    }
}
