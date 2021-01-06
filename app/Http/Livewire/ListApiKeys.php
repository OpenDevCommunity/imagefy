<?php

namespace App\Http\Livewire;

use App\Models\APIKeys;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ListApiKeys extends Component
{
    public $apiKeys = null;
    public $error = [];

    public function render()
    {
        return view('livewire.list-api-keys');
    }

    public function getApiKeys()
    {
        $this->apiKeys = APIKeys::where('user_id', Auth::user()->id)->get();
    }

    private function generateAPIKey()
    {
        return implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
    }

    public function storeAPIKey()
    {
        $key = APIKeys::create([
           'user_id' => Auth::user()->id,
           'api_key' => $this->generateAPIKey(),
        ]);

        if (!$key) {
            array_push($this->error, [
               'message' => 'Failed to generate API Key'
            ]);
        }

        unset($this->apiKeys);
        $this->getApiKeys();
    }

    public function delete($id)
    {
        APIKeys::destroy($id);

        unset($this->apiKeys);
        $this->apiKeys = $this->getApiKeys();
    }

    public function mount()
    {
        $this->getApiKeys();
    }
}
