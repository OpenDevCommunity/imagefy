<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/28/2021
 * Time: 12:42 AM
 */

namespace App\Services;


use Illuminate\Support\Facades\Http;

class VirusTotalService
{


    public function scanFile($file, $name)
    {
        $response = Http::attach(
            'file', $file, $name
        )->post('https://www.virustotal.com/vtapi/v2/file/scan', [
            'apikey' => config('app.virus_total_api')
        ]);

        dd($response->json());
    }


    public function getResultsByHash()
    {
        //
    }

}
