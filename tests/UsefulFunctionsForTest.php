<?php

namespace Tests;

use App\Models\User;
use App\Services\TokenService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;

trait UsefulFunctionsForTest
{

    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     * @throws BindingResolutionException
     */
    public function fakeUserToken(): string
    {
        /**
         * @var User $userInformation
         */

        $userInformation = User::factory()->count(1)->make()->first();
        $user = User::factory()->create([
            'username' => $userInformation->username,
            'password' => Hash::make($userInformation->password)
        ])->first();

        return app()->make(TokenService::class)->generateUserToken($user);
    }
}
