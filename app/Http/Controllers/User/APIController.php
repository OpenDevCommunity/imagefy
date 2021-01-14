<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\APIKeys;
use Illuminate\Http\Request;
use Auth;
use File;

class APIController extends Controller
{
    public function index()
    {
        return view('user.account.api');
    }

    public function generateSharexFile($apikey)
    {
        $key = APIKeys::where('api_key', $apikey)->where('user_id', Auth::id())->first();

        if (!$key) {
            return redirect()->back();
        }

        $config = json_encode([
            'Version' => '13.1.0',
            'Name' => 'Imagefy.me',
            'DestinationType' => 'ImageUploader',
            'RequestMethod' => 'POST',
            'RequestURL' => 'https://imagefy.me/api/v1/images/upload',
            'Headers' => [
                'x-api-key' => $apikey,
            ],
            'Body' => 'MultipartFormData',
            'FileFormName' => 'image',
            'URL' => '$json:url$'
        ]);


        File::put(public_path('/upload/json/imagefy.' . $key->user_id .  '.me.sxcu'),$config);

        File::delete('/upload/json/imagefy.' . $key->user_id .  '.me.sxcu');

        return response()->download(public_path('/upload/json/imagefy.' . $key->user_id .  '.me.sxcu'));
    }

}
