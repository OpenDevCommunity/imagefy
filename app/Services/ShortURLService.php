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

class ShortURLService
{

    /**
     * @param $userId
     * @param $data
     * @param $name
     * @param $expiry
     * @return ShortUrl|Model
     */
    public function createShortURL($userId, $data, $name, $expiry)
    {
        return ShortUrl::create([
            'user_id' => $userId,
            'original_url' => $data['original_url'],
            'short_url_hash' => Helper::generateHash(),
            'name' => $name,
            'expiries_at' => $expiry
        ]);
    }

}
