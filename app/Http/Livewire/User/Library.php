<?php

namespace App\Http\Livewire\User;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Auth;


class Library extends Component
{
    public $images;

    protected $listeners = ['library:image:refresh' => 'getUserImages'];

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.library');
    }


    /**
     * Get all user images from databse
     */
    public function getUserImages()
    {
        unset($this->images);
        $this->images = Image::where('user_id', Auth::id())->get();
    }


    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getUserImages();
    }
}
