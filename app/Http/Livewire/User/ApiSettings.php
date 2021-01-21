<?php

namespace App\Http\Livewire\User;

use App\Models\APIKey;
use Livewire\Component;

class ApiSettings extends Component
{
    /**
     * Current API ID
     * @var
     */
    public $keyId;

    /**
     * API Key Data
     * @var
     */
    public $apiKey;

    public $enabled;

    public $name;

    public $allowedOrigin;

    public $logsEnabled;

    public $canRead;

    public $canWrite;


    protected $rules = [
        'name' => 'required|min:3',
        'allowedOrigin' => 'required',
    ];


    public function render()
    {
        return view('livewire.user.apikey-settings');
    }


    public function getAPIKeyData()
    {
        $this->apiKey = APIKey::find($this->keyId);
    }


    public function mount()
    {
        $this->getAPIKeyData();

        $this->enabled = $this->apiKey->enabled;
        $this->name = $this->apiKey->name;
        $this->allowedOrigin = $this->apiKey->allowed_origin;
        $this->logsEnabled = $this->apiKey->logs_enabled;
        $this->canRead = $this->apiKey->can_read;
        $this->canWrite = $this->apiKey->can_write;
    }


    public function update()
    {
        $this->validate();

        APIKey::where('id', $this->keyId)
            ->update([
               'enabled' => $this->enabled ? 1 : 0,
               'name' => $this->name,
               'allowed_origin' => $this->allowedOrigin,
               'logs_enabled' => $this->logsEnabled ? 1 : 0,
               'can_read' => $this->canRead ? 1 : 0,
               'can_write' => $this->canWrite ? 1 : 0
            ]);


        $this->getAPIKeyData();


        $this->emit("swal:modal", [
            'icon' => 'success',
            'text' => 'API Key configuration was successfully updated'
        ]);
    }
}
