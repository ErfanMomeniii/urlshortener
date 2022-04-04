<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;

class TokenService
{
    /**
     * @throws SigningException
     * @throws JsonEncodingException
     */
    private static string $expireTime;

    public function __construct($expireTime = '5Minute')
    {
        self::$expireTime = $expireTime;
    }

    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     */
    public function generateUserToken(User $user): string
    {
        $signer = new HS256(config('custom.hash_key'));
        $generator = new Generator($signer);
        $time = time();

        return $generator->generate([
            'id' => $user->id,
            'expire_seconds' => strtotime($time . (self::$expireTime))
        ]);
    }

    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidKeyException
     * @throws InvalidSignatureException
     * @throws JsonDecodingException
     */
    public function parseUserToken($userToken): array
    {
        $signer = new HS256(config('custom.hash_key'));
        $parser = new Parser($signer);

        return $parser->parse($userToken);
    }

    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidSignatureException
     * @throws InvalidKeyException
     * @throws JsonDecodingException
     */
    public function parseUserFromUserToken($userToken)
    {
        $claims = $this->parseUserToken($userToken);

        return User::find($claims['id']);
    }
}
