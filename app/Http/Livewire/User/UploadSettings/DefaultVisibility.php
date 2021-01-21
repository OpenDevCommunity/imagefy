<?php

namespace App\Http\Livewire\User\UploadSettings;

use App\Models\UserSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Auth;

class DefaultVisibility extends Component
{

    /**
     * @var
     */
    public $visibility;

    /**
     * @var
     */
    public $settings;

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.user.upload-settings.default-visibility');
    }

    /**
     * Get user settings
     */
    public function getSettings()
    {

        $this->settings = UserSetting::where('user_id', Auth::id())->first(['default_image_visibility']);

        $this->visibility = $this->settings->default_image_visibility;

    }

    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getSettings();
    }

    /**
     * Update default image visibility on upload
     */
    public function update()
    {
        UserSetting::where('user_id', Auth::id())
            ->update([
               'default_image_visibility' => $this->visibility
            ]);

        $this->getSettings();

        activity()->causedBy(Auth::user())->performedOn($this->settings)->log('Updated default image visibility to ' .  $this->visibility);

        $this->emit("swal:modal", [
            'icon' => 'success',
            'text' => 'Default image visibility has been set to ' . $this->visibility
        ]);
    }
}
