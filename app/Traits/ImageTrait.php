<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/9/2021
 * Time: 6:57 PM
 */

namespace App\Traits;


use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Storage;

trait ImageTrait
{
    /**
     * Change image visibility
     *
     * @param $id
     * @return RedirectResponse
     */
    public function setImageVisibility($id)
    {
        $image = Image::find($id);

        if (!$image) {
            toast('Failed to find image with ID: ' . $id, 'error');
            return redirect()->back();
        }

        Storage::setVisibility('images/' . $image->image_name, request()->get('visibility'));

        $image->public = request()->get('visibility') === 'public';
        $image->save();

        toast('Image visibility updated to: ' . ucfirst(request()->get('visibility')), 'success');
        return  redirect()->route('user.image.settings', $image->image_share_hash);
    }
}
