<?php

namespace App\Http\Livewire;

use Predis\Client;
use App\Models\Url;
use Livewire\Component;
use App\Services\UrlService;
use Illuminate\Redis\Connectors\PredisConnector;

class UrlCreater extends Component
{
    private $urlService;
    public $url = "";
    public $newShortUrl = "";

    protected $rules = [
        'url' => 'required|max:255'
    ];

    public function add()
    {
        UrlService::checkExistUrl('sks');
        $this->newShortUrl = "";
        $this->validate();
        $this->newShortUrl = UrlService::createShortUrl($this->url);
    }

    public function cancel()
    {
        $this->resetExcept();
    }

    public function render()
    {
        return view('livewire.url-creater');
    }
}
