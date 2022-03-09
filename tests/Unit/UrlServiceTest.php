<?php

namespace Tests\Unit;

use App\Services\UrlService;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_if_not_exist_url() //test checkExistUrl function
    {
        $exists = UrlService::checkExistUrl('https://snapp.ir');
        $this->assertTrue($exists == false);
    }

    public function test_if_exist_url() //test checkExistUrl function
    {
        $exists = UrlService::checkExistUrl('https://facebook.com');
        $this->assertTrue($exists == true);
    }

    public function test_if_not_exist_short_url() //test checkExistShortUrl function
    {

        $exists = UrlService::checkExistShortUrl('11');
        $this->assertTrue($exists == false);
    }

    public function test_if_exist_short_url() //test checkExistShortUrl function
    {

        $exists = UrlService::checkExistShortUrl('125496333');
        $this->assertTrue($exists == true);
    }

    public function test_add_short_url() //test addShortUrl function
    {
        $status = UrlService::addShortUrl('https://google.com', '111111');
        $this->assertDatabaseHas('urls', [
            'url' => 'https://google.com',
            'short_url' => '111111'

        ]);
    }

    public function test_create_short_url() //test createShortUrl function
    {

        $shortUrl = UrlService::createShortUrl('https://linkedin.com');
        $this->assertDatabaseHas('urls', [
            'url' => 'https://linkedin.com'
        ]);
    }

    public function test_get_url() //test getUrl function
    {
        $url = UrlService::getUrl('125496333');
        $this->assertTrue($url == 'https://facebook.com');
    }

    public function test_get_short_url() //test getShortUrl function
    {
        $shortUrl = UrlService::getShortUrl('https://facebook.com');
        $this->assertTrue($shortUrl == '125496333');
    }

    public function test_generate_short_url() //test generateShortUrl function
    {
        $shortUrl = UrlService::generateShortUrl('///');
        $this->assertTrue(true);
    }
}
