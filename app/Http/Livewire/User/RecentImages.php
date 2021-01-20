<?php

namespace App\Http\Livewire\User;

use App\Models\Image;
use Livewire\Component;
use Auth;

class RecentImages extends Component
{
    public $recentImages;
    public $count = 5;

    protected $listeners = ['recent-images:delete' => 'delete', 'recent-images:update' => 'getUserImages'];

    public function render()
    {
        return view('livewire.user.recent-images');
    }

    public function getUserImages()
    {
        $this->recentImages = Image::orderBy('created_at', 'desc')->where('user_id', Auth::id())->take(5)->get();

        $this->emit('homestats:update');
    }

    public function mount()
    {
        $this->getUserImages();
    }

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
