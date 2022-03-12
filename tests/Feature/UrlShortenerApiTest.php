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
    public function test_if_get_urls_with_api_work()
    {
        $this->json('get', 'api/url')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'url',
                            'code'
                        ]
                    ],
                    'status'
                ]
            );
    }

    public function test_if_add_url_with_api_work()
    {
        $response = $this->post('api/url', [
            'url' => 'https://liinkedin.com/signup'
        ]);
        $this->assertDatabaseHas('urls', [
            'url' => 'https://liinkedin.com/signup',
        ]);
    }
}
