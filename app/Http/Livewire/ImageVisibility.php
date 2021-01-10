<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImageVisibility extends Component
{
    public $image;

    public $visibility;

    public function render()
    {
        return view('livewire.image-visibility');
    }
}
