<?php

namespace App\Http\Livewire\User;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Auth;

class RecentImages extends Component
{
    public $recentImages;
    public $count = 5;

    protected $listeners = ['recent-images:delete' => 'delete', 'recent-images:update' => 'getUserImages'];

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.recent-images');
    }

    /**
     * Get recent 5 user images from database
     */
    public function getUserImages()
    {
        $this->recentImages = Image::orderBy('created_at', 'desc')->where('user_id', Auth::id())->take(5)->get();

        $this->emit('homestats:update');
    }

    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getUserImages();
    }

    /**
     * Display Delete Prompt
     * @param $id
     */
    public function confirm($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Are you sure?',
            'text'        => "You won't be able to revert this!",
            'confirmText' => 'Yes, delete!',
            'method'      => 'recent-images:delete',
            'params'      => ['id' => $id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    /**
     * Delete Image
     * @param $id
     */
    public function delete($id)
    {

        Image::destroy($id);

       $this->getUserImages();

        $this->emit("swal:modal", [
            'icon' => 'success',
            'text' => 'Image has successfully been deleted!'
        ]);
    }
}
