<?php

namespace App\Http\Controllers;


use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

/**
 * Class PublicShortUrlController
 * @package App\Http\Controllers
 */
class PublicShortUrlController extends Controller
{
    /**
     * @param $uuid
     * @return RedirectResponse
     */
    public function redirectToUrl($uuid)
    {
        // Get short url from database
        $shortUrl = ShortUrl::where('short_url_hash', $uuid)->first();

        // Check if short url exists
        // TODO: Add 404
        if (!$shortUrl) {
            abort(404);
        }

        $hasExpiried = Carbon::parse($shortUrl->expiries_at)->isPast();

        // TODO: Add 404
        if ($hasExpiried && $shortUrl->expiries_at !== null) {
            abort(404);
        }

        return redirect()->away($shortUrl->original_url);
    }
}
