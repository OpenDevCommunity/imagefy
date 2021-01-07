<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $imagesCount = Image::where('user_id', Auth::user()->id)->count();
        $recentImages = Image::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->take(5)->get();

        return view('home', [
            'imagesCount' => $imagesCount,
            'recentImages' => $recentImages
        ]);
    }
}
