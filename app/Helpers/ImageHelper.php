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
    /**
     * @param $id
     * @return string
     */
    public static function getFileUrl($id)
    {
        $image = Image::find($id);

        return Storage::url('images/' . $image->image_name);
    }

    /**
     * @param $id
     * @return string
     */
    public static function getFileVisibility($id)
    {
        $image = Image::find($id);

        return Storage::getVisibility('images/' . $image->image_name);
    }

    /**
     * @param $name
     * @param $time
     * @return string|string[]
     */
    public static function generateTempLink($name, $time)
    {
        $tempUrl = Storage::temporaryUrl('images/' . $name, Carbon::now()->addMinutes($time));

        return str_replace('md-img-host.fra1.digitaloceanspaces.com', 'cdn.imagefy.me', $tempUrl);
    }

    /**
     * @param $name
     * @return string
     */
    public static function getImageFile($name)
    {
        return Storage::get('images/' . $name);
    }

    /**
     * @param $visibility
     * @return string
     */
    public static function validateVisibility($visibility)
    {
        return mb_strtolower($visibility) === 'private' ? 'private' : 'public';
    }

    /**
     * @param $visibilityStr
     * @return bool
     */
    public static function convertVisibility($visibilityStr)
    {
        return $visibilityStr === 'private' ? false : true;
    }

}
