<?php

namespace App\Http\Livewire\User\ImageSettings;

use App\Models\Image;
use App\Models\ShortUrl;
use App\Services\ShortURLService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use AWSImage;
use Auth;
use Helper;

class TemporaryUrls extends Component
{
    public $imageId;

    public $image;

    public $time;

    public $length;

    protected $listeners = ['temporary-url:delete' => 'delete'];

    protected $rules = [
      'time' => 'required|integer',
      'length' => 'required|in:minutes,hours,days,'
    ];


    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.image-settings.temporary-urls');
    }


    /**
     * Get image data with short URLS
     */
    public function getImageData()
    {
        $this->image = Image::where('id', $this->imageId)->with('shorturls')->first();
    }


    /**
     * Generate temporary URL for image
     */
    public function generateTempURL()
    {
        $this->validate();

        $signedUrl = AWSImage::generateCustomTempUrl($this->image, $this->length, $this->time);

        $parsedURL = parse_url($signedUrl);

        $shortUrl = (new ShortURLService())->createShortURL(Auth::id(), $signedUrl, $parsedURL['host'], Helper::generateCarbonTime($this->length, $this->time), $this->imageId);

        activity('SURL')->causedBy(Auth::user())->performedOn($shortUrl)->log('Generated Short URL');

        $this->getImageData();

        $this->dispatchBrowserEvent('tempUrlModal');

        $this->emit("swal:alert", [
            'icon' => 'success',
            'text' => 'Temporary URL has been generated successfully!'
        ]);
    }

    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getImageData();
    }

    /**
     * @param $id
     */
    public function confirmDelete($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Are you sure?',
            'text'        => "You won't be able to revert this!",
            'confirmText' => 'Yes, delete!',
            'method'      => 'temporary-url:delete',
            'params'      => ['id' => $id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        ShortUrl::destroy($id);

        $this->getImageData();

        $this->emit("swal:alert", [
            'icon' => 'success',
            'text' => 'Temporary URL has been deleted successfully!'
        ]);
    }
}
