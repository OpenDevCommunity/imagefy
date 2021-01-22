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
     * @param Image $image
     * @param $length
     * @param $time
     * @return string
     */
    public static function generateCustomTempUrl(Image $image, $length, $time)
    {
        switch ($length) {
            case 'minutes':
                return \URL::signedRoute('frontend.show.image', ['uuid' => $image->image_share_hash], Carbon::now()->addMinutes($time));
                break;
            case 'hours':
                return \URL::signedRoute('frontend.show.image', ['uuid' => $image->image_share_hash], Carbon::now()->addhours($time));
                break;
            case 'days':
                return \URL::signedRoute('frontend.show.image', ['uuid' => $image->image_share_hash], Carbon::now()->addDays($time));
                break;
            default:
                return \URL::signedRoute('frontend.show.image', ['uuid' => $image->image_share_hash], Carbon::now()->addMinutes(5));
        }
    }


    /**
     * @param $name
     * @return string
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
