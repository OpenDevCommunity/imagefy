<?php

namespace App\Http\Livewire\User\ImageSettings;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Storage;
use Auth;

class Visibility extends Component
{
    /**
     * @var $imageId
     */
    public $imageId;

    /**
     * @var $visibility
     */
    public $visibility;

    public $image;

    /**
     * @var $imageName
     */
    public $imageName;

    /**
     * @var string[]
     */
    protected $rules = [
        'visibility' => 'required|integer'
    ];

    /**
     * Get image data from database
     */
    public function getImageData()
    {
        $this->image =  Image::find($this->imageId, ['public', 'image_name']);

        $this->visibility = (boolean)$this->image->public;
        $this->imageName = $this->image->image_name;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.image-settings.visibility');
    }

    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getImageData();
    }

    /**
     * Update image visibility
     */
    public function update()
    {
        $this->validate();

        Image::where('id', $this->imageId)
            ->update([
               'public' => $this->visibility ? true : false
            ]);

        Storage::setVisibility('images/' . $this->imageName, $this->visibility ? 'public' : 'private');

        $this->getImageData();

        $this->emit('image:visibility');

        activity('Library')->performedOn($this->image)->causedBy(Auth::user())->log('Changed image visibility to ' . ucfirst($this->visibility ? 'public' : 'private'));

        $this->emit("swal:alert", [
            'icon' => 'success',
            'text' => 'Image visibility has been changed successfully!'
        ]);
    }
}
