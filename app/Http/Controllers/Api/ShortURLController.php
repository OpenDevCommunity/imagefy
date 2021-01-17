<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateShortUrlRequest;
use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $apiKey = request()->headers->get('x-api-key');
        $userId = Helper::getUserIdByAPIKey($apiKey);

        // TODO: Add proper filtering
        if (request()->query->get('active') === 'true') {
            // Get all active
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

    /**
     * @param CreateShortUrlRequest $request
     * @return JsonResponse
     */
    public function createShortURL(CreateShortUrlRequest $request)
    {
        $data = $request->validated();

        $userId = Helper::getUserIdByAPIKey($request->headers->get('x-api-key'));

        $originalURLParts = parse_url(request()->get('original_url'));

        $shortUrl = ShortUrl::create([
           'user_id' => $userId,
           'original_url' => $data['original_url'],
           'short_url_hash' => Helper::generateHash(),
           'name' => $request->has('name') ? $data['name'] : $originalURLParts['host'],
           'expiries_at' => $request->has('expires') ? Helper::generateCarbonTime($data['length'], $data['time']) : null,
        ]);

        if (!$shortUrl) {
            return response()->json([
                'error' => false,
                'msg' => 'Failed to generate short URL! Please try again!'
            ], 422);
        }

        return response()->json([
            'error' => false,
            'msg' => 'Short URL has been created successfully!',
            'shortUrl' => route('frontend.shorturl', $shortUrl->short_url_hash)
        ], 200);
    }
}
