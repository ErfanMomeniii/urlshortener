<?php

namespace App\Http\Livewire;

use App\Models\Url;
use Livewire\Component;
use App\Services\UrlService;
class UrlCreater extends Component
{
    private $urlService;
    public $url="";
    public $newShortUrl="";

    protected $rules = [
        'url' => 'required|max:255'
    ];

    public function __construct()
    {
        $this->urlService = new UrlService();
    }

    public function mount(){
        $url="";
        $newShortUrl="";
    }

    public function add(){
        $this->newShortUrl="";
        $this->validate();
        $url=trim($this->url);
        if(!$this->urlService->checkExistUrl($url)){
            $this->newShortUrl=$this->urlService->generateShortUrl($url);
            $this->urlService->addShortUrl($url,$this->newShortUrl);
        }else{
            $this->newShortUrl=$this->urlService->getShortUrl($url);
        }

    }

    public function cancel(){
        $this->resetExcept();
    }
    public function render()
    {
        return view('livewire.url-creater');
    }
}
