<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_register_should_work()
    {
        $user = User::factory()->count(1)->make()->first();

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
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_register_without_password_should_fail()
    {
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $user->username
            ])
            ->assertStatus(422);
    }

    public function test_user_register_with_have_short_length_username_should_fail()
    {
        $username = str_repeat("a", 4);
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $username,
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_register_with_have_over_max_length_username_should_fail()
    {
        $username = str_repeat("a", 31);
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/register', [
                'username' => $username,
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_login_without_username_should_fail()
    {
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'password' => $user->password
            ])
            ->assertStatus(422);
    }

    public function test_user_login_without_password_should_fail()
    {
        $user = User::factory()->count(1)->make()->first();

        $this->withHeader('Accept', 'application/json')
            ->post('api/user/login', [
                'username' => $user->username
            ])
            ->assertStatus(422);
    }

    public function test_user_login_should_work()
    {
        $user = User::factory()->count(1)->make()->first();
        User::factory()->create([
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
