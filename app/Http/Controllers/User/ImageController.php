<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
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
     * Handle image removal
     *
     * @param $uuid
     * @return RedirectResponse
     */
    public function deleteImage($uuid)
    {
        $image = Image::where('image_del_hash', $uuid)->first();

        // Check if image exists
        if (!$image) {
            toast('Failed to find image with UUID: ' . $uuid, 'error');
            return redirect()->route('home');
        }

        // Check if user is an owner of image
        if ($image->user_id !== Auth::id()) {
            toast('Failed to find image with UUID: ' . $uuid, 'error');
            return redirect()->route('home');
        }

        Storage::delete('images/' . $image->image_name);
        Image::destroy($image->id);

        toast('Successfully deleted image with UUID: ' . $uuid, 'success');
        return redirect()->back();

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
        $tempUrls = TempUrl::orderBy('id', 'desc')->where('image_id', $image->id)->take(5)->get();

        return view('user.library.edit', [
            'image' => $image,
            'tempUrls' => $tempUrls
        ]);
    }


    public function generateTemporaryUrl($id)
    {
        $image = Image::find($id);

        $tempUrl = ImageHelper::generateTempLink($image->image_name, request()->get('time'));

        $signedURL = \URL::signedRoute('frontend.show.image', ['uuid' => $image->image_share_hash], Carbon::now()->addMinutes((int)request()->get('time')));

        // Store temp url in databse
        $tempRecord = TempUrl::create([
           'image_id' => $image->id,
           'share_url' => $signedURL,
           'expiries_at' => Carbon::now()->addMinutes((int)request()->get('time'))
        ]);

        $shortUrl = ShortUrl::create([
           'user_id' => Auth::id(),
           'image_id' => $image->id,
           'original_url' => $signedURL,
           'short_url_hash' => uniqid('sh_'),
           'expiries_at' => Carbon::now()->addMinutes((int)request()->get('time')),
        ]);

        if (!$tempRecord) {
            toast('Failed to generate temporary URL!', 'error');
            return redirect()->back();
        }

        toast('Temporary URL has been generated successfully!', 'success');
        return redirect()->back();
    }
}
