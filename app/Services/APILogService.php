<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/29/2021
 * Time: 3:46 PM
 */

namespace App\Services;


use App\Models\APILog;
use Illuminate\Http\Request;

class APILogService
{

    /**
     * @param Request $request
     * @param $keyId
     * @param int $status
     */
    public function log(Request $request, $keyId, $status = 200)
    {
        APILog::create([
            'api_key_id' => $keyId,
            'origin' => $request->server->get('REMOTE_ADDR'),
            'method' => $request->method(),
            'endpoint' => json_encode($request->route()),
            'status' => $status,
            'headers' => json_encode($request->headers->all()),
            'body' => json_encode($request->all()),
        ]);
    }

}
