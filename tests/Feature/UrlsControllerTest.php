<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UrlsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_add_url_should_work()
    {
        $response = $this->post('api/url', [
            'url' => 'https://linkedin.com/signup'
        ]);

        $this->assertDatabaseHas('urls', [
            'url' => 'https://linkedin.com/signup',
        ]);
    }

    public function test_add_url_equal_null_should_not_work()
    {
        $response = $this->post('api/url')
            ->assertStatus(302);
    }

    public function test_add_url_not_in_url_form_should_not_work()
    {
        $response = $this->post('api/url', ['url' => 'gjfhkkllooff'])
            ->assertStatus(302);
    }

    public function test_add_url_have_over_max_length_should_not_work()
    {
        $url = str_repeat("a", 256);
        $response = $this->post('api/url', ['url' => 'https://' . $url . '.com'])
            ->assertStatus(302);
    }

    public function test_for_check_code_length(){
        $url = Url::factory()->create();

        $this->assertTrue(strlen($url->code)==5);
    }

    public function test_show_found_url()
    {
        $url = Url::factory()->create();

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
            ->assertStatus(404);
    }
}
