<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\UrlService;

class UrlRedirecter extends Component
{
    private $urlService;
    public $shortUrl = "";

    protected $rules = [
        'shortUrl' => 'required|max:255'
    ];

    public function redirectToUrl()
    {
        $this->validate();
        $url = UrlService::getUrl(trim($this->shortUrl));
        return redirect()->away((($url != null) ? $url : $this->shortUrl));
    }

    public function render()
    {
        return view('livewire.url-redirecter');
    }
}
