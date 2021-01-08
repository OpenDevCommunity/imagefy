<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
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


        $recentImages = Image::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->take(5)->get();

        return view('home', [
            'imagesCount' => $imagesCount,
            'recentImages' => $recentImages
        ]);
    }
}
