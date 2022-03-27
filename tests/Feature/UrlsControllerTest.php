<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Services\TokenService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use Tests\TestCase;

class UrlsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_add_url_should_work()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()],
        )
            ->post('api/url', [
                'path' => 'https://linkedin.com/signup'
            ]);

        $this->assertDatabaseHas('urls', [
            'path' => 'https://linkedin.com/signup',
        ]);
    }

    public function test_add_url_without_token_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post('api/url', [
                'path' => 'https://linkedi1n.com/signup'
            ])
        ->assertStatus(401);
    }

    public function test_add_url_with_invalid_token_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken().'a',
        ])
            ->post('api/url', [
                'path' => 'https://linkedi1n.com/signup'
            ])
            ->assertStatus(401);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_add_url_equal_null_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()
        ])
            ->post('api/url')
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_add_url_not_in_url_form_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()
        ])
            ->post('api/url', ['path' => 'gjfhkkllooff'])
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_add_url_have_over_max_length_should_fail()
    {
        $path = str_repeat("a", 256);

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()
        ])
            ->post('api/url', ['path' => 'https://' . $path . '.com'])
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_show_found_url_should_work()
    {
        $url = Url::factory()->count(1)->create()->first();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()
        ])
            ->get('api/url/' . $url->code)
            ->assertStatus(200)
            ->assertJson([
                'path' => $url->path,
                'code' => $url->code
            ]);
    }

    public function test_show_found_url_without_token_should_fail()
    {
        $url = Url::factory()->count(1)->create()->first();

        $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->get('api/url/' . $url->code)
            ->assertStatus(401);
    }

    public function test_show_found_url_with_invalid_token_should_fail()
    {
        $url = Url::factory()->count(1)->create()->first();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken().'a'
        ])
            ->get('api/url/' . $url->code)
            ->assertStatus(401);
    }
    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function test_show_not_found_url_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => (new TokenService())->fakeUserToken()
        ])
            ->get('api/url/a')
            ->assertStatus(404);
    }
}
