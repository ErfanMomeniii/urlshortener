<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\UrlService;

class UrlRedirecter extends Component
{

    protected $rules = [
        'shortUrl' => 'required|max:255'
    ];

    private $urlService;
    public function __construct()
    {
        $this->urlService = new UrlService();
    }
    public $shortUrl="";
    public function redirectToUrl(){
        $this->validate();
        $url=$this->urlService->getUrl(trim($this->shortUrl));
        return redirect()->away((($url!=null)?$url:$this->shortUrl));
    }
    public function render()
    {
        return view('livewire.url-redirecter');
    }
}
