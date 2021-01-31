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
     * @return string
     */
    private static function getDiskConfigPath()
    {
        return 'filesystems.disks.spaces.path';
    }

    /**
     * @param $id
     * @return string
     */
    public static function getFileUrl($id)
    {
        try {
            $image = Image::find($id);

            return Storage::url(config(self::getDiskConfigPath()) . $image->image_name);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $id
     * @return string
     */
    public static function getFileVisibility($id)
    {
        try {
            $image = Image::find($id);

            return Storage::getVisibility(config(self::getDiskConfigPath()) . $image->image_name);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $name
     * @param $time
     * @return string|string[]
     */
    public static function generateTempLink($name, $time)
    {
        try {
            $tempUrl = Storage::temporaryUrl(config(self::getDiskConfigPath()) . $name, Carbon::now()->addMinutes($time));

            $urlParts = parse_url($tempUrl);

            if (config('filesystems.disks.spaces.url')  !== '') {
                $spaceUrlParts = parse_url(config('filesystems.disks.spaces.url'));

                return str_replace($urlParts['host'], $spaceUrlParts['host'], $tempUrl);
            }

            return $tempUrl;
        } catch (\Exception $e) {
            return null;
        }
    }


    /**
     * @param Image $image
     * @param $length
     * @param $time
     * @return string
     */
    public static function generateCustomTempUrl(Image $image, $length, $time)
    {
        $route = 'frontend.show.image';

        switch ($length) {
            case 'minutes':
                return \URL::signedRoute($route, ['uuid' => $image->image_share_hash], Carbon::now()->addMinutes($time));
                break;
            case 'hours':
                return \URL::signedRoute($route, ['uuid' => $image->image_share_hash], Carbon::now()->addhours($time));
                break;
            case 'days':
                return \URL::signedRoute($route, ['uuid' => $image->image_share_hash], Carbon::now()->addDays($time));
                break;
            default:
                return \URL::signedRoute($route, ['uuid' => $image->image_share_hash], Carbon::now()->addMinutes(5));
        }
    }


    /**
     * @param $name
     * @return string
     */
    public static function getImageFile($name)
    {
        return Storage::get(config(self::getDiskConfigPath()) . $name);
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
        return $visibilityStr !== 'private';
    }

}
