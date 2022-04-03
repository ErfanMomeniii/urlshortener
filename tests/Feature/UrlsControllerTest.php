<?php

namespace Tests\Feature;

use App\Models\Url;
use Database\Factories\UrlFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use Tests\TestCase;
use Tests\UsefulFunctionsForTest;

class UrlsControllerTest extends TestCase
{
    use DatabaseMigrations, UsefulFunctionsForTest;

    private UrlFactory $urlFactory;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->urlFactory = app()->make(UrlFactory::class);

    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_add_url_should_work()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()],
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
            ])->assertStatus(401);
    }

    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_add_url_with_invalid_token_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken() . 'a',
        ])
            ->post('api/url', [
                'path' => 'https://linkedi1n.com/signup'
            ])->assertStatus(401);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_add_url_equal_null_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()
        ])
            ->post('api/url')
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_add_url_not_in_url_form_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()
        ])
            ->post('api/url', ['path' => 'gjfhkkllooff'])
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_add_url_have_over_max_length_should_fail()
    {
        $path = str_repeat("a", 256);

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()
        ])
            ->post('api/url', ['path' => 'https://' . $path . '.com'])
            ->assertStatus(422);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_show_found_url_should_work()
    {
        /**
         * @var Url $url
         */
        $url = $this->urlFactory->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()
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
        /**
         * @var Url $url
         */
        $url = $this->urlFactory->create();

        $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->get('api/url/' . $url->code)
            ->assertStatus(401);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_show_found_url_with_invalid_token_should_fail()
    {
        /**
         * @var Url $url
         */
        $url = $this->urlFactory->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken() . 'a'
        ])
            ->get('api/url/' . $url->code)
            ->assertStatus(401);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function test_show_not_found_url_should_fail()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $this->fakeUserToken()
        ])
            ->get('api/url/a')
            ->assertStatus(404);
    }
}
