<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/10/2021
 * Time: 10:55 PM
 */

namespace App\Helpers;


use App\Models\APIKey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class Helper
{
    /**
     * @param $apiKey
     * @return HigherOrderBuilderProxy|int|mixed
     */
    public static function getUserIdByAPIKey($apiKey)
    {
        return APIKey::where('api_key', $apiKey)->first()->user_id;
    }

    /**
     * @return string
     */
    public static function generateHash()
    {
        return base_convert(time(), 10, 36);
    }

    /**
     * @param $id
     * @return User|User[]|Collection|Model|null
     */
    public static function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * @param $length
     * @param $time
     * @return Carbon
     */
    public static function generateCarbonTime($length, $time)
    {
        switch ($length) {
            case 'minutes':
                return Carbon::now()->addMinutes($time);
                break;
            case 'hours':
                return Carbon::now()->addhours($time);
                break;
            case 'days':
                return Carbon::now()->addDays($time);
                break;
            default:
                return Carbon::now()->addMinutes(5);
        }
    }

}
