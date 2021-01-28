<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/19/2021
 * Time: 9:42 PM
 */

namespace App\Services;


use App\Models\Image;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class ImageService
{
    /**
     * @param $userId
     * @param $imageName
     * @param $visibility
     * @return Image|Model
     */
    public function saveImageMeta($userId, $imageName, $visibility)
    {
        return Image::create([
            'user_id'            => $userId,
            'image_del_hash'     => uniqid('img_'),
            'image_share_hash'   => base_convert(time(), 10, 36),
            'image_name'         => $imageName,
            'public'             => $visibility
        ]);
    }
}
