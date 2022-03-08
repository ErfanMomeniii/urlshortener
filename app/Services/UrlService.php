<?php

namespace App\Services;

use Exception;
use App\Models\Url;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\UrlServiceContract;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;

/**
 * Class UrlService
 * @package App\Services
 */
class UrlService implements UrlServiceContract
{
    public function checkExistUrl($url){

        if(Url::where('url','=',trim($url))->first()==null){
            return false;
        }
        return true;

    }


    public function checkExistShortUrl($shortUrl){

        if(Url::where('short_url','=',trim($shortUrl))->first()==null){
            return false;
        }
        return true;
    }

    public function addShortUrl($url,$shortUrl){
        try{
            if(!$this->checkExistShortUrl($url)){
            Url::updateOrCreate(['url'=>$url,'short_url'=>$shortUrl]);
            }
            return true;

        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }


    }

    public function getUrl($shortUrl){
        $urlModel=Url::where('short_url','=',$shortUrl)->first();
        if($urlModel!=null){
            return $urlModel->url;
        }
        return null;
    }

    public function getShortUrl($url){

        $urlModel=Url::where('url','=',$url)->first();
        if($urlModel!=null){
            return $urlModel->short_url;
        }
        return null;
    }

    public function generateShortUrl($url)
    {
        return time();
    }

}
