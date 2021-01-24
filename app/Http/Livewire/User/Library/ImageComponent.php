<?php

namespace App\Http\Livewire\User\Library;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ImageComponent extends Component
{
    public $image;
    public $key;


    protected $listeners = ['library:image:delete' => 'delete'];

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.library.image-component');
    }


    public function toggleShareLinks()
    {
        $this->emit('show:image:sharelinks', $this->image);
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
            'method'      => 'library:image:delete',
            'params'      => ['id' => $id],
            'callback'    => '',
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Image::destroy($id);

        $this->emit('library:image:refresh');

        $this->emit("swal:alert", [
            'icon' => 'success',
            'text' => 'Image has successfully been deleted!'
        ]);
    }

}
