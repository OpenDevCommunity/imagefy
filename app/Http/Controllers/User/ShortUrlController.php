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

        $shortUrl = ShortUrl::create([
           'user_id' => Auth::id(),
           'image_id' => request()->has('image_id') ? request()->has('image_id') : null,
           'original_url' => request()->get('original_url'),
           'short_url_hash' => uniqid('sh_'),
           'expiries_at' => request()->has('expiries_at') ? Carbon::now()->addDays(request()->get('expiries_at')) : null,
        ]);

        if (!$shortUrl) {
            toast('Failed to create short URL', 'error');
            return redirect()->back();
        }

        toast('Short URL generated successfully', 'success');
        return redirect()->back();
    }

}
