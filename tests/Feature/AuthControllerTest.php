<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\UsefulFunctionsForTest;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations, UsefulFunctionsForTest;

    private UserFactory $userFactory;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = app()->make(UserFactory::class);
    }

    public function test_user_register_should_work()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $user->username,
                'password' => $user->password
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);
    }

    public function test_user_register_without_username_should_fail()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_register_without_password_should_fail()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $user->username
            ])
            ->assertStatus(422);
    }

    public function test_user_register_with_have_short_length_username_should_fail()
    {
        /**
         * @var User $user
         */
        $username = str_repeat("a", 4);
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $username,
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_register_with_have_over_max_length_username_should_fail()
    {
        /**
         * @var User $user
         */
        $username = str_repeat("a", 31);
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $username,
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_login_without_username_should_fail()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_login_without_password_should_fail()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'username' => $user->username
            ])
            ->assertStatus(422);
    }

    public function test_user_login_with_notfound_username_should_fail()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'username' => $user->username . '000'
            ])->assertStatus(422);
    }

    public function test_user_login_should_work()
    {
        /**
         * @var User $user
         */
        $user = $this->userFactory->make();
        $this->userFactory->create([
            'username' => $user->username,
            'password' => Hash::make($user->password)
        ]);

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'username' => $user->username,
                'password' => $user->password
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);
    }
}
