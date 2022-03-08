<?php

namespace App\Services\Contracts;

/**
 * Interface UrlServiceContract
 * @package App\Services\Contracts
 */
interface UrlServiceContract
{
    public function checkExistUrl($url);
    public function checkExistShortUrl($shortUrl);
    public function addShortUrl($url,$shortUrl);
    public function getUrl($shortUrl);
    public function getShortUrl($url);
    public function generateShortUrl($url);

}
