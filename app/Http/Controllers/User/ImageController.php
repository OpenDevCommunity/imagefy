<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ShortUrl;
use App\Models\TempUrl;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Storage;
use Auth;
use App\Traits\ImageTrait;

/**
 * Class ImageController
 * @package App\Http\Controllers\User
 */
class ImageController extends Controller
{
    use ImageTrait;

    /**
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $images = Image::orderBy('created_at', 'desc')->where('user_id', Auth::id())->get();

        return view('user.library.index', [
            'images' => $images
        ]);
    }

    /**
     * Display image settings view
     *
     * @param $uuid
     * @return Application|Factory|View
     */
    public function imageSettings($uuid)
    {
        $image = Image::where('image_share_hash', $uuid)->with('shorturls')->first();

        return view('user.library.edit', [
            'image' => $image
        ]);
    }

}
