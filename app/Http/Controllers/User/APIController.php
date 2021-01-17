<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\APIKeys;
use Illuminate\Http\Request;
use Auth;
use File;
use Storage;

class APIController extends Controller
{
    public function index()
    {
        return view('user.account.api');
    }


    public function generateSharexFile($apikey, $type)
    {
        $key = APIKeys::where('api_key', $apikey)->first();

        if (!$key || $key->user_id !== Auth::id()) {
            return redirect()->route('user.settings.api');
        }

        $configArray = [
            'Version' => '13.1.0',
            'Name' => $type === 'upload' ? 'Imagefy.me' : 's-url.app',
            'DestinationType' => $type === 'upload' ? 'ImageUploader' : 'URLShortener',
            'RequestMethod' => 'POST',
            'RequestURL' => $type === 'upload' ? 'https://imagefy.me/api/v1/images/upload' : 'https://s-url.app/api/v1/shorturl/create',
            'Headers' => [
                'x-api-key' => $apikey,
            ],
            'Body' => $type === 'upload' ? 'MultipartFormData' : 'JSON',
            'URL' => $type === 'upload' ? '$json:url$' : '$json:shortUrl$'
        ];

        $type === 'upload' ?  $configArray['FileFormName'] = 'image' : $configArray['Data'] = '{"original_url": "$input$"}';

        $configJson = json_encode($configArray, JSON_PRETTY_PRINT);

        $filename = $type === 'upload' ? public_path('/upload/json/imagefy.' . $key->user_id .  '.me.sxcu') : public_path('/upload/json/imagefy.' . $key->user_id .  '.surl.app.sxcu');

        File::put($filename,$configJson);

        return response()->download($filename);
    }

}
