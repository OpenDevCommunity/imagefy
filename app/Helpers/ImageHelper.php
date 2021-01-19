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
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Storage;
use Config;

class ImageHelper
{
    /**
     * @param $id
     * @return string
     */
    public static function getFileUrl($id)
    {
        $image = Image::find($id);

        return Storage::url(config('filesystems.disks.spaces.path') . $image->image_name);
    }

    /**
     * @param $id
     * @return string
     */
    public static function getFileVisibility($id)
    {
        $image = Image::find($id);

        return Storage::getVisibility(config('filesystems.disks.spaces.path') . $image->image_name);
    }

    /**
     * @param $name
     * @param $time
     * @return string|string[]
     */
    public static function generateTempLink($name, $time)
    {
        $tempUrl = Storage::temporaryUrl(config('filesystems.disks.spaces.path') . $name, Carbon::now()->addMinutes($time));

        $urlParts = parse_url($tempUrl);

        if (config('filesystems.disks.spaces.url')  !== '') {
            $spaceUrlParts = parse_url(config('filesystems.disks.spaces.url'));

            return str_replace($urlParts['host'], $spaceUrlParts['host'], $tempUrl);
        }

        return $tempUrl;
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    public static function getImageFile($name)
    {
        return Storage::get(config('filesystems.disks.spaces.path') . $name);
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
