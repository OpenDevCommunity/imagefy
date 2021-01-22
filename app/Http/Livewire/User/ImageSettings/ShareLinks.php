<?php

namespace App\Http\Livewire\User\ImageSettings;

use App\Models\Image;
use Livewire\Component;

class ShareLinks extends Component
{
    public $imageId;

    public $image;

    protected $listeners = ['image:visibility' => 'getImageData'];

    public function render()
    {
        return view('livewire.user.image-settings.share-links');
    }

    public function getImageData()
    {
        $this->image = Image::find($this->imageId, ['image_share_hash', 'public']);
    }

    public function mount()
    {
        $this->getImageData();
    }
}
