<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/19/2021
 * Time: 10:00 PM
 */

namespace App\Services;


use App\Models\ShortUrl;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class ShortURLService
{

    /**
     * @param $userId
     * @param $originalUrl
     * @param $name
     * @param $expiry
     * @param null $imageId
     * @return ShortUrl|Model
     */
    public function createShortURL($userId, $originalUrl, $name, $expiry, $imageId = null)
    {
        return ShortUrl::create([
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'short_url_hash' => Helper::generateHash(),
            'image_id' => $imageId,
            'name' => $name,
            'expiries_at' => $expiry
        ]);
    }

}
