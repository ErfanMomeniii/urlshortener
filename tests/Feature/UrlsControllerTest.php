<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Url;

class UrlsControllerTest extends TestCase
{
    public function test_add_url_should_work()
    {
        $response = $this->post('api/url', [
            'url' => 'https://linkedin.com/signup'
        ]);
        $this->assertDatabaseHas('urls', [
            'url' => 'https://linkedin.com/signup',
        ]);
    }

    public function test_show_found_url()
    {
        $url = new Url();
        $url->url = 'https://facebook.com';
        $url->code = time() + 1;
        $url->save();
        $this->json('get', 'api/url/' . $url->code)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'url' => strval($url->url),
                    'code' => strval($url->code)
                ]
            );
    }

    public function test_show_not_found_url()
    {
        $this->json('get', 'api/url/a')
            ->assertStatus(404)
            ->assertJsonFragment(
                [
                ]
            );
    }
}
