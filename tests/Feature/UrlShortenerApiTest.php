<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlShortenerApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_if_add_url_with_api_work()
    {
        $response = $this->post('api/url', [
            'url' => 'https://liinkedin.com/signup'
        ]);
        $this->assertDatabaseHas('urls', [
            'url' => 'https://liinkedin.com/signup',
        ]);
    }


    public function test_if_show_url_found()
    {
        $this->json('get', 'api/url/2')
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'url' => 'https://facebook.com',
                    'code' => '2'
                ]
            );
    }

    public function test_if_show_url_not_found()
    {
        $this->json('get', 'api/url/1')
            ->assertStatus(404)
            ->assertJsonFragment(
                [
                    'url' => null,
                    'code' => null
                ]
            );
    }
}
