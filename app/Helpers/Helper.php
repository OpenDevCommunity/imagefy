<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/10/2021
 * Time: 10:55 PM
 */

namespace App\Helpers;


use App\Models\APIKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

class Helper
{
    /**
     * @param $apiKey
     * @return HigherOrderBuilderProxy|int|mixed
     */
    public static function getUserId($apiKey)
    {
        $key = APIKeys::where('api_key', $apiKey)->first();

        return $key->user_id;
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
