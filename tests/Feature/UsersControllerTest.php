<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\TokenService;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use Tests\TestCase;
use Tests\UsefulFunctionsForTest;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations, UsefulFunctionsForTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->runDatabaseMigrations();
        $this->artisan('db:seed');
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_right_access_see_other_user_should_work()
    {
        /**
         * @var User $otherUser
         */
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->get('api/user/' . $otherUser->id)->assertJson([
            'username' => $otherUser->username,
            'password' => $otherUser->password
        ]);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_without_access_see_other_user_should_fail()
    {
        /**
         * @var User $otherUser
         */
        $user = app()->make(UserFactory::class)->create();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->get('api/user/' . $otherUser->id)->assertStatus(403);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_access_see_other_user_with_invalid_token_should_fail()
    {
        /**
         * @var User $otherUser
         */
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken . 'a',
        ])->get('api/user/' . $otherUser->id)->assertStatus(401);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_access_see_notfound_user_should_fail()
    {
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->get('api/user/' . 'aaa')->assertStatus(404);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_right_access_delete_other_user_should_work()
    {
        /**
         * @var User $otherUser
         */
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->delete('api/user/' . $otherUser->id)->assertStatus(200);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_without_access_delete_other_user_should_fail()
    {
        /**
         * @var User $otherUser
         */
        $user = app()->make(UserFactory::class)->create();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->delete('api/user/' . $otherUser->id)->assertStatus(403);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_access_delete_other_user_with_invalid_token_should_fail()
    {
        /**
         * @var User $otherUser
         */
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken . 'a',
        ])->delete('api/user/' . $otherUser->id)->assertStatus(401);
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     * @throws InvalidKeyException
     */
    public function test_user_with_access_delete_notfound_user_should_fail()
    {
        /**
         * @var User $otherUser
         */
        $user = $this->fakeAdminWithPermissions();
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->delete('api/user/' . 'aaa')->assertStatus(404);

    }
}
