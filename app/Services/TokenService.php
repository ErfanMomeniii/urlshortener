<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Generator;

/**
 * Class UserTokenService
 * @package App\Services
 */
class TokenService
{
    /**
     * @throws SigningException
     * @throws JsonEncodingException
     */
    private static string $expireTime = '5Minute';

    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     */
    public function fakeUserToken(): string
    {
        $userInformations = User::factory()->count(1)->make()->first();
        $user=User::factory()->create([
            'username'=>$userInformations->username,
            'password'=>Hash::make($userInformations->password)
        ])->first();

        return $this->getUserToken($user);
    }

    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     */
    public function getUserToken(User $user): string
    {
        $signer = new HS256(env('HASH_KEY'));
        $generator = new Generator($signer);
        $time = time();

        return $generator->generate([
            'id' => $user->id,
            'expire_seconds' => strtotime($time . (self::$expireTime))
        ]);
    }

    public function setExpireTime(string $expireTime): void
    {
        self::$expireTime = $expireTime;
    }
}
