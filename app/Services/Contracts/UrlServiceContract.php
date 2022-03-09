<?php

namespace App\Services\Contracts;

/**
 * Interface UrlServiceContract
 * @package App\Services\Contracts
 */
interface UrlServiceContract
{
    public static function checkExistUrl($url);
    public static function checkExistShortUrl($shortUrl);
    public static function addShortUrl($url, $shortUrl);
    public static function getUrl($shortUrl);
    public static function getShortUrl($url);
    public static function generateShortUrl($url);
}
