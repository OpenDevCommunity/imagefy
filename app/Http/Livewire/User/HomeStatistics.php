<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class HomeStatistics extends Component
{
    public $totalImages = 0;
    public $totalPublicImages = 0;
    public $totalPrivateImages = 0;
    public $shortURLS = 0;

    protected $listeners = ['homestats:update' => 'updateDataStatistics'];

    public function render()
    {
        return view('livewire.user.home-statistics');
    }

    public function updateDataStatistics()
    {
        $this->totalImages = auth()->user()->Image()->count();
        $this->totalPublicImages = auth()->user()->PublicImage()->count();
        $this->totalPrivateImages = auth()->user()->PrivateImage()->count();
        $this->shortURLS = auth()->user()->ShortUrl()->count();
    }

    public function mount()
    {
        $this->updateDataStatistics();
    }
}
