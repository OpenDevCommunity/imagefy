<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Validator;

class ShortURLController extends Controller
{
    /**
     * Fetch all user short urls
     *
     * @return JsonResponse
     */
    public function fetchAllShortUrls()
    {
        $userId = Helper::getUserId(request()->headers->get('x-api-key'));

        if (request()->query->get('active') === 'true') {
            $activeUrls = ShortUrl::where('user_id', $userId)->where('expiries_at', '>=', Carbon::now())->get();

            return response()->json([
                'error' => false,
                'urls' => $activeUrls
            ], 200);
        }

        $activeUrls = ShortUrl::where('user_id', $userId)->get();

        return response()->json([
            'error' => false,
            'urls' => $activeUrls
        ], 200);
    }

    public function createShortURL()
    {
        $validatior = Validator::make(request()->all(), [
           'original_url' => 'required|url',
        ]);

        if ($validatior->fails()) {
            return response()->json([
                'error' => true,
                'msg' => $validatior->errors()->first()
            ], 422);
        }

        $originalURLParts = parse_url(request()->get('original_url'));

        $shortUrl = ShortUrl::create([
           'user_id' => Helper::getUserId(request()->headers->get('x-api-key')),
           'original_url' => request()->get('original_url'),
           'short_url_hash' => uniqid('sh_', true),
           'name' => request()->has('name') ? request()->has('name') : $originalURLParts['host'],
           'expiries_at' => request()->has('expires') ? Helper::generateCarbonTime(request()->get('length'), request()->get('time')) : null,
        ]);

        if (!$shortUrl) {
            return response()->json([
                'error' => false,
                'msg' => 'Failed to generate short URL! Please try again!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'msg' => 'Short URL has been created successfully!',
            'shortUrl' => route('frontend.shorturl', $shortUrl->short_url_hash)
        ], 200);
    }
}
