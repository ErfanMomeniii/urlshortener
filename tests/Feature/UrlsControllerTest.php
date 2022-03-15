<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UrlsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_add_url_should_work()
    {
        $this->withHeader('Accept', 'application/json')
            ->post('api/url', [
                'path' => 'https://linkedin.com/signup'
            ]);

        $this->assertDatabaseHas('urls', [
            'path' => 'https://linkedin.com/signup',
        ]);
    }

    public function test_add_url_equal_null_should_fail()
    {
        $this->withHeader('Accept', 'application/json')
            ->post('api/url')
            ->assertStatus(422);
    }

    public function test_add_url_not_in_url_form_should_fail()
    {
        $this->withHeader('Accept', 'application/json')
            ->post('api/url', ['path' => 'gjfhkkllooff'])
            ->assertStatus(422);
    }

    public function test_add_url_have_over_max_length_should_fail()
    {
        $path = str_repeat("a", 256);

        $this->withHeader('Accept', 'application/json')
            ->post('api/url', ['path' => 'https://' . $path . '.com'])
            ->assertStatus(422);
    }

    public function test_show_found_url()
    {
        $url = Url::factory()->count(1)->create()->first();

        $this->json('get', 'api/url/' . $url->code)
            ->assertStatus(200)
            ->assertJson([
                'path'=>$url->path,
                'code'=>$url->code
            ]);
    }

    public function test_show_not_found_url()
    {
        $this->json('get', 'api/url/a')
            ->assertStatus(404);
    }
}
