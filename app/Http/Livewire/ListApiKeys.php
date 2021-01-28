<?php

namespace App\Http\Livewire;

use App\Models\APIKey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Auth;

/**
 * Class ListApiKeys
 * @package App\Http\Livewire
 */
class ListApiKeys extends Component
{
    /**
     * API Keys
     *
     * @var array
     */
    public $apiKeys = [];

    protected $listeners = ['api-keys:delete' => 'delete'];

    /**
     * Render Blade component template
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.list-api-keys');
    }

    /**
     * Get all current user API Keys from database
     */
    public function getApiKeys()
    {
        $this->apiKeys = APIKey::where('user_id', Auth::user()->id)->get();
    }


    /**
     * Generate new random API Key
     * @return string
     */
    private function generateAPIKey()
    {
        return implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
    }

    /**
     * Store API Key in database
     */
    public function storeAPIKey()
    {
        // Store new API key in database
        $key = APIKey::create([
           'user_id' => Auth::user()->id,
           'api_key' => $this->generateAPIKey(),
        ]);

        // Check if key was created
        if (!$key) {
            array_push($this->error, [
               'message' => 'Failed to generate API Key'
            ]);
        }

        $this->getApiKeys();
    }


    /**
     * @param $id
     */
    public function confirm($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Are you sure?',
            'text'        => "You won't be able to revert this!",
            'confirmText' => 'Yes, delete!',
            'method'      => 'api-keys:delete',
            'params'      => ['id' => $id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    /**
     * Delete API Key from database
     *
     * @param $id
     */
    public function delete($id)
    {
        APIKey::destroy($id);

        $this->getApiKeys();

        $this->emit("swal:modal", [
            'icon' => 'success',
            'text' => 'API key has successfully been deleted!'
        ]);
    }

    /**
     * Component mounted hook
     */
    public function mount()
    {
        $this->getApiKeys();
    }
}
