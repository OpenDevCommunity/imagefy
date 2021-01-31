<?php

namespace App\Http\Controllers;


use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class PublicShortUrlController
 * @package App\Http\Controllers
 */
class PublicShortUrlController extends Controller
{
    /**
     * @param $uuid
     * @return Application|Factory|View|RedirectResponse
     */
    public function redirectToUrl($uuid)
    {
        // Get short url from database
        $shortUrl = ShortUrl::where('short_url_hash', $uuid)->first();

        $hasExpiried = Carbon::parse($shortUrl->expiries_at)->isPast();

        // Check if short url exists
        if (!$shortUrl || ($hasExpiried && $shortUrl->expiries_at !== null)) {
            abort(404);
        }

        // Get count of same URLs shortened
        $sameUrls = ShortUrl::where('original_url', $shortUrl->original_url)->count();

        // This URL has been shared multiple times
        if ($sameUrls >= 5) {
            return $this->displayRedirecrWarning($shortUrl);
        }

        // No warning
        return redirect()->away($shortUrl->original_url);

    }


    /**
     * @param ShortUrl $shortUrl
     * @return Application|Factory|View
     */
    private function displayRedirecrWarning(ShortUrl $shortUrl)
    {
        return view('redirect', [
            'shortUrl' => $shortUrl,
        ]);
    }
}
