<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateShortUrlRequest;
use App\Models\ShortUrl;
use App\Services\ShortURLService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ShortURLController extends Controller
{

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = request()->headers->has('x-api-key') ? request()->headers->get('x-api-key') : null;
    }

    /**
     * Fetch all user short urls
     *
     * @return void
     */
    public function fetchAllShortUrls()
    {
        // TODO
    }

    /**
     * @param CreateShortUrlRequest $request
     * @return JsonResponse
     */
    public function createShortURL(CreateShortUrlRequest $request)
    {
        // Validate request data
        $data = $request->validated();

        // Get user ID by API Key
        $userId = Helper::getUserIdByAPIKey($this->apiKey);

        // Parse original URL submitted
        $originalURLParts = parse_url(request()->get('original_url'));

        // Get HOST name from URL Parts
        $shortName = $request->has('name') ? $data['name'] : $originalURLParts['host'];

        // Generate expiry time
        $expiryTime = $request->has('expires') ? Helper::generateCarbonTime($data['length'], $data['time']) : null;

        // Save short URL to databse
        $shortUrl = (new ShortURLService())->createShortURL($userId, $data, $shortName, $expiryTime);

        // Check if short URL was successfully saved
        if (!$shortUrl) {
            return response()->json([
                'error' => false,
                'msg' => 'Failed to generate short URL! Please try again!'
            ], 422);
        }

        // Return response
        return response()->json([
            'error' => false,
            'msg' => 'Short URL has been created successfully!',
            'shortUrl' => route('frontend.shorturl', $shortUrl->short_url_hash)
        ], 200);
    }


    /**
     * @param $uuid
     */
    public function showShortUrl($uuid)
    {
        // TODO
    }

    /**
     * @param $uuid
     */
    public function updateShortURL($uuid)
    {
        // TODO
    }

    /**
     * @param $uuid
     */
    public function deleteShortURL($uuid)
    {
        // TODO
    }
}
