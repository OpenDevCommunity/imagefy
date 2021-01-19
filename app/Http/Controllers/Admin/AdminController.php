<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Spatie\Activitylog\Models\Activity;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        // TODO: Refactor this
        $totalUsers = User::count();
        $totalImages = Image::count();
        $totalShortURLs = ShortUrl::count();

        $recentUsers = User::orderBy('id', 'desc')->take(5)->get();
        $recentEvents = Activity::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalImages' => $totalImages,
            'totalShortURLs' => $totalShortURLs,
            'recentUsers' => $recentUsers,
            'recentEvents' => $recentEvents
        ]);
    }
}
