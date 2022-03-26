<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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

    public function test_user_login_should_work()
    {
        $user = User::factory()->count(1)->make()->first();
        User::factory()->create([
            'username' => $user->username,
            'password' => \Hash::make($user->password)
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
