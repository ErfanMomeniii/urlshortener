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

class UserControllerTest extends TestCase
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
        ])->get('api/user/' . $otherUser->id, [
            'path' => 'https://linkedi1n.com/signup'
        ])->assertJson([
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
        $user = app()->make(UserFactory::class)->create();;
        $userToken = app()->make(TokenService::class)->generateUserToken($user);
        $otherUser = app()->make(UserFactory::class)->create();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $userToken,
        ])->get('api/user/' . $otherUser->id, [
            'path' => 'https://linkedi1n.com/signup'
        ])->assertStatus(403);
    }

    public function test_user_with_access_see_other_user_with_invalid_token_should_fail()
    {

    }

    public function test_user_with_access_see_notfound_user_should_fail()
    {

    }

    public function test_user_with_right_access_delete_other_user_should_work()
    {

    }

    public function test_user_without_access_delete_other_user_should_fail()
    {

    }

    public function test_user_with_access_delete_other_user_with_invalid_token_should_fail()
    {

    }

    public function test_user_with_access_delete_notfound_user_should_fail()
    {

    }
}
