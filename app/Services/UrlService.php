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

    public static function checkExistUrl($url)
    {


        if (app('Redis')->executeRaw(['Exists', $url]) != null) {
            return true;
        }

        if (Url::where('url', '=', trim($url))->first() == null) {
            return false;
        }
        return true;
    }


    public static function checkExistShortUrl($shortUrl)
    {
        if (Url::where('short_url', '=', trim($shortUrl))->first() == null) {
            return false;
        }
        return true;
    }


    public static function addShortUrl($url, $shortUrl)
    {
        try {
            if (!UrlService::checkExistShortUrl($url)) {
                Url::create(['url' => $url, 'short_url' => $shortUrl]);
            }
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function createShortUrl($url)
    {
        $newShortUrl = "";
        if (!UrlService::checkExistUrl($url)) {
            $newShortUrl = UrlService::generateShortUrl($url);
            UrlService::addShortUrl($url, $newShortUrl);
        } else {
            $newShortUrl = UrlService::getShortUrl($url);
        }

        app('Redis')->set($url, $newShortUrl);
        return $newShortUrl;
    }

    public static function getUrl($shortUrl)
    {

        $urlModel = Url::where('short_url', '=', $shortUrl)->first();
        if ($urlModel != null) {
            return $urlModel->url;
        }
        return null;
    }

    public static function getShortUrl($url)
    {


        if (app('Redis')->get($url) != null) {
            return app('Redis')->get($url);
        }

        $urlModel = Url::where('url', '=', $url)->first();
        if ($urlModel != null) {
            return $urlModel->short_url;
        }
        return null;
    }

    public static function generateShortUrl($url)
    {
        return time();
    }
}
