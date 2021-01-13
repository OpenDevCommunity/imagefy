<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use App\Models\UserSettings;
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
        $imagesCount = Image::where('user_id', Auth::user()->id)->count();
        $publicImagesCount = Image::where('user_id', Auth::user()->id)->where('public', true)->count();

        $recentImages = Image::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->take(5)->get();

        return view('home', [
            'imagesCount' => $imagesCount,
            'recentImages' => $recentImages,
            'publicImagesCount' => $publicImagesCount
        ]);
    }

    public function settings()
    {
        return view('user.account.settings', [
            'user' => Auth::user()
        ]);
    }

    public function uploadSettings()
    {
        $settings = UserSettings::where('user_id', Auth::id())->first();
        return view('user.library.upload-settings', [
            'settings' => $settings
        ]);
    }
}
