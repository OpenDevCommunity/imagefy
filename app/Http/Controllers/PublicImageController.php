<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Helpers\ImageHelper;
use Illuminate\Http\RedirectResponse;
use Auth;
use Illuminate\Http\Response;
use Storage;

/**
 * Class PublicImageController
 * @package App\Http\Controllers
 */
class PublicImageController extends Controller
{

    /**
     * @param Image $image
     * @return Application|ResponseFactory|Response
     */
    public function showFullImage(Image $image)
    {
        $fullImg = Storage::get('images/'. $image->image_name);

        $headers = [
            'Content-Type' => 'image/png'
        ];

        return response($fullImg, 200, $headers);
    }

    /**
     * @param Image $image
     * @return Application|Factory|View
     */
    public function renderImagePage(Image $image)
    {
        return view('view-image', [
            'image' => $image
        ]);
    }

    /**
     * @param $uuid
     * @return Application|ResponseFactory|Response|void|RedirectResponse
     */
    public function showImage($uuid)
    {
        $image = Image::where('image_share_hash', $uuid)->with('user')->first();

        if (!$image || (!$image->public && Auth::guest() && Auth::id() !== $image->user_id && !request()->get('expires'))) {
            return abort(404);
        }

        if (ImageHelper::getFileVisibility($image->id) === 'private') {
            if (request()->query('expires') && !Carbon::createFromTimestamp(request()->query('expires'))->isPast()) {

                if (request()->query('full')) {
                    return $this->showFullImage($image);
                }

                return $this->renderImagePage($image);
            }

            if ($image->user_id !== Auth::id()) {
               return abort(404);
            }
        }

        if (request()->query('full')) {
            return $this->showFullImage($image);
        }

        return $this->renderImagePage($image);
    }
}
