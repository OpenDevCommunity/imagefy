<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ShortUrl;
use App\Models\User;
use App\Models\UserSetting;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class AccountController
 * @package App\Http\Controllers\User
 */
class AccountController extends Controller
{
    /**
     * Display user account dashboard
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // Get total images count
        // TODO: Refactor this
        $imagesCount = Image::where('user_id', Auth::user()->id)->count();
        $publicImagesCount = Image::where('user_id', Auth::user()->id)->where('public', true)->count();
        $privateImagesCount = Image::where('user_id', Auth::user()->id)->where('public', false)->count();
        $shortUrlCount = ShortUrl::where('user_id', Auth::id())->count();

        $recentImages = Image::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->take(5)->get();

        return view('home', [
            'imagesCount' => $imagesCount,
            'recentImages' => $recentImages,
            'publicImagesCount' => $publicImagesCount,
            'privateImagesCount' => $privateImagesCount,
            'shortUrlCount' => $shortUrlCount
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function showSettingsPage()
    {
        return view('user.account.settings', [
            'user' => Auth::user()
        ]);
    }


    /**
     * @return Application|Factory|View
     */
    public function showUploadSettingsPage()
    {
        $settings = UserSetting::where('user_id', Auth::id())->first();
        return view('user.library.upload-settings', [
            'settings' => $settings
        ]);
    }
}
