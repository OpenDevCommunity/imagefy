<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;

class ShortUrlController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $shortUrls = ShortUrl::where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(4);
        $shortURLSCount = ShortUrl::where('user_id', Auth::id())->count();
        $expiriedURLS = ShortUrl::where('expiries_at','<', \Illuminate\Support\Carbon::now())->count();

        return view('user.shorturls.index', [
            'shortUrls' => $shortUrls,
            'shortURLSCount' => $shortURLSCount,
            'expiriedURLS' => $expiriedURLS
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function createShortUrl()
    {
        // TODO: Add validation

        $originalURLParts = parse_url(request()->get('original_url'));

        $shortUrl = ShortUrl::create([
           'name' => request()->has('name') ? request()->has('name') : $originalURLParts['host'],
           'user_id' => Auth::id(),
           'image_id' => request()->has('image_id') ? request()->has('image_id') : null,
           'original_url' => request()->get('original_url'),
           'short_url_hash' => base_convert(time(), 10, 36),
           'expiries_at' => request()->has('expiries_at') ? Carbon::now()->addDays(request()->get('expiries_at')) : null,
        ]);

        if (!$shortUrl) {
            toast('Failed to create short URL', 'error');
            return redirect()->back();
        }

        activity()->performedOn($shortUrl)->causedBy(Auth::user())->log('Created new short URL: ' . route('frontend.shorturl', $shortUrl->short_url_hash));

        toast('Short URL generated successfully', 'success');
        return redirect()->back();
    }

}
