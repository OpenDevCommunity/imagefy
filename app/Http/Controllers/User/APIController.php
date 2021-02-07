<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiSettingsRequest;
use App\Models\APIKey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;
use File;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class APIController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('user.account.api-keys.api');
    }


    public function showAPISettings($id)
    {
        $apiKey = APIKey::find($id);

        if (!$apiKey) {
            return abort(404);
        }

        if ($apiKey->user_id !== Auth::id())
        {
            return abort(401);
        }

        return view('user.account.api-keys.edit', [
            'apikey' => $apiKey
        ]);
    }


    /**
     * @param $apikey
     * @param $type
     * @return false|string
     */
    private function configToJson($apikey, $type)
    {
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

        return json_encode($configArray, JSON_PRETTY_PRINT);
    }


    /**
     * @param $id
     * @param $type
     * @return RedirectResponse|BinaryFileResponse
     */
    public function generateSharexFile($id, $type)
    {
        // Get API Key data from
        $key = APIKey::find($id);

        // Check if user owns API Key provided
        if (!$key || $key->user_id !== Auth::id()) {
            return redirect()->route('user.settings.api');
        }

        $filename = $type === 'upload' ? public_path('/upload/json/imagefy.' . $key->user_id .  '.me.sxcu')
            : public_path('/upload/json/imagefy.' . $key->user_id .  '.surl.app.sxcu');

        File::put($filename,$this->configToJson($key->api_key, $type));

        return response()->download($filename);
    }

}
